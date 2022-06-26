<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\User::whereRoleIs('admin')->whereNotNull('bentuk_pendidikan_id')->delete();
        $role = App\Role::where('name', 'admin')->first();
        $user_sd = \App\User::create([
            'name' => 'Admin Dinas (SD)',
            'username' => 'dinas_sd',
            'bentuk_pendidikan_id' => 5,
            'email' => 'dinas_sd@'.config('ppdb.domain', 'disdik.sampangkab.go.id'),
            'password' => bcrypt('12345678')
        ]);
        $user_sd->attachRole($role);
        $user_smp = \App\User::create([
            'name' => 'Admin Dinas (SMP)',
            'username' => 'dinas_smp',
            'bentuk_pendidikan_id' => 6,
            'email' => 'dinas_smp@'.config('ppdb.domain', 'disdik.sampangkab.go.id'),
            'password' => bcrypt('12345678')
        ]);
        $user_smp->attachRole($role);
    }
}
