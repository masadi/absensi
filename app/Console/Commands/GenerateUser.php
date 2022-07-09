<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Role;
use App\Models\Team;
use App\Models\Semester;
use App\Models\Ptk;
use App\Models\Sekolah;

class GenerateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:user {semester_id} {npsn?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $npsn = ['69762158', '20607013', '20606862', '20613916'];
        $semester = Semester::updateOrCreate([
            'semester_id' => 20221,
            'nama' => '2022/2023 Ganjil',
            'semester' => 1,
            'periode_aktif' => 1,
        ]);
        $team = Team::updateOrCreate([
            'name' => $semester->nama,
            'display_name' => $semester->nama,
            'description' => $semester->nama,
        ]);
        User::whereNotNull('email')->delete();
        $user = User::create([
            'name' => 'Administrator',
            'email' => 'admin@smkariyametta.sch.id',
            'password' => bcrypt('12345678'),
        ]);
        $this->info($user->name. ' berhasil disimpan. ID:'.$user->sekolah_id);
        $role = Role::where('name', 'administrator')->first();
        $user->attachRole($role, $team);
        if($this->argument('npsn')){
            $this->sedot_sekolah($this->argument('npsn'), $team);
        } else {
            foreach($npsn as $n){
                $this->sedot_sekolah($n, $team);
            }
        }
    }
    private function sedot_sekolah($npsn, $team){
        $sync_sekolah = Http::get('http://103.40.55.242/erapor_server/sync/get_sekolah/'.$npsn);
        $sekolah = json_decode($sync_sekolah->body());
        if(isset($sekolah->data[0])){
            $sekolah = $sekolah->data[0];
            $sekolah_id = strtolower($sekolah->sekolah_id);
            $new_sekolah = Sekolah::updateOrCreate(
                ['sekolah_id' => $sekolah_id],
                [
                    'npsn' => $sekolah->npsn,
                    'nama' => $sekolah->nama,
                    'nss' => $sekolah->nss,
                    'alamat' => $sekolah->alamat_jalan,
                    'desa_kelurahan' => $sekolah->desa_kelurahan,
                    'kode_pos' => $sekolah->kode_pos,
                    'lintang' => $sekolah->lintang,
                    'bujur' => $sekolah->bujur,
                    'no_telp' => $sekolah->nomor_telepon,
                    'no_fax' => $sekolah->nomor_fax,
                    'email' => $sekolah->email,
                    'website' => $sekolah->website,
                    'status_sekolah' => $sekolah->status_sekolah,
                ]
            );
            $response = Http::withHeaders([
                'x-api-key' => $sekolah_id,
            ])->withBasicAuth('admin', '1234')->asForm()->post('http://103.40.55.242/erapor_server/api/ptk', [
                'username_dapo'		=> $sekolah->username,
                'password_dapo'		=> $sekolah->password,
                'tahun_ajaran_id'	=> substr($this->argument('semester_id'),0,4),
                'semester_id'		=> $this->argument('semester_id'),
                'sekolah_id'		=> $sekolah_id,
                'npsn'				=> $sekolah->npsn,
            ]);
            if($response->successful()){
                $all_data = $response->object();
                $role = Role::where('name', 'ptk')->first();
                foreach($all_data->dapodik as $dapodik){
                    $email = ($dapodik->email) ?? $this->generateEmail();
                    $user = User::updateOrCreate(
                        [
                            'email' => $email,
                        ],
                        [
                        'sekolah_id' => $sekolah_id,
                        'name' => strtoupper($dapodik->nama),
                        'password' => bcrypt('12345678'),
                        ]
                    );
                    $this->info($user->name. ' berhasil disimpan. ID:'.$user->sekolah_id);
                    $user->attachRole($role, $team);
                    $ptk = Ptk::updateOrCreate(
                        ['ptk_id' => strtolower($dapodik->ptk_id)],
                        [
                        'sekolah_id' => $sekolah_id,
                        'user_id' => $user->id,
                        'nama' => strtoupper($dapodik->nama),
                        'nuptk' => ($dapodik->nuptk) ? $dapodik->nuptk : 123,
                        'jenis_kelamin' => $dapodik->jenis_kelamin,
                        'tempat_lahir' => $dapodik->tempat_lahir,
                        'tanggal_lahir' => $dapodik->tanggal_lahir,
                        'jenis_ptk_id' => $dapodik->jenis_ptk_id,
                        'agama_id' => $dapodik->agama_id,
                        'status_kepegawaian_id' => $dapodik->status_kepegawaian_id,
                        'email' => $email,
                        ]
                    );
                    $this->info($ptk->nama. ' berhasil disimpan. ID:'.$ptk->sekolah_id);
                }
            }
            $this->info($sekolah->nama. ' berhasil disimpan. ID:'.$sekolah_id);
        } else {
            $this->error($data['Nama']. ' gagal disimpan');
        }
    }
    private function generateEmail(){
        $random = Str::random(6);
        return strtolower($random).'@ariyametta.sch.id';
    }
}
