<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Kategori;
use App\Models\Jam;

class GenerateDummy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:dummy {sekolah_id}';

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
        $this->info('Generate Dummy Start');
        $kategori = Kategori::create([
            'sekolah_id' => $this->argument('sekolah_id'),
            'nama' => 'Hari Aktif',
            'is_libur' => 0,
        ]);
        Jam::create([
            'kategori_id' => $kategori->id,
            'scan_masuk_start' => '06:00',
            'scan_masuk_end' => '07:00',
            'waktu_akhir_masuk' => '08:00',
            'scan_pulang_start' => '09:00',
            'scan_pulang_end' => '09:00',
        ]);
        $this->info('Generate Dummy End');
    }
}
