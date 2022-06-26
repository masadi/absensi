<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\HelperModel;
use App\Sekolah;
use App\Pendaftar;
use App\Wilayah;
use App\User;
use App\Jalur;
use App\Role;
use App\Piagam;
use App\Sekolah_pilihan;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request){
        $user = User::find($request->user_id);
        if($user->hasRole(['admin', 'dinas'])){
            $all_data = [
                /*'jml_sekolah' => DB::table('sekolah')
                ->selectRaw('count(*) as total')
                ->selectRaw("count(case when bentuk_pendidikan_id = 5 then 1 end) as jml_sd")
                ->selectRaw("count(case when bentuk_pendidikan_id = 6 then 1 end) as jml_smp")
                ->first(),*/
                'jml_sekolah' => 0,
                'jml_pendaftar' => NULL,
            ];
        } else {
            $all_data = [
                'jml_sekolah' => NULL,
                'jml_pendaftar' => NULL,
            ];
        }
        return response()->json(['status' => 'success', 'data' => $all_data]);
    }
    public function get_desa(Request $request){
        $all_data = Wilayah::select('kode_wilayah', 'nama')->where('id_level_wilayah', 4)->where('mst_kode_wilayah', $request->kecamatan_id)->get();
        return response()->json(['result' => $all_data]);
    }
    public function informasi(Request $request){
        $user = User::find($request->user_id);
        $all_data = Jalur::with(['komponen'])->where('bentuk_pendidikan_id', $user->bentuk_pendidikan_id)->where('tautan', $request->tautan)->first();
        return response()->json(['status' => 'success', 'data' => $all_data]);
    }
    public function seleksi(Request $request){
        $user = User::find($request->user_id);
        if($user->hasRole(['admin', 'sekolah'])){
            $all_data = Sekolah_pilihan::where(function($query){
                $query->whereHas('jalur', function($query){
                    $query->where('tautan', request()->tautan);
                });
                $query->whereHas('status', function($query){
                    $query->where('nama', 'Terima');
                });
                $query->whereHas('pendaftar', function($query){
                    $query->where('bentuk_pendidikan_id', request()->bentuk_pendidikan_id);
                });
                $query->where('kunci', 1);
                if(request()->sekolah_id){
                    $query->where('sekolah_id', request()->sekolah_id);
                }
            });//->orderBy(request()->sortby, request()->sortbydesc)
            /*if(request()->tautan == 'zonasi'){
                $all_data->orderBy('jarak_int', 'ASC');
            }
            $all_data->orderBy('titipan', 'DESC');
            $all_data->orderBy('usia', 'DESC');*/
            $all_data->orderBy('nilai_akhir', 'DESC')
                //JIKA Q ATAU PARAMETER PENCARIAN INI TIDAK KOSONG
                ->when(request()->q, function($posts) {
                    $posts = $posts->whereHas('pendaftar.user', function($query){
                        $query->where('name', 'LIKE', '%' . request()->q . '%')
                        ->orWhere('email', 'LIKE', '%' . request()->q . '%')
                        ->orWhere('username', 'LIKE', '%' . request()->q . '%');
                    });
                    //MAKA FUNGSI FILTER AKAN DIJALANKAN
            })->with(['pendaftar.user', 'sekolah']);
            $all_data = $all_data->paginate(request()->per_page); //KEMUDIAN LOAD PAGINATIONNYA BERDASARKAN LOAD PER_PAGE YANG DIINGINKAN OLEH USER
            $jalur = Jalur::where('bentuk_pendidikan_id', $request->bentuk_pendidikan_id)->where('tautan', $request->tautan)->first();
            $jenjang = ($request->bentuk_pendidikan_id == 5) ? 'Jenjang SD' : 'Jenjang SMP';
            $all_sekolah = Sekolah::where('bentuk_pendidikan_id', $request->bentuk_pendidikan_id)->get();
            return response()->json(['all_sekolah' => $all_sekolah, 'status' => 'success', 'data' => $all_data, 'jalur' => $jalur, 'jenjang' => $jenjang, 'sortby' => request()->sortby, 'sortbydesc' => request()->sortbydesc]);
        } else {
            $all_data = Sekolah_pilihan::where(function($query) use ($user){
                $query->whereHas('jalur', function($query){
                    $query->where('tautan', request()->tautan);
                });
                /*$query->whereHas('status', function($query){
                    $query->where('nama', 'Terima');
                });*/
                $query->whereHas('pendaftar', function($query) use ($user){
                    $query->where('user_id', $user->user_id);
                });
                $query->where('kunci', 1);
            })->with(['jalur', 'status', 'pendaftar.user', 'sekolah' => function($query){
                $query->withCount(['sekolah_pilihan' => function($query){
                    $query->whereHas('jalur', function($query){
                        $query->where('tautan', request()->tautan);
                    });
                }]);
                $query->with(['pagu_single' => function($query){
                    $query->whereHas('jalur', function($query){
                        $query->where('tautan', request()->tautan);
                    });
                }]);
            }])->first();
            $jalur = Jalur::where('bentuk_pendidikan_id', $request->bentuk_pendidikan_id)->where('tautan', $request->tautan)->first();
            $jenjang = ($request->bentuk_pendidikan_id == 5) ? 'Jenjang SD' : 'Jenjang SMP';
            /*$semua = Sekolah_pilihan::where(function($query){
                $query->whereHas('jalur', function($query){
                    $query->where('tautan', request()->tautan);
                });
                $query->whereHas('status', function($query){
                    $query->where('nama', 'Terima');
                });
                $query->whereHas('pendaftar', function($query){
                    $query->where('bentuk_pendidikan_id', request()->bentuk_pendidikan_id);
                });
                $query->where('kunci', 1);
                if(request()->sekolah_id){
                    $query->where('sekolah_id', request()->sekolah_id);
                }
            })->orderBy('nilai', 'DESC')->get();
            $keyed = $semua->keyBy('sekolah_pilihan_id');
            $filter = $semua->first(function ($value, $key) use ($all_data){
                //dd($value);
                return $value->sekolah_pilihan_id == $all_data->sekolah_pilihan_id;
            });*/
            $rangking = ($all_data) ? $this->getPointRankAttribute($all_data->sekolah_pilihan_id, $all_data->sekolah_id, request()->tautan) : '-';
            //$rangking = $semua;
            return response()->json(['status' => 'success', 'data' => $all_data, 'jalur' => $jalur, 'jenjang' => $jenjang, 'user' => $user, 'rangking' => $rangking]);
        }
    }
    public function getPointRankAttributeOld($sekolah_pilihan_id) {
        $ranks = DB::select('
          SELECT s.*, @rank := @rank + 1 rank
          FROM (
            SELECT sekolah_pilihan_id, sum(nilai_akhir) TotalPoints
            FROM sekolah_pilihan
            GROUP BY sekolah_pilihan_id
          ) s, (SELECT @rank := 0) init
          ORDER BY TotalPoints DESC
        ');
        $data = collect($ranks)->where('sekolah_pilihan_id', $sekolah_pilihan_id)->first();
        return ($data) ? $data->rank : '-';
    }
    public function getPointRankAttribute($sekolah_pilihan_id, $sekolah_id, $tautan) {
        $ranks = Sekolah_pilihan::query()
            ->where('sekolah_id', $sekolah_id)
            ->whereHas('jalur', function($query) use ($tautan){
                $query->where('tautan', $tautan);
            })
            ->select('sekolah_pilihan_id')->selectRaw('SUM(`nilai_akhir`) TotalPoints')
            ->groupBy('sekolah_pilihan_id')
            ->orderByDesc('TotalPoints')
            ->get();
        return $ranks->search(function($pointLog) use ($sekolah_pilihan_id){
            return $pointLog->sekolah_pilihan_id == $sekolah_pilihan_id;
        }) + 1;
    }
    public function register(Request $request){
        $messages = [
            'nik.unique' => 'NIK terdeteksi sudah terdaftar. Silahkan login',
        ];
       Validator::make($request->all(), [
            'nik' => ['required', 'string', 'min:16', 'max:16', 'unique:users,username'],
        ], $messages)->validate();
        $user = User::create([
            'name' => $request->name,
            'username' => $request->nik,
            'email' => $request->nik.'@disdik.sampangkab.go.id',
            'password' => Hash::make($request->password),
            'bentuk_pendidikan_id' => $request->bentuk_pendidikan_id,
            'sandi' => $request->password,
        ]);
        if(!$user->hasRole('siswa')){
            $role = Role::where('name', 'siswa')->first();
            $user->attachRole($role);
        }
        return response()->json(['user' => $user]);
    }
    public function dokumen(Request $request){
        $data = Sekolah_pilihan::with(['dokumen' => function($query){
            $query->with(['status', 'komponen']);
        }])->find($request->sekolah_pilihan_id);
        return response()->json(['status' => 'success', 'data' => $data]);
    }
    public function generate_hasil(Request $request){
        $sekolah = (request()->sekolah_id) ? Sekolah::find(request()->sekolah_id) : NULL;
        $all_pendaftar = Pendaftar::whereHas('sekolah_pilihan_single', function($query){
            $query->where('jalur_id', request()->jalur_id);
            $query->whereHas('status', function($query){
                $query->where('nama', 'Terima');
            });
            if(request()->sekolah_id){
                $query->where('sekolah_id', request()->sekolah_id);
            }
        })->with(['user',
            'sekolah_pilihan_single' => function($query){
                $query->where('jalur_id', request()->jalur_id);
                $query->with(['jalur', 'dokumen' => function($query){
                    $query->whereHas('status', function($query){
                        $query->where('nama', 'Terima');
                    });
                }]);
            },
            'user.nilai',
            'piagam'
        ])->get();
        $all_nilai_titipan = [];
        foreach($all_pendaftar as $pendaftar){
            $nilai_dokumen = 0;
            /*$nilai_akreditasi = 0;
            if($pendaftar->sekolah_pilihan_single->akreditasi == 'A'){
                $nilai_akreditasi = 100;
            } elseif($pendaftar->sekolah_pilihan_single->akreditasi == 'B'){
                $nilai_akreditasi = 75;
            } elseif($pendaftar->sekolah_pilihan_single->akreditasi == 'C'){
                $nilai_akreditasi = 50;
            }*/
            foreach($pendaftar->sekolah_pilihan_single->dokumen as $dokumen){
                $nilai_dokumen+= $dokumen->skor;
            }
            $nilai_mapel = 0;
            foreach($pendaftar->user->nilai as $nilai){
                $nilai_mapel+= $nilai->nilai;
            }
            //$nilai_mapel = $pendaftar->user->nilai()->avg('nilai');
            $nilai_mapel_asli = $nilai_mapel;
            $nilai_piagam = 0;
            foreach($pendaftar->piagam as $piagam){
                $nilai_piagam+= $piagam->nilai;
            }
            $bobot = ($pendaftar->bentuk_pendidikan_id == 5) ? 400 : 900;
            $pembagi = ($pendaftar->bentuk_pendidikan_id == 5) ? 10000 : 100;//100;
            //$nilai_jarak = ((20000 - $pendaftar->sekolah_pilihan_single->jarak_int) * $bobot) / 20000;
            $nilai_jarak = ((10000 - $pendaftar->sekolah_pilihan_single->jarak_int) * $bobot) / $pembagi;
            $nilai_usia = $pendaftar->user->usia_ago;
            if($pendaftar->sekolah_pilihan_single->jalur->tautan == 'zonasi'){
                if($pendaftar->bentuk_pendidikan_id == 6){
                    $nilai_jarak = ($nilai_jarak * 90) / 100;
                    $nilai_mapel = ($nilai_mapel * 5) / 100;
                    $nilai_usia = ($nilai_usia * 5) / 100;
                } else {
                    $nilai_jarak = ($nilai_jarak * 40) / 100;
                    $nilai_usia = ($nilai_usia * 60) / 100;
                }
            }
            if($pendaftar->sekolah_pilihan_single->sekolah_pilihan_id == '1980e91d-1b8b-4b64-bb9d-a1b67a5c65a2'){
                $nilai_jarak = 0;
            }
            if($pendaftar->bentuk_pendidikan_id == 6){
                $nilai_satuan = ($nilai_mapel + $nilai_jarak + $nilai_usia);
            } else {
                //$nilai_satuan = ($nilai_dokumen + $nilai_mapel + $nilai_piagam + $nilai_akreditasi + $nilai_jarak + $nilai_usia);
                $nilai_satuan = ($nilai_dokumen + $nilai_mapel + $nilai_piagam + $nilai_jarak + $nilai_usia);
            }
            if ($nilai_satuan < 0){
                $nilai_satuan = 0;
                $nilai_jarak = 0;
                $nilai_mapel = 0;
                $nilai_usia = 0;
            }
            if ($nilai_jarak < 0){
                $nilai_jarak = 0;
            }
            $nilai_titipan = $pendaftar->sekolah_pilihan_single->titipan;
            $pendaftar->sekolah_pilihan_single->nilai_mapel = $nilai_mapel_asli;
            $pendaftar->sekolah_pilihan_single->nilai_usia = $nilai_usia;
            $pendaftar->sekolah_pilihan_single->nilai_jarak = $nilai_jarak;
            $pendaftar->sekolah_pilihan_single->nilai_piagam = $nilai_piagam;
            $pendaftar->sekolah_pilihan_single->nilai_dokumen = $nilai_dokumen;
            //$pendaftar->sekolah_pilihan_single->nilai_akreditasi = $nilai_akreditasi;
            $pendaftar->sekolah_pilihan_single->nilai = $nilai_satuan;
            $pendaftar->sekolah_pilihan_single->nilai_akhir = ($nilai_satuan + $nilai_titipan);
            $pendaftar->sekolah_pilihan_single->usia = Carbon::parse($pendaftar->user->tanggal_lahir)->age;
            //$pendaftar->sekolah_pilihan_single->jarak = $pendaftar->sekolah_pilihan_single->jarak;
            $pendaftar->sekolah_pilihan_single->jarak_int = str_replace('.','',$pendaftar->sekolah_pilihan_single->jarak);
            $pendaftar->sekolah_pilihan_single->save();
        }
        return response()->json(['icon' => 'success', 'text' => 'Generate Nilai Akhir berhasil', 'title' => 'Selesai', 'all_nilai_titipan' => $all_nilai_titipan]);
    }
    public function tukar_akses(Request $request, $user_id, $user_sekolah = null){
        $user = User::find($user_id);
        Auth::logout();
        Auth::login($user);
        if($user->hasRole('siswa')){
            $request->session()->put('tukar_akses', true);
            if($user_sekolah){
                $request->session()->put('user_sekolah', $user_sekolah);
            }
        } else {
            $request->session()->forget(['tukar_akses', 'user_sekolah']);
        }
        return redirect('app/beranda');
    }
}
