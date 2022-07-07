<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Role;

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
        User::whereNotNull('email')->delete();
        $user = User::create([
            'name' => 'Administrator',
            'email' => 'admin@smkariyametta.sch.id',
            'password' => bcrypt('12345678'),
        ]);
        $role = Role::where('name', 'administrator')->first();
        $user->attachRole($role);
        $user = User::create([
            'name' => 'PTK',
            'email' => 'ptk@smkariyametta.sch.id',
            'password' => bcrypt('12345678'),
        ]);
        $role = Role::where('name', 'ptk')->first();
        $user->attachRole($role);
    }
}
