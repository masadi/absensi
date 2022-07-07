<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Role;
use App\Models\Team;
use App\Models\Semester;

class GenerateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:user';

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
            'name' => 'Administrator',
            'email' => 'admin@smkariyametta.sch.id',
            'password' => bcrypt('12345678'),
        ]);
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
            'name' => 'PTK',
            'email' => 'ptk@smkariyametta.sch.id',
            'password' => bcrypt('12345678'),
        ]);
        $role = Role::where('name', 'ptk')->first();
        $user->attachRole($role, $team);
        /*DB::table('role_user')->insert([
            'role_id' => $role->id,
            'user_id' => $user->id,
            'semester_id' => 20221,
            'user_type' => 'App\Models\User',
        ]);*/
    }
}
