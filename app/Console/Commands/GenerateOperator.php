<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Sekolah;
Use App\Role;
use Rap2hpoutre\FastExcel\FastExcel;

class GenerateOperator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:operator';

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
        User::whereRoleIs(['dinas', 'sekolah'])->delete();
        $komponen = (new FastExcel)->import('public/operator_sampang.xlsx', function ($item){
            if($item['NPSN']){
                $sekolah = Sekolah::where('npsn', $item['NPSN'])->first();
                if(!$sekolah){
                    $this->call('sedot:sekolah', ['npsn' => $item['NPSN']]);
                    $sekolah = Sekolah::where('npsn', $item['NPSN'])->first();
                }
            }
            $nama = ($item['NPSN']) ? 'sekolah' : 'dinas';
            $role = Role::where('name', $nama)->first();
            $user = User::updateOrCreate(
                [
                    'email' => $item['EMAIL'],
                ],
                [
                    'sekolah_id' => ($item['NPSN']) ? $sekolah->sekolah_id : NULL,
                    'name' => $item['NAMA'],
                    'username' => $item['PASSWORD'],
                    'nomor_hp' => $item['WA'],
                    'password' => bcrypt($item['PASSWORD']),
                    'bentuk_pendidikan_id' => ($item['NPSN']) ? $sekolah->bentuk_pendidikan_id : NULL,
                ]
            );
            if(!$user->hasRole($nama)){
                $user->attachRole($role);
            }
        });
    }
}
