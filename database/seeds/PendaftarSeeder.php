<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Pendaftar;
use App\Sekolah;
use App\Sekolah_pilihan;
use App\Jalur;

class PendaftarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::whereRoleIs('siswa')->delete();
        DB::table('pendaftar')->delete();
        factory(App\User::class, 10)->create(['bentuk_pendidikan_id' => 5]);
        factory(App\User::class, 10)->create(['bentuk_pendidikan_id' => 6]);
        /*$users_sd = User::whereRoleIs('siswa')->where('bentuk_pendidikan_id', 5)->doesntHave('pendaftar')->get();
        foreach($users_sd as $user){
            $count_pendaftar = Pendaftar::where('bentuk_pendidikan_id', $user->bentuk_pendidikan_id)->where('user_id', '<>', $user->user_id)->count() + 1;
            $jenjang = ($user->bentuk_pendidikan_id == 5) ? 'SD' : 'SMP';
            $nomor_pendaftaran = $jenjang.'-'.str_pad($count_pendaftar,5,0,STR_PAD_LEFT).'-'.date('d-m-Y');
            $all_data = Pendaftar::create(
                [
                    'user_id' => $user->user_id,
                    'nomor_pendaftaran' => $nomor_pendaftaran,
                    'bentuk_pendidikan_id' => $user->bentuk_pendidikan_id,
                    'jenis_kelamin' => $user->jenis_kelamin,
                ]
            );
            $sekolah = Sekolah::where('bentuk_pendidikan_id', $user->bentuk_pendidikan_id)->where('bludak', 1)->first();
            $jalur = Jalur::where('bentuk_pendidikan_id', $user->bentuk_pendidikan_id)->inRandomOrder()->first();
            $sekolah_pilihan = Sekolah_pilihan::updateOrCreate(
                [
                    'pendaftar_id' => $all_data->pendaftar_id,
                    'sekolah_id' => $sekolah->sekolah_id,
                ],
                [
                    'jalur_id' => $jalur->id,
                    'pilihan_ke' => 1,
                    'tampil' => 1,
                ]
            );
        }
        $users_smp = User::whereRoleIs('siswa')->where('bentuk_pendidikan_id', 6)->doesntHave('pendaftar')->get();
        foreach($users_smp as $user){
            $count_pendaftar = Pendaftar::where('bentuk_pendidikan_id', $user->bentuk_pendidikan_id)->where('user_id', '<>', $user->user_id)->count() + 1;
            $jenjang = ($user->bentuk_pendidikan_id == 5) ? 'SD' : 'SMP';
            $nomor_pendaftaran = $jenjang.'-'.str_pad($count_pendaftar,5,0,STR_PAD_LEFT).'-'.date('d-m-Y');
            $all_data = Pendaftar::create(
                [
                    'user_id' => $user->user_id,
                    'nomor_pendaftaran' => $nomor_pendaftaran,
                    'bentuk_pendidikan_id' => $user->bentuk_pendidikan_id,
                    'jenis_kelamin' => $user->jenis_kelamin,
                ]
            );
            $sekolah = Sekolah::where('bentuk_pendidikan_id', $user->bentuk_pendidikan_id)->where('bludak', 1)->first();
            $jalur = Jalur::where('bentuk_pendidikan_id', $user->bentuk_pendidikan_id)->inRandomOrder()->first();
            $sekolah_pilihan = Sekolah_pilihan::updateOrCreate(
                [
                    'pendaftar_id' => $all_data->pendaftar_id,
                    'sekolah_id' => $sekolah->sekolah_id,
                ],
                [
                    'jalur_id' => $jalur->id,
                    'pilihan_ke' => 1,
                    'tampil' => 1,
                ]
            );
        }*/
    }
}
