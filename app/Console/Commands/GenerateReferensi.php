<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Nama_hari;
use App\Models\Semester;

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
        $nama_hari = collect(["Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Minggu"]);
        foreach($nama_hari as $hari){
            Nama_hari::updateOrCreate(['nama' => $hari]);
        }
        $this->info('Nama hari berhasil diproses');
        Semester::updateOrCreate([
            'semester_id' => 20211,
            'nama' => '2021/2022 Ganjil',
            'semester' => 1,
            'periode_aktif' => 0,
        ]);
        Semester::updateOrCreate([
            'semester_id' => 20212,
            'nama' => '2021/2022 Genap',
            'semester' => 2,
            'periode_aktif' => 0,
        ]);
    }
}
