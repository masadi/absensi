<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;

class ResetPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:password';

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
        $user = User::whereRoleIs('admin')->first();
        $user->email = 'admin@ppdbsampang.com';
        $user->password = bcrypt('#_*2022$pBdB$_#');
        $user->save();
        dump($user->email);
    }
}
