<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Sekolah;
use App\User;
use App\Role;
use App\Wilayah;
use App\Pagu;
use App\Jalur;
use Illuminate\Support\Facades\Storage;

class SekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    private function get_wilayah($id_level_wilayah, $kode_wilayah, $semester_id){
        $all_data = [];
        if(!Storage::disk('public')->exists('wilayah-'.$id_level_wilayah.'-'.$kode_wilayah.'-'.$semester_id.'.json')){
            $response = Http::withOptions([
                'verify' => false
            ])->get('https://dapo.kemdikbud.go.id/rekap/dataSekolah', [
                'id_level_wilayah' => $id_level_wilayah,
                'kode_wilayah' => $kode_wilayah,
                'semester_id' => $semester_id,
            ]);
            if(!$response->failed()){
                Storage::disk('public')->put('wilayah-'.$id_level_wilayah.'-'.$kode_wilayah.'-'.$semester_id.'.json', $response->body());
                $all_data = json_decode($response->body());
            } else {
                $this->get_wilayah($id_level_wilayah, $kode_wilayah, $semester_id);
            }
        } else {
            $json = Storage::disk('public')->get('wilayah-'.$id_level_wilayah.'-'.$kode_wilayah.'-'.$semester_id.'.json');
            $all_data = json_decode($json);
        }
        return $all_data;
    }
    private function get_sekolah($id_level_wilayah, $kode_wilayah, $semester_id, $bentuk_pendidikan_id){
        $all_data = [];
        if(!Storage::disk('public')->exists('sekolah-'.$id_level_wilayah.'-'.$kode_wilayah.'-'.$semester_id.'-'.$bentuk_pendidikan_id.'.json')){
            $response = Http::withOptions([
                'verify' => false
            ])->get('https://dapo.kemdikbud.go.id/rekap/progresSP', [
                'id_level_wilayah' => $id_level_wilayah,
                'kode_wilayah' => trim($kode_wilayah),
                'semester_id' => $semester_id,
                'bentuk_pendidikan_id' => $bentuk_pendidikan_id,
            ]);
            if(!$response->failed()){
                Storage::disk('public')->put('sekolah-'.$id_level_wilayah.'-'.$kode_wilayah.'-'.$semester_id.'-'.$bentuk_pendidikan_id.'.json', $response->body());
                $all_data = json_decode($response->body());
            } else {
                $this->get_sekolah($id_level_wilayah, $kode_wilayah, $semester_id, $bentuk_pendidikan_id);
            }
        } else {
            $json = Storage::disk('public')->get('sekolah-'.$id_level_wilayah.'-'.$kode_wilayah.'-'.$semester_id.'-'.$bentuk_pendidikan_id.'.json');
            $all_data = json_decode($json);
        }
        return $all_data;
    }
    private function sedot_sekolah($npsn){
        $sekolah = NULL;
        if(!Storage::disk('public')->exists('sekolah-'.$npsn.'.json')){
            $response = Http::get('http://103.40.55.242/erapor_server/sync/get_sekolah/'.$npsn);
            if(!$response->failed()){
                Storage::disk('public')->put('sekolah-'.$npsn.'.json', $response->body());
                $sekolah = json_decode($response->body());
            }  else {
                $this->sedot_sekolah($npsn);
            }
        } else {
            $json = Storage::disk('public')->get('sekolah-'.$npsn.'.json');
            $sekolah = json_decode($json);
        }
        return $sekolah;
    }
    private function save_sekolah($item){
        $config = config('ppdb');
        $sekolah = $this->sedot_sekolah($item['NPSN']);
        if($sekolah){
            $sekolah = $sekolah->data[0];
            $wilayah = Wilayah::with('parrentRecursive')->withTrashed()->find($sekolah->kode_wilayah);
            $kecamatan_id = NULL;
            $kabupaten_id = NULL;
            $provinsi_id = NULL;
            $kecamatan = NULL;
            $kabupaten = NULL;
            $provinsi = NULL;
            if($wilayah->parrentRecursive){
                $kecamatan_id = $wilayah->parrentRecursive->kode_wilayah;
                $kecamatan = $wilayah->parrentRecursive->nama;
                if($wilayah->parrentRecursive->parrentRecursive){
                    $kabupaten_id = $wilayah->parrentRecursive->parrentRecursive->kode_wilayah;
                    $kabupaten = $wilayah->parrentRecursive->parrentRecursive->nama;
                }
                if($wilayah->parrentRecursive->parrentRecursive->parrentRecursive){
                    $provinsi_id = $wilayah->parrentRecursive->parrentRecursive->parrentRecursive->kode_wilayah;
                    $provinsi = $wilayah->parrentRecursive->parrentRecursive->parrentRecursive->nama;
                }
            }
            Sekolah::updateOrCreate(
                ['sekolah_id' => strtolower($sekolah->sekolah_id)],
                [
                    'npsn' => $sekolah->npsn,
                    'nama' => $item['NAMA'],
                    'nss' => $sekolah->nss,
                    'bentuk_pendidikan_id' => $sekolah->bentuk_pendidikan_id,
                    'alamat' => $sekolah->alamat_jalan,
                    'desa_kelurahan' => $sekolah->desa_kelurahan,
                    'kecamatan' => $kecamatan,
                    'kode_wilayah' => $sekolah->kode_wilayah,
                    'kabupaten' => $kabupaten,
                    'provinsi' => $provinsi,
                    'kode_pos' => $sekolah->kode_pos,
                    'lintang' => $sekolah->lintang,
                    'bujur' => $sekolah->bujur,
                    'no_telp' => $sekolah->nomor_telepon,
                    'no_fax' => $sekolah->nomor_fax,
                    'email' => $sekolah->email,
                    'website' => $sekolah->website,
                    'status_sekolah' => $sekolah->status_sekolah,
                    'kecamatan_id' => $kecamatan_id,
                    'kabupaten_id' => $kabupaten_id,
                    'provinsi_id' => $provinsi_id,
                    'jml_rombel' => $item['ROMBEL'],
                    'bludak' => $item['BLUDAK'],
                ]
            );
            $email = ($sekolah->email) ? $sekolah->email : $sekolah->npsn.'@'.$config['domain'];
            $user_sekolah = User::updateOrCreate(
                ['email' => $email],
                [
                    'sekolah_id' => strtolower($sekolah->sekolah_id),
                    'username' => $sekolah->npsn,
                    'name' => 'Operator '.$item['NAMA'],
                    'lintang' => $sekolah->lintang,
                    'bujur' => $sekolah->bujur,
                    'bentuk_pendidikan_id' => $sekolah->bentuk_pendidikan_id,
                    'password' => bcrypt($sekolah->npsn)
                ]
            );
            if(!$user_sekolah->hasRole('sekolah')){
                $role = Role::where('name', 'sekolah')->first();
                $user_sekolah->attachRole($role);
            }
            $zonasi = Jalur::where('bentuk_pendidikan_id', $sekolah->bentuk_pendidikan_id)->where('tautan', 'zonasi')->first();
            Pagu::updateOrCreate(
                [
                    'sekolah_id' => strtolower($sekolah->sekolah_id),
                    'jalur_id' => $zonasi->id,
                
                ],
                [
                    'jumlah' => $item['ZONASI'],
                ]
            );
            $afirmasi = Jalur::where('bentuk_pendidikan_id', $sekolah->bentuk_pendidikan_id)->where('tautan', 'afirmasi')->first();
            Pagu::updateOrCreate(
                [
                    'sekolah_id' => strtolower($sekolah->sekolah_id),
                    'jalur_id' => $afirmasi->id,
                ],
                [
                    'jumlah' => $item['AFIRMASI'],
                ]
            );
            $perpindahan = Jalur::where('bentuk_pendidikan_id', $sekolah->bentuk_pendidikan_id)->where('tautan', 'perpindahan')->first();
            Pagu::updateOrCreate(
                [
                    'sekolah_id' => strtolower($sekolah->sekolah_id),
                    'jalur_id' => $perpindahan->id,
                ],
                [
                    'jumlah' => $item['PERPINDAHAN'],
                ]
            );
            if($item['PRESTASI']){
                $prestasi = Jalur::where('bentuk_pendidikan_id', $sekolah->bentuk_pendidikan_id)->where('tautan', 'prestasi')->first();
                Pagu::updateOrCreate(
                    [
                        'sekolah_id' => strtolower($sekolah->sekolah_id),
                        'jalur_id' => $prestasi->id,
                    ],
                    [
                        'jumlah' => $item['PRESTASI'],
                    ]
                );
            }
        } else {
            $this->save_sekolah($item['NPSN']);
        }
    }
    private function insert_sekolah($all_sekolah){
        $config = config('ppdb');
        foreach($all_sekolah as $data_sekolah){
            if($data_sekolah->status_sekolah == 'Negeri'){
                $this->save_sekolah($data_sekolah->npsn);
            }
        }
    }
    public function run()
    {
        DB::table('pagu')->delete();
        $sekolah = (new FastExcel)->import('public/template-sekolah_'.config('ppdb.seeder', 'sampang').'.xlsx', function ($item){
            $this->save_sekolah($item);
        });
        /*
        $config = config('ppdb');
        $all_data = $this->get_wilayah($config['id_level_wilayah'], $config['kode_wilayah'], $config['semester_id']);
        foreach($all_data as $data){
            foreach($config['bentuk_pendidikan_id'] as $bentuk_pendidikan_id){
                $all_sekolah = $this->get_sekolah($data->id_level_wilayah, trim($data->kode_wilayah), $config['semester_id'], $bentuk_pendidikan_id);
                if(count($all_sekolah)){
                    $this->insert_sekolah($all_sekolah);
                } else {
                    $all_wilayah = $this->get_wilayah($data->id_level_wilayah, trim($data->kode_wilayah), $config['semester_id']);
                    if(count($all_wilayah)){
                        foreach($all_wilayah as $wilayah){
                            $all_sekolah = $this->get_sekolah($wilayah->id_level_wilayah, trim($wilayah->kode_wilayah), $config['semester_id'], $bentuk_pendidikan_id);
                            $all_sekolah = json_decode($get_sekolah->body());
                            $this->insert_sekolah($all_sekolah);
                        }
                    }
                }
            }
        }
        $user_sd = User::updateOrCreate(
            [
                'name' => 'Pendaftar SD',
                'username' => '1234567890123456',
                'email' => '1234567890123456@'.$config['domain'],
                'bentuk_pendidikan_id' => 5,
            ],
            [
                'sandi' => '1234567890123456',
                'password' => Hash::make('1234567890123456'),
            ]
        );
        if(!$user_sd->hasRole('siswa')){
            $role = Role::where('name', 'siswa')->first();
            $user_sd->attachRole($role);
        }
        $user_smp = User::updateOrCreate(
            [
                'name' => 'Pendaftar SMP',
                'username' => '1234567890123455',
                'email' => '1234567890123455@'.$config['domain'],
                'bentuk_pendidikan_id' => 6,
            ],
            [
                'sandi' => '1234567890123455',
                'password' => Hash::make('1234567890123455'),
            ]
        );
        if(!$user_smp->hasRole('siswa')){
            $role = Role::where('name', 'siswa')->first();
            $user_smp->attachRole($role);
        }*/
    }
}
