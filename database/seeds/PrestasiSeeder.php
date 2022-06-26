<?php

use Illuminate\Database\Seeder;
use App\Jenis_kejuaraan;
use App\Skor_prestasi;
use App\Tingkat_prestasi;
class PrestasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data_skor = [
            [
                'nama' => 'Perorangan',
                'tingkat_prestasi' => [
                    [
                        'nama' => 'Tingkat Internasional',
                        'juara' => [
                            [
                                'nama' => 1,
                                'skor' => 850,
                            ],
                            [
                                'nama' => 2,
                                'skor' => 825,
                            ],
                            [
                                'nama' => 3,
                                'skor' => 800,
                            ]
                        ]
                    ],
                    [
                        'nama' => 'Tingkat Nasional',
                        'juara' => [
                            [
                                'nama' => 1,
                                'skor' => 800,
                            ],
                            [
                                'nama' => 2,
                                'skor' => 775,
                            ],
                            [
                                'nama' => 3,
                                'skor' => 750,
                            ]
                        ]
                    ],
                    [
                        'nama' => 'Tingkat Provinsi',
                        'juara' => [
                            [
                                'nama' => 1,
                                'skor' => 750,
                            ],
                            [
                                'nama' => 2,
                                'skor' => 725,
                            ],
                            [
                                'nama' => 3,
                                'skor' => 700,
                            ]
                        ]
                    ],
                    [
                        'nama' => 'Tingkat Kabupaten',
                        'juara' => [
                            [
                                'nama' => 1,
                                'skor' => 700,
                            ],
                            [
                                'nama' => 2,
                                'skor' => 675,
                            ],
                            [
                                'nama' => 3,
                                'skor' => 650,
                            ]
                        ]
                    ]
                ]
            ], 
            [
                'nama' => 'Kelompok',
                'tingkat_prestasi' => [
                    [
                        'nama' => 'Tingkat Internasional',
                        'juara' => [
                            [
                                'nama' => 1,
                                'skor' => 800,
                            ],
                            [
                                'nama' => 2,
                                'skor' => 775,
                            ],
                            [
                                'nama' => 3,
                                'skor' => 750,
                            ]
                        ]
                    ],
                    [
                        'nama' => 'Tingkat Nasional',
                        'juara' => [
                            [
                                'nama' => 1,
                                'skor' => 750,
                            ],
                            [
                                'nama' => 2,
                                'skor' => 725,
                            ],
                            [
                                'nama' => 3,
                                'skor' => 700,
                            ]
                        ]
                    ],
                    [
                        'nama' => 'Tingkat Provinsi',
                        'juara' => [
                            [
                                'nama' => 1,
                                'skor' => 700,
                            ],
                            [
                                'nama' => 2,
                                'skor' => 675,
                            ],
                            [
                                'nama' => 3,
                                'skor' => 650,
                            ]
                        ]
                    ],
                    [
                        'nama' => 'Tingkat Kabupaten',
                        'juara' => [
                            [
                                'nama' => 1,
                                'skor' => 650,
                            ],
                            [
                                'nama' => 2,
                                'skor' => 625,
                            ],
                            [
                                'nama' => 3,
                                'skor' => 600,
                            ]
                        ]
                    ]
                ]
            ]
        ];
        foreach($data_skor as $skor){
            $jenis = Jenis_kejuaraan::updateOrCreate(['nama' => $skor['nama']]);
            foreach($skor['tingkat_prestasi'] as $tingkat_prestasi){
                $tingkat = Tingkat_prestasi::updateOrCreate([
                    'nama' => $tingkat_prestasi['nama'],
                ]);
                foreach($tingkat_prestasi['juara'] as $juara){
                    Skor_prestasi::updateOrCreate([
                        'jenis_kejuaraan_id' => $jenis->id,
                        'tingkat_prestasi_id' => $tingkat->id,
                        'peringkat' => $juara['nama'],
                        'skor' => $juara['skor'],
                    ]);
                }
            }
        }
    }
}
