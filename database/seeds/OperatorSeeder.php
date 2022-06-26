<?php

use Illuminate\Database\Seeder;

class OperatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            LaratrustSeeder::class,
            PendaftarSeeder::class,
        ]);
        /*$sekolah = App\Sekolah::get();
        foreach($sekolah as $s){
            $user_sekolah = App\User::updateOrCreate(
                ['email' => $s->email],
                [
                    'sekolah_id' => strtolower($s->sekolah_id),
                    'username' => $s->npsn,
                    'name' => 'Operator '.$s->nama,
                    'lintang' => $s->lintang,
                    'bujur' => $s->bujur,
                    'bentuk_pendidikan_id' => $s->bentuk_pendidikan_id,
                    'password' => bcrypt($s->npsn)
                ]
            );
            if(!$user_sekolah->hasRole('sekolah')){
                $role = App\Role::where('name', 'sekolah')->first();
                $user_sekolah->attachRole($role);
            }
        }*/
    }
}
