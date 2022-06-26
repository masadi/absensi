<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Pendaftar;
use App\User;
use App\Role;
use App\Sekolah_pilihan;
use App\Dokumen;
use App\Jalur;
use App\Status;
use App\Piagam;
use Carbon\Carbon;
use Validator;
use File;

class PendaftarController extends Controller
{
    public function index(Request $request){
        $user = User::find($request->user_id);
        $all_data = Sekolah_pilihan::with(['pendaftar' => function($query){
            $query->with(['user']);
        }, 'jalur', 'status', 'sekolah', 'dokumen' => function($query){
            $query->with(['komponen']);
        }])->where(function($query){
            if(request()->sekolah_id){
                $query->where('tampil', 1);
                $query->where('sekolah_id', request()->sekolah_id);
                /*
                $query->where('pilihan_ke', 1);
                $query->whereDoesntHave('status', function($query){
                    $query->where('nama', 'Terima');
                    $query->orWhere('nama', 'Perbaikan');
                });
                $query->orWhere(function($query){
                    $query->where('pilihan_ke', 2);
                    $query->where('sekolah_id', request()->sekolah_id);  
                });
                */
            }
            if(request()->jenjang){
                $query->whereHas('pendaftar', function($query){
                    $query->where('bentuk_pendidikan_id', request()->jenjang);
                });
            }
            if(request()->jalur){
                $query->where('jalur_id', request()->jalur);
            }
            if(request()->status){
                if(request()->status == 99){
                    $query->whereNull('status_id');
                } else {
                    $query->where('status_id', request()->status);
                }
            }
            if(request()->bentuk_pendidikan_id){
                $query->whereHas('pendaftar', function($query){
                    $query->where('bentuk_pendidikan_id', request()->bentuk_pendidikan_id);
                });
            }
        })->orderBy(request()->sortby, request()->sortbydesc)
        ->when(request()->q, function($query) {
            $all_data = $query->whereHas('pendaftar', function($query){
                $query->whereIn('user_id', function($query){
                    $query->select('user_id')->from('users')->where('name', 'LIKE', '%' . request()->q . '%')->orWhere('username', 'LIKE', '%' . request()->q . '%');
                });
            })
            ->orWhereIn('sekolah_id', function($query){
                $query->select('sekolah_id')->from('sekolah')->where('nama', 'LIKE', '%' . request()->q . '%')->orWhere('npsn', 'LIKE', '%' . request()->q . '%');
            })
            ->orWhereIn('jalur_id', function($query){
                $query->select('id')->from('jalur')->where('nama', 'LIKE', '%' . request()->q . '%');
            });
        })->paginate(request()->per_page);
        $jenjang = ($user->bentuk_pendidikan_id == 5) ? 'sd' : 'smp';
        $all_jalur = [];
        if(request()->jenjang){
            $all_jalur = Jalur::select('id', 'nama')->where('bentuk_pendidikan_id', request()->jenjang)->get();
        } else {
            $all_jalur = Jalur::select('id', 'nama')->where('bentuk_pendidikan_id', $user->bentuk_pendidikan_id)->get();
        }
        return response()->json([
            'status' => 'success', 
            'data' => $all_data, 
            'jenjang' => $jenjang, 
            'meta_jenjang' => request()->jenjang,
            'jalur' => request()->jalur,
            'all_jalur' => $all_jalur,
            'all_status' => Status::select('id', 'nama')->get(),
        ]);
    }
    public function hapus_riwayat(Request $request){
        $sekolah_pilihan = Sekolah_pilihan::find($request->sekolah_pilihan_id);
        if($sekolah_pilihan->delete()){
            $response = [
                'icon' => 'success', 
                'text' => 'Riwayat pendaftaran berhasil dihapus',
                'title' => 'Berhasil',
            ];
        } else {
            $response = [
                'icon' => 'danger', 
                'text' => 'Riwayat pendaftaran gagal dihapus',
                'title' => 'Gagal',
            ];
        }
        return response()->json($response);
    }
    public function show($id){
        $data = Pendaftar::with(['user' => function($query){
            $query->with(['desa.parrentRecursive']);
        }, 'sekolah_pilihan' => function($query){
            $query->with(['sekolah', 'jalur', 'status']);
        }, 'dokumen.komponen', 'status'])->find($id);
        return response()->json(['status' => 'success', 'data' => $data]);
    }
    public function buka_kunci(Request $request){
        $sekolah_pilihan = Sekolah_pilihan::find($request->sekolah_pilihan_id);
        $sekolah_pilihan->kunci = 0;
        if($sekolah_pilihan->save()){
            $response = [
                'icon' => 'success', 
                'text' => 'Kunci pendaftaran berhasil dibuka',
                'title' => 'Berhasil',
            ];
        } else {
            $response = [
                'icon' => 'danger', 
                'text' => 'Kunci pendaftaran gagal dibuka',
                'title' => 'Gagal',
            ];
        }
        return response()->json($response);
    }
    public function proses(Request $request){
        $jml_dokumen = $request->jml_dokumen;
        $jml_piagam = $request->jml_piagam;
        $messages = [
            'pendaftar_id.required'	=> 'Data Pendaftar tidak ditemukan didatabase!',
            'status_id.required'	=> 'Status Dokumen harus dipilih',
            'status_id.*.required'	=> 'Status Dokumen harus dipilih',
            'status_id.min'	=> 'Status Dokumen harus dipilih minimal '.$jml_dokumen.' isian',
            'status_id_piagam.required'	=> 'Status Piagam harus dipilih',
            'status_id_piagam.*.required'	=> 'Status Piagam harus dipilih',
            'status_id_piagam.min'	=> 'Status Piagam harus dipilih minimal '.$jml_piagam.' isian',
        ];
        $validator = Validator::make(request()->all(), [
            'pendaftar_id' => 'required',
            'status_id'    => 'required|array|min:'.$jml_dokumen,
            'status_id_piagam'  => ($jml_piagam) ? 'required|array|min:'.$jml_piagam : 'nullable',
        ],
        $messages
        )->validate();
        $all_data = $request->all();
        $diterima = 0;
        $perbaikan = 0;
        $tolak = 0;
        foreach($request->status_id as $dokumen_id => $status_id){
            $dokumen = Dokumen::with('komponen')->find($dokumen_id);
            if(isset($request->catatan[$dokumen_id])){
                $dokumen->catatan = $request->catatan[$dokumen_id];
            }
            $dokumen->status_id = $status_id['id'];
            $find_status = Status::find($status_id['id']);
            if($find_status->nama == 'Terima'){
                $diterima++;
                $dokumen->skor = $dokumen->komponen->skor;
            }
            if($find_status->nama == 'Perbaikan'){
                $perbaikan++;
            }
            if($find_status->nama == 'Tolak'){
                $tolak++;
            }
            $dokumen->save();
        }
        foreach($request->status_id_piagam as $piagam_id => $status_id_piagam){
            $piagam = Piagam::find($piagam_id);
            $piagam->status_id = $status_id_piagam['id'];
            if(isset($request->catatan_piagam[$piagam_id])){
                $piagam->catatan = $request->catatan_piagam[$piagam_id];
            }
            $piagam->save();
        }
        $sekolah_pilihan = Sekolah_pilihan::find($request->sekolah_pilihan_id);
        $sekolah_lain = Sekolah_pilihan::where('pendaftar_id', $sekolah_pilihan->pendaftar_id)->where('sekolah_pilihan_id', '<>', $request->sekolah_pilihan_id)->first();
        if(count($request->status_id) == $diterima){
            $find_status_terima = Status::where('nama', 'Terima')->first();
            $sekolah_pilihan->status_id = $find_status_terima->id;
            $sekolah_pilihan->verifikator_id = $request->user_id;
            $sekolah_pilihan->save();
            if($sekolah_lain){
                $sekolah_lain->tampil = 0;
                $sekolah_lain->save();
            }
        } elseif($perbaikan){
            $find_status_perbaikan = Status::where('nama', 'Perbaikan')->first();
            $sekolah_pilihan->status_id = $find_status_perbaikan->id;
            $sekolah_pilihan->verifikator_id = $request->user_id;
            $sekolah_pilihan->kunci = 0;
            $sekolah_pilihan->save();
        } elseif($tolak){
            $find_status_tolak = Status::where('nama', 'Tolak')->first();
            $sekolah_pilihan->status_id = $find_status_tolak->id;
            $sekolah_pilihan->verifikator_id = $request->user_id;
            $sekolah_pilihan->save();
            if($sekolah_lain){
                $sekolah_lain->tampil = 1;
                $sekolah_lain->save();
            }
        }
        return response()->json(['status' => 'success', 'message' => 'Proses verifikasi berhasil disimpan', 'data' => $all_data]);
    }
    public function upload(Request $request){
        $config = config('ppdb');
        $messages = [
            'bentuk_pendidikan_id.required'	=> 'Jenjang Pendidikan tidak boleh kosong',
            'sekolah_id.required'	=> 'Sekolah tidak boleh kosong',
            'file.required'	=> 'File Upload tidak boleh kosong',
            'file.mimes'	=> 'File Upload harus berekstensi .XLSX',
        ];
        $validator = Validator::make(request()->all(), [
            'file' => 'required|mimes:xlsx',
            'bentuk_pendidikan_id' => 'required',
            'sekolah_id' => 'required',
        ],
        $messages
        )->validate();
        $file = $request->file('file');
        $fileExcel = Carbon::now()->timestamp . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move('uploads', $fileExcel);
        $all_data = (new FastExcel)->import('uploads/'.$fileExcel);
        $sekolah = User::find($request->user_id);
        $i=0;
        foreach($all_data as $data){
            $jalur = Jalur::where('nama', $data['Jalur Pendaftaran'])->first();
            if($jalur){
                $nik = $data['NIK (isi tanda kutip satu (\') sebelum mengisi NIK'];
                $random = Str::random(5);
                $user = User::updateOrCreate(
                    [
                        'name' => $data['Nama Lengkap'],
                        'username' => $nik,
                        'email' => $nik.'@'.$config['domain'],
                        'jenis_kelamin' => $data['Jenis Kelamin'],
                        'alamat' => $data['Nama Lengkap'],
                        'tempat_lahir' => $data['Tempat Lahir'],
                        'tanggal_lahir' => ($data['Tanggal Lahir (dd/mm/yyyy)']) ? $data['Tanggal Lahir (dd/mm/yyyy)']->format('Y-m-d') : NULL,
                    ],
                    [
                        'bentuk_pendidikan_id' => $request->bentuk_pendidikan_id,
                        'sandi' => $random,
                        'password' => Hash::make($random),
                    ]
                );
                if(!$user->hasRole('siswa')){
                    $role = Role::where('name', 'siswa')->first();
                    $user->attachRole($role);
                }
                $find = Pendaftar::where('user_id', $user->user_id)->first();
                $jenjang = ($request->bentuk_pendidikan_id == 5) ? 'SD' : 'SMP';
                $count_pendaftar = Pendaftar::where('bentuk_pendidikan_id', $request->bentuk_pendidikan_id)->where('user_id', '<>', $user->user_id)->count() + 1;
                $nomor_pendaftaran = $jenjang.'-'.str_pad($count_pendaftar,5,0,STR_PAD_LEFT).'-'.date('d-m-Y');
                if($find){
                    $find->bentuk_pendidikan_id = $request->bentuk_pendidikan_id;
                    $find->nomor_pendaftaran = $nomor_pendaftaran;
                    $all_data = $find->save();
                    $sekolah_pilihan = Sekolah_pilihan::updateOrCreate(
                        [
                            'pendaftar_id' => $find->pendaftar_id,
                            'sekolah_id' => $request->sekolah_id,
                        ],
                        [
                            //'pilihan_ke' => ($hitung_sekolah_pilihan + 1),
                            'jalur_id' => $jalur->id,
                        ]
                    );
                } else {
                    $all_data = Pendaftar::create(
                        [
                            'user_id' => $user->user_id,
                            'nomor_pendaftaran' => $nomor_pendaftaran,
                            //'jalur_id' => $request->jalur_id['id'],
                            'bentuk_pendidikan_id' => $request->bentuk_pendidikan_id,
                            //'pilihan_1' => $request->pilihan_1['sekolah_id'],
                            //'pilihan_2' => $request->pilihan_2['sekolah_id'],
                            'jenis_kelamin' => $user->jenis_kelamin,
                        ]
                    );
                    $sekolah_pilihan = Sekolah_pilihan::updateOrCreate(
                        [
                            'pendaftar_id' => $all_data->pendaftar_id,
                            'sekolah_id' => $request->sekolah_id,
                        ],
                        [
                            //'pilihan_ke' => 1,
                            'jalur_id' => $jalur->id,
                        ]
                    );
                }
                $i++;
            }
        }
        File::delete(public_path('uploads/'.$fileExcel));
        if($i){
            $response = [
                'icon' => 'success', 
                'message' => 'Import pendaftar berhasil'
            ];
        } else {
            $response = [
                'icon' => 'error', 
                'message' => 'Import pendaftar gagal'
            ];
        }
        return response()->json($response);
    }
    public function update_nilai(Request $request){
        $sekolah_pilihan = Sekolah_pilihan::find($request->sekolah_pilihan_id);
        $sekolah_pilihan->titipan = $request->nilai_akhir;
        if($sekolah_pilihan->save()){
            $response = [
                'icon' => 'success', 
                'text' => 'Nilai berhasil disimpan',
                'title' => 'Berhasil',
            ];
        } else {
            $response = [
                'icon' => 'danger', 
                'text' => 'Nilai gagal disimpan',
                'title' => 'Gagal',
            ];
        }
        return response()->json($response);
    }
}
