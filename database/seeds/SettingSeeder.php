<?php

use Illuminate\Database\Seeder;
use App\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting = [
            'tahun_pelajaran' => '2022/2023',
            'pendaftaran' => '2022-06-27',
            'pengumuman' => '2022-07-04',
            'tahun' => '2022',
            'id_level_wilayah' => 2,
            'kode_wilayah'    => '052700',
            'mst_kode_wilayah' => '052701AA',
            'semester_id'  => '20202',
            //'bentuk_pendidikan_id' => ['sd', 'smp'],
            'domain' => 'ppdbsampang.com',
            'wilayah' => 'Kabupaten Sampang',
            'seeder' => 'sampang',
            'tanggal_pengumuman' => '04 Juli 2022',
        ];
        Setting::truncate();
        foreach($setting as $key=>$value){
            Setting::updateOrCreate(
                [
                    'key' => $key,
                ],
                [
                    'value' => $value
                ]
            );
        }
    }
}
