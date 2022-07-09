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
    protected $signature = 'generate:user {npsn}';

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
        $sync_sekolah = Http::get('http://103.40.55.242/erapor_server/sync/get_sekolah/'.$this->argument('npsn'));
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
            $this->info($sekolah->nama. ' berhasil disimpan. ID:'.$sekolah_id);
            $semester = Semester::create([
                'semester_id' => 20221,
                'nama' => '2022/2023 Ganjil',
                'semester' => 1,
                'periode_aktif' => 1,
            ]);
            Team::create([
                'name' => $semester->nama,
                'display_name' => $semester->nama,
                'description' => $semester->nama,
            ]);
            User::whereNotNull('email')->delete();
            $user = User::create([
                'sekolah_id' => $sekolah_id,
                'name' => 'Administrator',
                'email' => 'admin@smkariyametta.sch.id',
                'password' => bcrypt('12345678'),
            ]);
            $this->info($user->name. ' berhasil disimpan. ID:'.$user->sekolah_id);
            $role = Role::where('name', 'administrator')->first();
            $team = Team::where('name', $semester->nama)->first();
            $user->attachRole($role, $team);
            /*DB::table('role_user')->insert([
                'role_id' => $role->id,
                'user_id' => $user->id,
                'semester_id' => 20221,
                'user_type' => 'App\Models\User',
            ]);*/
            $user = User::create([
                'sekolah_id' => $sekolah_id,
                'name' => 'PTK',
                'email' => 'ptk@smkariyametta.sch.id',
                'password' => bcrypt('12345678'),
            ]);
            $this->info($user->name. ' berhasil disimpan. ID:'.$user->sekolah_id);
            $role = Role::where('name', 'ptk')->first();
            $user->attachRole($role, $team);
            /*DB::table('role_user')->insert([
                'role_id' => $role->id,
                'user_id' => $user->id,
                'semester_id' => 20221,
                'user_type' => 'App\Models\User',
            ]);*/
            $ptk = Ptk::create([
                'sekolah_id' => $sekolah_id,
                'user_id' => $user->id,
                'nama' => 'PTK',
                'nuptk' => 123,
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => date('Y-m-d'),
                'jenis_ptk_id' => 1,
                'agama_id' => 1,
                'status_kepegawaian_id' => 1,
            ]);
            $this->info($ptk->nama. ' berhasil disimpan. ID:'.$ptk->sekolah_id);
        } else {
            $this->error($data['Nama']. ' gagal disimpan');
        }
    }
}
