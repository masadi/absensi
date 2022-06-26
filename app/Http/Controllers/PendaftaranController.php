<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Sekolah;
use App\Pendaftar;
use App\Jalur;
use App\Komponen;
use App\User;
use App\Role;
use App\Dokumen;
use App\Status;
use App\Sekolah_pilihan;
use App\Wilayah;
use App\Jenis_prestasi;
use App\Piagam;
use App\Tingkat_prestasi;
use App\Mata_pelajaran;
use App\HelperModel;
use App\Nilai;
use App\Jenis_kejuaraan;
use Carbon\Carbon;
use Validator;
use File;

class PendaftaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = User::find(request()->user_id);
        $jalur = Jalur::where('bentuk_pendidikan_id', $user->bentuk_pendidikan_id)->where('tautan', $request->tautan)->first();
        $all_data = [
            'pendaftar' => Pendaftar::with(['user', 'sekolah_pilihan_single' => function($query) use ($jalur){
                $query->with(['jenis_prestasi', 'jalur', 'sekolah']);
                $query->where('jalur_id', $jalur->id);
            }, 'dokumen'])->withCount(['sekolah_pilihan', 'sekolah_pilihan as pilihan_ke' => function($query) use ($jalur){
                $query->where('jalur_id', '<>', $jalur->id);
            }])->where('user_id', request()->user_id)->first(),
            'pengguna' => $user,
            'jalur' => $jalur,
            'jenis_prestasi' => ($request->tautan == 'prestasi') ? Jenis_prestasi::select('id as value', 'nama')->get() : [],
            //'mata_pelajaran' => ($request->tautan == 'prestasi') ? Mata_pelajaran::get() : [],
        ];
        return response()->json(['status' => 'success', 'data' => $all_data]);
    }

    public function store(Request $request)
    {
        $messages = [
            //'bentuk_pendidikan_id.bentuk_pendidikan_id.required'	=> 'Jenjang Sekolah tidak boleh kosong',
            'jenis_prestasi.required'	=> 'Jenis Prestasi tidak boleh kosong',
            //'akreditasi.required'	=> 'Nilai Akreditasi Sekolah tidak boleh kosong',
            'sekolah_id.required'	=> 'Sekolah Tujuan tidak boleh kosong',
            'tanggal.*.required'	=> 'Tanggal Terbit Dokumen tidak boleh kosong',
            'tanggal.*.date'	=> 'Tanggal Terbit Dokumen tidak valid',
            'files.*.required'	=> 'File Upload tidak boleh kosong',
            'files.*.mimes'	=> 'File Upload harus berekstensi .jpeg/.jpg/.png/.pdf',
            //'pilihan_2.sekolah_id.required'	=> 'Sekolah Pilihan 2 tidak boleh kosong',
        ];
        $validator = Validator::make(request()->all(), [
            //'bentuk_pendidikan_id.bentuk_pendidikan_id' => 'required',
            //'jalur_id.id' => 'required',
            'sekolah_id' => 'required',
            'files.*' => 'required|mimes:jpeg,jpg,png,pdf',
            'tanggal.*' => 'required|date',
            'jenis_prestasi' => ($request->tautan == 'prestasi') ? 'required' : 'nullable',
            //'akreditasi' => ($request->tautan == 'prestasi' && $request->jenis_prestasi == 1) ? 'required' : 'nullable',
            //'pilihan_2.sekolah_id' => 'required',
        ],
        $messages
        )->validate();
        $user = User::find($request->user_id);
        $find = Pendaftar::where('user_id', $request->user_id)->first();
        $jenjang = ($user->bentuk_pendidikan_id == 5) ? 'SD' : 'SMP';
        $count_pendaftar = Pendaftar::where('bentuk_pendidikan_id', $user->bentuk_pendidikan_id)->where('user_id', '<>', $request->user_id)->count() + 1;
        $nomor_pendaftaran = $jenjang.'-'.str_pad($count_pendaftar,5,0,STR_PAD_LEFT).'-'.date('d-m-Y');
        if($find){
            $pendaftar_id = $find->pendaftar_id;
            //$hitung_sekolah_pilihan = Sekolah_pilihan::where('pendaftar_id', $find->pendaftar_id)->count();
            $find->bentuk_pendidikan_id = $user->bentuk_pendidikan_id;
            $find->nomor_pendaftaran = $nomor_pendaftaran;
            $all_data = $find->save();
            $sekolah_pilihan = Sekolah_pilihan::updateOrCreate(
                [
                    'pendaftar_id' => $find->pendaftar_id,
                    'jalur_id' => $request->jalur_id,
                ],
                [
                    //'akreditasi' => $request->akreditasi,
                    'sekolah_id' => $request->sekolah_id,
                    'pilihan_ke' => $request->pilihan_ke,
                    'tampil' => ($request->pilihan_ke == 1) ? 1 : 0,
                    'jenis_prestasi_id' => $request->jenis_prestasi,
                ]
            );
            $this->simpan_dokumen($request, $find, $sekolah_pilihan);
        } else {
            $all_data = Pendaftar::create(
                [
                    'user_id' => $request->user_id,
                    'nomor_pendaftaran' => $nomor_pendaftaran,
                    //'jalur_id' => $request->jalur_id['id'],
                    'bentuk_pendidikan_id' => $user->bentuk_pendidikan_id,
                    //'pilihan_1' => $request->pilihan_1['sekolah_id'],
                    //'pilihan_2' => $request->pilihan_2['sekolah_id'],
                    'jenis_kelamin' => $user->jenis_kelamin,
                ]
            );
            $pendaftar_id = $all_data->pendaftar_id;
            $sekolah_pilihan = Sekolah_pilihan::updateOrCreate(
                [
                    'pendaftar_id' => $all_data->pendaftar_id,
                    'jalur_id' => $request->jalur_id,
                ],
                [
                    //'akreditasi' => $request->akreditasi,
                    'sekolah_id' => $request->sekolah_id,
                    'pilihan_ke' => $request->pilihan_ke,
                    'tampil' => ($request->pilihan_ke == 1) ? 1 : 0,
                    'jenis_prestasi_id' => $request->jenis_prestasi,
                ]
            );
            $this->simpan_dokumen($request, $all_data, $sekolah_pilihan);
        }
        $this->simpan_prestasi($request, $pendaftar_id);
        $nilai_rapor = NULL;
        /*$nilai_rapor = ((array) json_decode($request->nilai_rapor)) ? HelperModel::objToArray(json_decode($request->nilai_rapor, true)) : NULL;
        if($nilai_rapor){
            foreach($nilai_rapor as $mata_pelajaran_id => $a){
                foreach($a as $kelas => $b){
                    foreach($b as $semester => $nilai){
                        Nilai::updateOrCreate(
                            [
                                'mata_pelajaran_id' => $mata_pelajaran_id,
                                'kelas' => $kelas,
                                'semester' => $semester,
                                'user_id' => $request->user_id,
                            ],
                            [
                                'nilai' => ($nilai) ? $nilai : 0,
                            ]
                        );
                    }
                }
            }
        }*/
        return response()->json(['status' => 'success', 'message' => 'Pendaftaran berhasil disimpan', 'data' => $all_data, 'nilai_rapor' => $nilai_rapor]);
    }
    private function simpan_prestasi($request, $pendaftar_id){
        $files = $request->file('upload_piagam');
        if($files){
            foreach($files as $key => $file){
                $filePiagam = 'piagam-'.Carbon::now()->timestamp . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move('uploads', $filePiagam);
                $skor = HelperModel::nilai_piagam($request->jenis_kejuaraan_id[$key], $request->prestasi_id[$key], $request->juara[$key]);
                if($skor){
                    Piagam::updateOrCreate(
                        [
                            'pendaftar_id' => $pendaftar_id,
                            'tingkat_prestasi_id' => $request->prestasi_id[$key],
                            'jalur_id' => $request->jalur_id,
                            'juara' => $request->juara[$key],
                            'tanggal' => $request->tanggal_juara[$key],
                            'skor_prestasi_id' => $skor['id'],
                        ],
                        [
                            'dokumen' => $filePiagam,
                            'nilai' => $skor['skor'],
                        ]
                    );
                }
            }
        }
		//$data = Piagam::with(['tingkat_prestasi'])->where('user_id', $request->user_id)->get();
		return response()->json(['status' => 'success']);
	}
    private function simpan_dokumen($request, $pendaftar, $sekolah_pilihan){
        $files = $request->file('files');
        if($files){
            foreach($files as $key => $file){
                $nama_dokumen = Carbon::now()->timestamp . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move('uploads', $nama_dokumen);
                $tanggal = NULL;
                if(isset($request->tanggal[$key])){
                    $tanggal = $request->tanggal[$key];
                }
                $all_data = Dokumen::updateOrCreate(
                    [
                        'pendaftar_id' => $pendaftar->pendaftar_id,
                        'sekolah_pilihan_id' => $sekolah_pilihan->sekolah_pilihan_id,
                        'komponen_id' => $key,
                    ],
                    [
                        'tanggal' => $tanggal,
                        'type' => $file->getClientMimeType(),
                        'berkas' => $nama_dokumen,
                    ]
                );
            }
        }
    }
    public function show(){
        $pendaftar = Pendaftar::with(['user.nilai', 'dokumen' => function($query){
            $query->wherehas('sekolah_pilihan', function($query) {
                $query->where('sekolah_id', request()->sekolah_id);
            });
            $query->with(['status', 'komponen']);
        }, 'sekolah_pilihan_single' => function($query){
            $query->where('sekolah_id', request()->sekolah_id);
            $query->with(['sekolah', 'jalur']);
        }, 'piagam' => function($query){
            $query->with([
                //'tingkat_prestasi', 'status'
                'tingkat_prestasi' => function($query){
                    $query->select('id', 'nama');
                },
                'skor_prestasi.jenis_kejuaraan' => function($query){
                    $query->select('id', 'nama');
                },
                'status' => function($query){
                    $query->select('id', 'nama');
                },
            ]);
            $query->where('jalur_id', request()->jalur_id);
        }])->find(request()->pendaftar_id);
        $all_data = Status::select('id', 'nama')->get();
        $mata_pelajaran = Mata_pelajaran::get();
		$nilai = Nilai::where('user_id', $pendaftar->user_id)->get();
        $all_nilai = [];
        $rerata_akhir = 0;
        $rerata = 0;
        if(count($nilai)){
            $rerata_akhir = number_format($pendaftar->user->nilai()->avg('nilai'), 2);
            foreach($nilai as $n){
                $all_nilai[$n->mata_pelajaran_id] = $n->nilai;
            }
            $rerata = number_format(array_sum($all_nilai) / count($all_nilai), 2, '.', '.');
        }
        return response()->json(['rerata' => $rerata, 'status' => 'success', 'data' => $all_data, 'pendaftar' => $pendaftar, 'mata_pelajaran' => $mata_pelajaran, 'nilai' => $all_nilai, 'rerata_akhir' => $rerata_akhir]);
    }
    public function siswa(Request $request){
		if(is_array($request->provinsi_id)){
            $provinsi = Wilayah::find($request->provinsi_id['value']);
			$provinsi_id = $request->provinsi_id['value'];
			$nama_provinsi = ($provinsi) ? $provinsi->nama : '-';
		} else {
			$provinsi_id = NULL;
			$nama_provinsi = $request->provinsi_id;
		}
		if(is_array($request->kabupaten_id)){
            $kabupaten = Wilayah::find($request->kabupaten_id['value']);
			$kabupaten_id = $request->kabupaten_id['value'];
			$nama_kabupaten = ($kabupaten) ? $kabupaten->nama : '-';
		} else {
			$kabupaten_id = NULL;
			$nama_kabupaten = $request->kabupaten_id;
		}
		if(is_array($request->kecamatan_id)){
            $kecamatan = Wilayah::find($request->kecamatan_id['value']);
			$kecamatan_id = $request->kecamatan_id['value'];
			$nama_kecamatan = ($kecamatan) ? $kecamatan->nama : '-';
		} else {
			$kecamatan_id = NULL;
			$nama_kecamatan = $request->kecamatan_id;
		}
		if(is_array($request->desa_id)){
            $desa = Wilayah::find($request->desa_id['value']);
			$desa_id = $request->desa_id['value'];
			$nama_desa = ($desa) ? $desa->nama : '-';
		} else {
			$desa_id = NULL;
			$nama_desa = $request->desa_id;
		}
		$tanggal_lahir = ($request->tanggal_lahir) ? date('Y-m-d', strtotime($request->tanggal_lahir)) : NULL;
		$kebutuhan_khusus = NULL;
		if($request->kebutuhan_khusus){
			$kebutuhan_khusus = json_encode($request->kebutuhan_khusus);
			$kebutuhan_khusus = serialize($kebutuhan_khusus);
		}
        $insert = [
			'sekolah_id' => $request->sekolah_id,
			'name' => $request->name,
			'username' => $request->nik,
			'email' => $request->nik.'@disdik.sampangkab.go.id',
			'password' => Hash::make($request->password),
			'sandi' => $request->password,
			'jenis_kelamin' => $request->jenis_kelamin['value'],
			'bentuk_pendidikan_id' => $request->bentuk_pendidikan_id['value'],
			'wna' => $request->wna['key'],
			'negara_id' => $request->negara_id['value'],
			'provinsi_id' => $provinsi_id,
			'kabupaten_id' => $kabupaten_id,
			'kecamatan_id' => $kecamatan_id,
			'desa_id' => $desa_id,
			'provinsi' => $nama_provinsi,
			'kabupaten' => $nama_kabupaten,
			'kecamatan' => $nama_kecamatan,
			'desa' => $nama_desa,
			'nomor_hp' => $request->nomor_hp,
			'alamat' => $request->alamat,
			'rt' => $request->rt,
			'rw' => $request->rw,
			'nama_ortu' => $request->nama_ortu,
			'kebutuhan_khusus' => $kebutuhan_khusus,
			'tempat_lahir' => $request->tempat_lahir,
			'tanggal_lahir' => $tanggal_lahir,
			'jenis_tinggal_id' => $request->jenis_tinggal_id['value'],
			'agama_id' => $request->agama_id['value'],
            'lintang' => $request->lintang,
            'bujur' => $request->bujur,
		];
        $user = User::updateOrCreate(['username' => $request->nik], $insert);
        $role = Role::where('name', 'siswa')->first();
        if(!$user->hasRole('siswa')){
            $user->attachRole($role);
        }
        $jenjang = ($user->bentuk_pendidikan_id == 5) ? 'SD' : 'SMP';
        $count_pendaftar = Pendaftar::where('bentuk_pendidikan_id', $user->bentuk_pendidikan_id)->where('user_id', '<>', $user->user_id)->count() + 1;
        $nomor_pendaftaran = $jenjang.'-'.str_pad($count_pendaftar,5,0,STR_PAD_LEFT).'-'.date('d-m-Y');
        $all_data = Pendaftar::create(
            [
                'user_id' => $user->user_id,
                'nomor_pendaftaran' => $nomor_pendaftaran,
                'bentuk_pendidikan_id' => $user->bentuk_pendidikan_id,
                'jenis_kelamin' => $user->jenis_kelamin,
            ]
        );
        $sekolah_pilihan = Sekolah_pilihan::updateOrCreate(
            [
                'pendaftar_id' => $all_data->pendaftar_id,
                'sekolah_id' => $request->sekolah['value'],
            ],
            [
                'jalur_id' => $request->jalur['value'],
                'tampil' => 1,
                'pilihan_ke' => 1,
                //'titipan' => $request->titipan,
            ]
        );
        $all_request = $request->all();
        return response()->json(['data' => $all_data, 'sekolah_pilihan' => $sekolah_pilihan, 'all_request' => $all_request, 'status' => 'success', 'message' => 'Pendaftaran siswa berhasil disimpan']);
    }
    public function jalur(Request $request){
        $all_data = Jalur::select('id as value', 'nama')->where('bentuk_pendidikan_id', $request->bentuk_pendidikan_id)->get();
        return response()->json(['status' => 'success', 'data' => $all_data]);
    }
    public function sekolah(Request $request){
        $user = User::find($request->user_id);
        $all_data = Jalur::select('id', 'nama')->where('bentuk_pendidikan_id', $user->bentuk_pendidikan_id)->get();
        return response()->json(['status' => 'success', 'data' => $all_data, 'user' => $user]);
    }
    public function get_sekolah(Request $request)
    {
        $user = User::find(request()->user_id);
        if($user->hasRole('siswa')){
            $jalur = Jalur::where('bentuk_pendidikan_id', $user->bentuk_pendidikan_id)->where('tautan', $request->tautan)->first();
        } else {
            $jalur = NULL;
        }
        $all_data = Sekolah::where(function($query) use ($jalur){
            $query->where('bentuk_pendidikan_id', request()->bentuk_pendidikan_id);
            if($jalur){
                $query->whereDoesntHave('sekolah_pilihan', function (Builder $query)  use ($jalur){
                    $query->where('jalur_id', '<>', $jalur->id);
                    $query->whereHas('pendaftar', function(Builder $query){
                        $query->where('user_id', request()->user_id);
                    });
                });
            }
        })->select('nama', 'sekolah_id as value')->get();
        $filter = ($request->filter) ? 1 : 0;
        $dateOfBirth = '1994-07-02';
        $usia = Carbon::parse($dateOfBirth)->age;
        return response()->json(['status' => 'success', 'data' => $all_data, 'filter' => $filter, 'usia' => $usia]);
    }
    public function get_komponen(Request $request)
    {
        $all_data = Komponen::with(['dokumen' => function($query) use ($request){
            $query->whereHas('pendaftar', function($query) use ($request){
                $query->where('pendaftar_id', $request->pendaftar_id);
            });
            $query->with(['status']);
        }])->where(function($query){
            if(request()->jenis_prestasi){
                $query->whereIn('jenis_prestasi', [0, request()->jenis_prestasi]);
            }
            $query->where('jalur_id', request()->jalur_id);
        })->get();
        $pendaftar = Pendaftar::find(request()->pendaftar_id);
        $prestasi = NULL;
        if(request()->jenis_prestasi){
            $prestasi = [
                'piagam' => Piagam::with([
                    'tingkat_prestasi' => function($query){
                        $query->select('id', 'nama');
                    },
                    'skor_prestasi.jenis_kejuaraan' => function($query){
                        $query->select('id', 'nama');
                    }
                ])->where('pendaftar_id', request()->pendaftar_id)->get(),
                'tingkat_prestasi' => Tingkat_prestasi::select('id', 'nama')->get(),
            ];
        }
        /*$nilai = ($pendaftar) ? Nilai::where('user_id', $pendaftar->user_id)->get() : [];
        $all_nilai = [];
        foreach($nilai as $n){
            $all_nilai[$n->mata_pelajaran_id][$n->kelas][$n->semester] = $n->nilai;
        }*/
        $jenis_kejuaraan = Jenis_kejuaraan::select('id', 'nama')->get();
        return response()->json(['status' => 'success', 'data' => $all_data, 'prestasi' => $prestasi, 'jenis_kejuaraan' => $jenis_kejuaraan]);
    }
    public function upload_dokumen(Request $request)
    {
        $messages = [
            'file.required'	=> 'File Upload tidak boleh kosong',
            'file.mimes'	=> 'File Upload harus berekstensi .jpeg/.jpg/.png/.pdf',
        ];
        $validator = Validator::make(request()->all(), [
            'file' => 'required|mimes:jpeg,jpg,png,pdf',
        ],
        $messages
        )->validate();
        $file = $request->file('file');
        $nama_dokumen = Carbon::now()->timestamp . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move('uploads', $nama_dokumen);
        $all_data = Dokumen::updateOrCreate(
            [
                'pendaftar_id' => $request->pendaftar_id,
                'sekolah_pilihan_id' => $request->sekolah_pilihan_id,
                'komponen_id' => $request->komponen_id,
            ],
            [
                'tanggal' => ($request->tanggal != 'undefined') ? date('Y-m-d', strtotime($request->tanggal)) : NULL,
                'type' => $file->getClientMimeType(),
                'berkas' => $nama_dokumen,
            ]
        );
        return response()->json(['status' => 'success', 'message' => 'Upload dokumen berhasil', 'data' => $all_data]);
    }
    public function hapus_dokumen($dokumen_id){
        $find = Dokumen::find($dokumen_id);
        File::delete('uploads/'.$find->berkas);
        if($find->delete()){
            return response()->json(['status' => 'success', 'message' => 'Dokumen berhasil dihapus', 'title' => 'Berhasil']);
        }
        return response()->json(['status' => 'error', 'message' => 'Dokumen gagal dihapus', 'title' => 'Gagal']);
    }
    public function kunci($sekolah_pilihan_id){
        $sekolah_pilihan = Sekolah_pilihan::with(['sekolah', 'pendaftar.user'])->find($sekolah_pilihan_id);
        $a = $sekolah_pilihan->sekolah->lintang.",".$sekolah_pilihan->sekolah->bujur;
		$b = $sekolah_pilihan->pendaftar->user->lintang.",".$sekolah_pilihan->pendaftar->user->bujur;
		$jarak = HelperModel::distHaversine($a, $b);
        $sekolah_pilihan->jarak = $jarak;
        $sekolah_pilihan->jarak_int = str_replace('.','',$jarak);
        $sekolah_pilihan->kunci = 1;
        //$nilai_mapel = Nilai::where('user_id', $sekolah_pilihan->pendaftar->user->user_id)->sum('nilai');
        //$sekolah_pilihan->nilai_mapel = $nilai_mapel;
        //$sekolah_pilihan->nilai_akhir = $nilai_akhir;
        if($sekolah_pilihan->save()){
            return response()->json(['status' => 'success', 'message' => 'Pendaftaran berhasil dikunci', 'title' => 'Berhasil']);
        }
        return response()->json(['status' => 'error', 'message' => 'Gagal mengunci pendaftaran', 'title' => 'Gagal']);
    }
    public function get_prestasi(Request $request){
		$all_data = [
			'piagam' => Piagam::with([
                'status', 
                'tingkat_prestasi' => function($query){
                    $query->select('id', 'nama');
                },
                'skor_prestasi.jenis_kejuaraan' => function($query){
                    $query->select('id', 'nama');
                }
            ])->where(function($query){
                $query->where('pendaftar_id', request()->pendaftar_id);
                $query->where('jalur_id', request()->jalur_id);
            })->get(),
			'tingkat_prestasi' => Tingkat_prestasi::select('id', 'nama')->get(),
		];
		return response()->json(['status' => 'success', 'data' => $all_data]);
	}
}
