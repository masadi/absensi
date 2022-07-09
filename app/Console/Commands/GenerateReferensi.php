<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Jenis_absen;

class GenerateReferensi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:referensi';

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
        $jenis = [
            [
                'nama' => 'Absen Masuk',
                'slug' => 'masuk',
            ],
            [
                'nama' => 'Absen Pulang',
                'slug' => 'pulang',
            ]
        ];
        foreach($jenis as $j){
            Jenis_absen::updateOrCreate([
                'nama' => $j['nama'],
                'slug' => $j['slug'],
            ]);
        }
    }
}
