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
            'tahun_ajaran_id' => '2022',
            'semester_id' => '20221',
            'bujur' => '',
            'lintang' => '',
            'radius' => 100,
            'waktu_masuk_start' => '06.59',
            'waktu_masuk_end'    => '07.30',
            'waktu_pulang_start' => '12.59',
            'waktu_pulang_end'  => '13.30',
            'nama_sekolah' => 'Sekolah Contoh',
            'copyright' => 'CV. Cyber Electra &trade;',
            'versi' => '1.0',
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
