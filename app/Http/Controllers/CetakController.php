<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Rap2hpoutre\FastExcel\FastExcel;
use Rap2hpoutre\FastExcel\SheetCollection;
use Carbon\Carbon;
use PDF;
use ZipArchive;
use File;
use App\User;
use App\Sekolah_pilihan;
use App\Sekolah;
use App\Jalur;
use App\Dokumen;
use App\Mata_pelajaran;

class CetakController extends Controller
{
    public function akun(Request $request){
        if(!$request->route('user_id')){
            $user = auth()->user();
            if(!$user){
                return redirect('/');
            }
            $user_id = $user->user_id;
        } else {
            $user_id = $request->user_id;
        }
        $user = User::with(['desa.parent'])->find($user_id);
        $user = ['user' => $user];
        $pdf = PDF::loadView('cetak.akun', $user, [], [
            'temp_dir' => storage_path('framework/sessions'),
        ]);
        if(!$request->route('user_id')){
            Auth::logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
        }
        return $pdf->download('Kartu Registrasi PPDB Kab. Sampang.pdf');
        return $pdf->stream('Kartu Registrasi PPDB Kab. Sampang.pdf');
    }
    public function pendaftaran(Request $request){
        $sekolah_pilihan = Sekolah_pilihan::with(['sekolah', 'pendaftar.user', 'jalur', 'status', 'dokumen.komponen', 'verifikator'])->find($request->sekolah_pilihan_id);
        $data = ['sekolah_pilihan' => $sekolah_pilihan];
        $pdf = PDF::loadView('cetak.pendaftaran', $data, [], [
            'temp_dir' => storage_path('framework/sessions'),
        ]);
        return $pdf->download('Bukti Pendaftaran PPDB Kab. Sampang.pdf');
        return $pdf->stream('Bukti Pendaftaran PPDB Kab. Sampang.pdf');
    }
    public function penerimaan(Request $request){
        $sekolah_pilihan = Sekolah_pilihan::with(['sekolah', 'pendaftar.user', 'jalur', 'status', 'dokumen.komponen', 'verifikator'])->find($request->sekolah_pilihan_id);
        $data = ['sekolah_pilihan' => $sekolah_pilihan];
        $pdf = PDF::loadView('cetak.penerimaan', $data, [], [
            'temp_dir' => storage_path('framework/sessions'),
        ]);
        return $pdf->download('Bukti Penerimaan PPDB Kab. Sampang.pdf');
        return $pdf->stream('Bukti Penerimaan PPDB Kab. Sampang.pdf');
    }
    public function hasil(Request $request){
        $jalur = Jalur::find($request->jalur_id);
        $jenjang = ($jalur->bentuk_pendidikan_id == 5) ? ' Jenjang SD ' : ' Jenjang SMP ';
        $sekolah = Sekolah::with(['pagu_single' => function($query){
            $query->where('jalur_id', request()->jalur_id);
        }])->find(request()->sekolah_id);
        if($sekolah){
            $limit = ($sekolah->pagu_single) ? $sekolah->pagu_single->jumlah : 0;
        } else {
            $limit = 250;
        }
        $sekolah_pilihan = Sekolah_pilihan::with(['sekolah', 'pendaftar.user', 'jalur', 'status', 'dokumen.komponen', 'verifikator'])->where(function($query) use ($request){
            $query->where('jalur_id', $request->jalur_id);
            $query->whereHas('status', function($query){
                $query->where('nama', 'Terima');
            });
            if($request->sekolah_id){
                $query->where('sekolah_id', $request->sekolah_id);
            }
        })
        ->orderBy('sekolah_id')
        //->orderBy('titipan', 'desc')
        //->orderBy('usia', 'DESC')
        //->orderBy('jarak', 'ASC')
        ->orderBy('nilai_akhir', 'DESC')
        ->limit($limit)
        ->get();
        $data = [
            'sekolah_pilihan' => $sekolah_pilihan,
            'jalur' => $jalur,
            'sekolah' => $sekolah,
        ];
        $pdf = PDF::loadView('cetak.hasil', $data, [], [
            'orientation' => ($jalur->tautan == 'zonasi') ? 'L' : 'P',
            'temp_dir' => storage_path('framework/sessions'),
        ]);
        return $pdf->download('Hasil Seleksi Jalur '.$jalur->nama.$jenjang.'PPDB Kab. Sampang.pdf');
        return $pdf->stream('Hasil Seleksi Jalur '.$jalur->nama.$jenjang.'PPDB Kab. Sampang.pdf');
    }
    public function hasil_ppdb(Request $request){
        $jalur = Jalur::find($request->jalur_id);
        $jenjang = ($jalur->bentuk_pendidikan_id == 5) ? ' Jenjang SD ' : ' Jenjang SMP ';
        $sekolah = Sekolah::with(['pagu_single' => function($query){
            $query->where('jalur_id', request()->jalur_id);
        }])->find(request()->sekolah_id);
        $limit = ($sekolah->pagu_single) ? $sekolah->pagu_single->jumlah : 0;
        $sekolah_pilihan = Sekolah_pilihan::where(function($query){
            $query->where('jalur_id', request()->jalur_id);
            $query->whereHas('status', function($query){
                $query->where('nama', 'Terima');
            });
            $query->where('kunci', 1);
            $query->where('sekolah_id', request()->sekolah_id);
        })->orderBy('nilai_akhir', 'DESC')->with(['pendaftar.user', 'sekolah'])->limit($limit)->get();
        $data = [
            'sekolah_pilihan' => $sekolah_pilihan,
            'jalur' => $jalur,
            'sekolah' => $sekolah,
        ];
        return view('hasil_pengumuman', $data);
        //$pdf = PDF::loadView('cetak.hasil_ppdb', $data, [], [
            //'temp_dir' => storage_path('framework/sessions'),
        //]);
        //return $pdf->download('Hasil Seleksi Jalur '.$jalur->nama.$jenjang.'PPDB Kab. Sampang.pdf');
        //return $pdf->stream('Hasil Seleksi Jalur '.$jalur->nama.$jenjang.'PPDB Kab. Sampang.pdf');
    }
    public function hasil_opsi(Request $request){
        $user = auth()->user();
        $jalur_id = $request->route('jalur_id');
        $filter = $request->route('filter');
        $output = $request->route('output');
        $sekolah_id = $request->route('sekolah_id');
        $jalur = Jalur::find($request->jalur_id);
        $jenjang = ($jalur->bentuk_pendidikan_id == 5) ? ' Jenjang SD ' : ' Jenjang SMP ';
        $sekolah = Sekolah::with(['pagu_single' => function($query) use ($jalur_id){
            $query->where('jalur_id', $jalur_id);
        }])->find($sekolah_id);
        if($filter == 1){
            $sekolah_pilihan = Sekolah_pilihan::where(function($query) use ($jalur_id, $sekolah_id){
                $query->where('jalur_id', $jalur_id);
                $query->whereHas('status', function($query){
                    $query->where('nama', 'Terima');
                });
                $query->where('kunci', 1);
                if($sekolah_id){
                    $query->where('sekolah_id', $sekolah_id);
                }
            })->orderBy('sekolah_id')->orderBy('nilai_akhir', 'DESC')->with(['pendaftar.user', 'sekolah'])->get();
        } elseif($filter == 2){
            $limit = ($sekolah->pagu_single) ? $sekolah->pagu_single->jumlah : 0;
            $sekolah_pilihan = Sekolah_pilihan::where(function($query) use ($jalur_id, $sekolah_id){
                $query->where('jalur_id', $jalur_id);
                $query->whereHas('status', function($query){
                    $query->where('nama', 'Terima');
                });
                $query->where('kunci', 1);
                if($sekolah_id){
                    $query->where('sekolah_id', $sekolah_id);
                }
            })->orderBy('sekolah_id')->orderBy('nilai_akhir', 'DESC')->with(['pendaftar.user', 'sekolah'])->limit($limit)->get();
        } else {
            $offset = ($sekolah->pagu_single) ? $sekolah->pagu_single->jumlah : 0;
            $sekolah_pilihan = Sekolah_pilihan::where(function($query) use ($jalur_id, $sekolah_id){
                $query->where('jalur_id', $jalur_id);
                $query->whereHas('status', function($query){
                    $query->where('nama', 'Terima');
                });
                $query->where('kunci', 1);
                if($sekolah_id){
                    $query->where('sekolah_id', $sekolah_id);
                }
            })->orderBy('sekolah_id')->orderBy('nilai_akhir', 'DESC')->with(['pendaftar.user', 'sekolah'])->limit(1000)->offset($offset)->get();
        }
        $data = [
            'sekolah_pilihan' => $sekolah_pilihan,
            'jalur' => $jalur,
            'sekolah' => $sekolah,
        ];
        if($output == 1){
            $pdf = PDF::loadView('cetak.hasil_ppdb', $data, [], [
                'temp_dir' => storage_path('framework/sessions'),
            ]);
            //return $pdf->stream('Hasil Seleksi Jalur '.$jalur->nama.$jenjang.'PPDB Kab. Sampang.pdf');
            return $pdf->download('Hasil Seleksi Jalur '.$jalur->nama.$jenjang.'PPDB Kab. Sampang.pdf');
        } else {
            $output_array = [];
            if($sekolah_pilihan->count()){
                $i=1;
                foreach ($sekolah_pilihan as $sekolah){
                    /*
                    $record= array();
                    $record['value'] 	= $rombel->rombongan_belajar_id;
                    $record['text'] 	= $rombel->nama;
                    $output['result'][] = $record;
                    */
                    $record = [];
                    $record['No'] = $i;
                    $record['Nama Siswa'] = strtoupper($sekolah->pendaftar->user->name);
                    $record['NIK'] = strtoupper($sekolah->pendaftar->user->username);
                    if($user->hasRole(['admin', 'dinas'])){
                        $record['SEKOLAH TUJUAN'] = strtoupper($sekolah->sekolah->nama);
                    }
                    if($jalur->tautan == 'zonasi'){
                        if($sekolah->pendaftar->bentuk_pendidikan_id == 5){
                            $record['UMUR (60%)'] = $sekolah->pendaftar->user->usia;
                            $record['JARAK (40%)'] = $sekolah->jarak;
                        } else {
                            $record['UMUR (5%)'] = $sekolah->pendaftar->user->usia;
                            $record['JARAK (90%)'] = $sekolah->jarak;
                            $record['NILAI RAPOR (5%)'] = $sekolah->nilai_mapel;
                        }
                    }
                    $record['NILAI AKHIR'] = $sekolah->nilai_akhir;
                    $output_array[] = $record;
                    $i++;
                }
            }
            $list = collect($output_array);
            return (new FastExcel($list))->download('Hasil Seleksi Jalur '.$jalur->nama.$jenjang.'PPDB Kab. Sampang.xlsx');
            //return FastExcel::data($list)->download('file.xlsx');
        }
    }
    public function cetak_excel(Request $request){
        $user = auth()->user();
        $all_jalur = Jalur::where('bentuk_pendidikan_id', $user->bentuk_pendidikan_id)->get();
        $all_sekolah = Sekolah::where('bentuk_pendidikan_id', $user->bentuk_pendidikan_id)->orderBy('nama')->withCount([
            'sekolah_pilihan as zonasi' => function($query){
                $query->whereHas('jalur', function($query){
                    $query->where('tautan', 'zonasi');
                });
                $query->whereHas('status', function($query){
                    $query->where('nama', 'Terima');
                });
                $query->where('kunci', 1);
            },
            'sekolah_pilihan as afirmasi' => function($query){
                $query->whereHas('jalur', function($query){
                    $query->where('tautan', 'afirmasi');
                });
                $query->whereHas('status', function($query){
                    $query->where('nama', 'Terima');
                });
                $query->where('kunci', 1);
            },
            'sekolah_pilihan as perpindahan' => function($query){
                $query->whereHas('jalur', function($query){
                    $query->where('tautan', 'perpindahan');
                });
                $query->whereHas('status', function($query){
                    $query->where('nama', 'Terima');
                });
                $query->where('kunci', 1);
            },
            'sekolah_pilihan as prestasi' => function($query){
                $query->whereHas('jalur', function($query){
                    $query->where('tautan', 'prestasi');
                });
                $query->whereHas('status', function($query){
                    $query->where('nama', 'Terima');
                });
                $query->where('kunci', 1);
            }
        ])->get();
        $i=1;
        $output_array = [];
        foreach ($all_sekolah as $sekolah){
            $record = [];
            $record['NO'] = $i;
            $record['NAMA SEKOLAH'] = strtoupper($sekolah->nama);
            $jml = 0;
            foreach ($all_jalur as $jalur){
                $record[strtoupper($jalur->nama)] = $sekolah->{$jalur->tautan};
                $jml += $sekolah->{$jalur->tautan};
            }
            $record['TOTAL'] = $jml;
            $output_array[] = $record;
            $i++;
        }
        $list = collect($output_array);
        //dd($list);
        //return (new FastExcel($list))->download('Rekapitulasi Hasil PPDB Kab. Sampang.xlsx');
        //$list = collect($output_array);
        return (new FastExcel($list))->download('Rekapitulasi Hasil PPDB Kab. Sampang.xlsx');
    }
    public function cetak_pdf(Request $request){
        $user = auth()->user();
        $all_jalur = Jalur::where('bentuk_pendidikan_id', $user->bentuk_pendidikan_id)->get();
        $all_sekolah = Sekolah::where('bentuk_pendidikan_id', $user->bentuk_pendidikan_id)->orderBy('nama')->withCount([
            'sekolah_pilihan as zonasi' => function($query){
                $query->whereHas('jalur', function($query){
                    $query->where('tautan', 'zonasi');
                });
                $query->whereHas('status', function($query){
                    $query->where('nama', 'Terima');
                });
                $query->where('kunci', 1);
            },
            'sekolah_pilihan as afirmasi' => function($query){
                $query->whereHas('jalur', function($query){
                    $query->where('tautan', 'afirmasi');
                });
                $query->whereHas('status', function($query){
                    $query->where('nama', 'Terima');
                });
                $query->where('kunci', 1);
            },
            'sekolah_pilihan as perpindahan' => function($query){
                $query->whereHas('jalur', function($query){
                    $query->where('tautan', 'perpindahan');
                });
                $query->whereHas('status', function($query){
                    $query->where('nama', 'Terima');
                });
                $query->where('kunci', 1);
            },
            'sekolah_pilihan as prestasi' => function($query){
                $query->whereHas('jalur', function($query){
                    $query->where('tautan', 'prestasi');
                });
                $query->whereHas('status', function($query){
                    $query->where('nama', 'Terima');
                });
                $query->where('kunci', 1);
            }
        ])->get();
        $data = [
            'all_sekolah' => $all_sekolah,
            'all_jalur' => $all_jalur,
            'user' => $user,
        ];
        $pdf = PDF::loadView('cetak.rekap_pdf', $data, [], [
            //'orientation' => 'L',
            //'default_font' => 'verdana',
            'temp_dir' => storage_path('framework/sessions'),
        ]);
        return $pdf->stream('Rekapitulasi Hasil PPDB Kab. Sampang.pdf');
        return $pdf->download('Rekapitulasi Hasil PPDB Kab. Sampang.pdf');
    }
    public function biodata(Request $request){
        $user = auth()->user();
        $jalur_id = $request->route('jalur_id');
        $sekolah_id = $request->route('sekolah_id');
        $jalur = Jalur::find($jalur_id);
        $users = User::where(function($query) use ($jalur_id, $sekolah_id){
            $query->whereHas('pendaftar', function($query) use ($jalur_id, $sekolah_id){
                $query->whereHas('sekolah_pilihan', function($query) use ($jalur_id, $sekolah_id){
                    $query->where('jalur_id', $jalur_id);
                    $query->whereHas('status', function($query){
                        $query->where('nama', 'Terima');
                    });
                    $query->where('kunci', 1);
                    $query->where('sekolah_id', $sekolah_id);
                });
            });
        })->select('name as NAMA', 'username as NIK', 'tempat_lahir as TEMPAT LAHIR', 'tanggal_lahir as TANGGAL LAHIR', 'jenis_kelamin as L/P', 'alamat as ALAMAT', 'rt as RT', 'rw as RW', 'desa as DESA/KELURAHAN', 'kecamatan as KECAMATAN', 'kabupaten as KABUPATEN', 'provinsi as PROVINSI', 'nama_ortu as ORTU/WALI', 'bujur AS BUJUR', 'lintang AS LINTANG')->orderBy('name')->get();
        /*$dokumen = Dokumen::whereHas('pendaftar', function($query) use ($jalur_id, $sekolah_id){
            $query->whereHas('sekolah_pilihan', function($query) use ($jalur_id, $sekolah_id){
                $query->where('jalur_id', $jalur_id);
                $query->whereHas('status', function($query){
                    $query->where('nama', 'Terima');
                });
                $query->where('kunci', 1);
                $query->where('sekolah_id', $sekolah_id);
            });
        })->with(['pendaftar.user'])->get();
        $nama_file = 'Biodata Peserta Didik Baru Jalur '.$jalur->nama;
        (new FastExcel($users))->export($nama_file.'.xlsx');
        $public_dir=public_path();
        $zipFileName = $nama_file.'.zip';
        $zip = new ZipArchive;
        if ($zip->open($public_dir . '/' . $zipFileName, ZipArchive::CREATE) === TRUE) {
            $file_excel = $nama_file.'.xlsx';
            $zip->addFile($public_dir . '/'.$file_excel,$file_excel);
            foreach($dokumen as $dok){
                $zip->addFile($public_dir . '/uploads/' . $dok->berkas, $dok->pendaftar->user->name.'-'.$dok->pendaftar->user->username.'/'.$dok->berkas);
            }
            $zip->close();
        }
        File::delete($public_dir.'/'.$nama_file.'.xlsx');
        $headers = array(
            'Content-Type' => 'application/octet-stream',
        );
        $filetopath=$public_dir.'/'.$zipFileName;
        if(file_exists($filetopath)){
            return response()->download($filetopath,$zipFileName,$headers)->deleteFileAfterSend(true);
        }
        */
        $nilai = User::where(function($query) use ($jalur_id, $sekolah_id){
            $query->whereHas('pendaftar', function($query) use ($jalur_id, $sekolah_id){
                $query->whereHas('sekolah_pilihan', function($query) use ($jalur_id, $sekolah_id){
                    $query->where('jalur_id', $jalur_id);
                    $query->whereHas('status', function($query){
                        $query->where('nama', 'Terima');
                    });
                    $query->where('kunci', 1);
                    $query->where('sekolah_id', $sekolah_id);
                });
            });
        })->with(['nilai.mapel'])->orderBy('name')->get();
        $nilai_jadi = [];
        foreach($nilai as $n){
            $output['NAMA SISWA'] = $n->name;
            foreach($n->nilai as $a){
                $output[$a->mapel->nama] = $a->nilai;
            }
            $nilai_jadi[] = $output;
        }
        $sheets = new SheetCollection([
            'Data Siswa' => $users,
            'Nilai' => $nilai_jadi,
        ]);
        return (new FastExcel($sheets))->download('Biodata Peserta Didik Baru Jalur '.$jalur->nama.'.xlsx');
    }
}
