<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Komponen;
use App\Jalur;
use App\Status;
use App\Kebutuhan_khusus;
use App\Jenis_tinggal;
use App\Agama;
use App\Mata_pelajaran;
use App\Tingkat_prestasi;
use App\Jenis_prestasi;

class RefSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('komponen')->truncate();
        DB::table('jalur')->truncate();
        DB::table('status')->truncate();
        DB::table('kebutuhan_khusus')->truncate();
        DB::table('jenis_tinggal')->truncate();
        DB::table('agama')->truncate();
        DB::table('mata_pelajaran')->truncate();
        DB::table('tingkat_prestasi')->truncate();
        DB::table('jenis_prestasi')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $ref_jalur = [
            [
                'bentuk_pendidikan_id' => 5,//sd
                'nama' => 'Zonasi',
                'kuota' => 75,
                'tautan' => 'zonasi',
                'icon' => 'edit',
                'card' => 'bg-success',
                'prestasi' => 0,
                'keterangan' => 'Jalur Zonasi 75 % (tujuh puluh lima persen) dari peserta didik yang diterima oleh satuan pendidikan secara serentak dan terpadu menggunakan sistem offline dan online. Komponen, bobot dan skor maksimum adalah sebagai berikut:',
                'komponen' => [
                    [
                        'nama' => 'Usia',
                        'bobot' => 60,
                        'skor' => 600,
                        'bukti' => 'Akte Kelahiran',
                        'tanggal' => 0,
                    ],
                    [
                        'nama' => 'Jarak tempat tinggal ke sekolah',
                        'bobot' => 40,
                        'skor' => 400,
                        'bukti' => 'KK (Kartu Keluarga) / Surat Keterangan Domisili',
                        'tanggal' => 1,
                    ],
                ],
                'jenis_prestasi' => NULL,
            ],
            [
                'bentuk_pendidikan_id' => 5,//sd
                'nama' => 'Afirmasi',
                'kuota' => 20,
                'tautan' => 'afirmasi',
                'icon' => 'bolt',
                'card' => 'bg-danger',
                'prestasi' => 0,
                'keterangan' => 'Jalur Afirmasi 20 % (dua puluh persen) bagi perserta didik yang berasal dari keluarga ekonomi  tidak mampu, dengan bukti keikutsertaan peserta didik dalam program penanganan keluarga tidak mampu, yang berdomisili di dalam atau di luar wilayah zonasi sekolah yang bersangkutan.',
                'komponen' => [
                    [
                        'nama' => 'KIP/PKH',
                        'bobot' => 0,
                        'skor' => 0,
                        'bukti' => 'Kartu KIP/Kartu PKH',
                        'tanggal' => 0,
                    ],
                ],
                'jenis_prestasi' => NULL,
            ],
            [
                'bentuk_pendidikan_id' => 5,//sd
                'nama' => 'Perpindahan',
                'kuota' => 5,
                'tautan' => 'perpindahan',
                'icon' => 'plane-departure',
                'card' => 'bg-warning',
                'prestasi' => 0,
                'keterangan' => 'Jalur perpindahan tugas orang tua/wali 5 % (lima persen) dari peserta didik yang diterima oleh satuan pendidikan secara serentak dan terpadu menggunakan sistem offline  dan online, dengan alasan meliputi perpindahan domisili orang tua/wali perserta didik, atau terjadi bencana alam/ sosial',
                'komponen' => [
                    [
                        'nama' => 'Surat Tugas',
                        'bobot' => 0,
                        'skor' => 0,
                        'bukti' => 'Surat Penugasan dari instansi, lembaga, kantor, atau perusahaan yang mempekerjakan Orang Tua/Wali siswa',
                        'tanggal' => 0,
                    ],
                ],
                'jenis_prestasi' => NULL,
            ],
            [
                'bentuk_pendidikan_id' => 6,//smp
                'nama' => 'Zonasi',
                'kuota' => 50,
                'tautan' => 'zonasi',
                'icon' => 'edit',
                'card' => 'bg-primary',
                'prestasi' => 1,
                'keterangan' => 'Jalur Zonasi 60 % (enam puluh persen) dari peserta didik yang diterima oleh satuan pendidikan secara      serentak dan terpadu menggunakan sistem offline  dan online, Komponen, bobot dan skor maksimum adalah sebagai berikut:',
                'komponen' => [
                    [
                        'nama' => 'Bukti Kelulusan',
                        'bobot' => 0,
                        'skor' => 0,
                        'bukti' => 'Ijazah/SKHUN/SKHU Sementara/Surat Keterangan Lulus',
                        'tanggal' => 0,
                    ],
                    [
                        'nama' => 'Jarak tempat tinggal ke sekolah',
                        'bobot' => 90,
                        'skor' => 900,
                        'bukti' => 'KK (Kartu Keluarga) / Surat Keterangan Domisili',
                        'tanggal' => 1,
                    ],
                    /*[
                        'nama' => 'Prestasi Akademik/Non-akademik',
                        'bobot' => 90,
                        'skor' => 900,
                        'bukti' => 'Piagam/sertifikat dari Dinas Terkait',
                        'tanggal' => 1,
                    ],*/
                    [
                        'nama' => 'Usia',
                        'bobot' => 5,
                        'skor' => 50,
                        'bukti' => 'Akte Kelahiran',
                        'tanggal' => 0,
                    ],
                ],
                'jenis_prestasi' => NULL,
            ],
            [
                'bentuk_pendidikan_id' => 6,//smp
                'nama' => 'Afirmasi',
                'kuota' => 15,
                'tautan' => 'afirmasi',
                'icon' => 'bolt',
                'card' => 'bg-success',
                'prestasi' => 0,
                'keterangan' => 'Jalur Afirmasi 15 % (lima belas persen) bagi perserta didik yang berasal dari keluarga ekonomi  tidak mampu, dengan bukti keikutsertaan peserta didik dalam program penanganan keluarga tidak mampu, yang berdomisili di dalam atau di luar wilayah zonasi sekolah yang bersangkutan',
                'komponen' => [
                    [
                        'nama' => 'Bukti Kelulusan',
                        'bobot' => 0,
                        'skor' => 0,
                        'bukti' => 'Ijazah/SKHUN/SKHU Sementara/Surat Keterangan Lulus',
                        'tanggal' => 0,
                    ],
                    [
                        'nama' => 'KIP/PKH',
                        'bobot' => 0,
                        'skor' => 0,
                        'bukti' => 'Kartu KIP/Kartu PKH',
                        'tanggal' => 0,
                    ],
                ],
                'jenis_prestasi' => NULL,
            ],
            [
                'bentuk_pendidikan_id' => 6,//smp
                'nama' => 'Perpindahan',
                'kuota' => 5,
                'tautan' => 'perpindahan',
                'icon' => 'plane-departure',
                'card' => 'bg-danger',
                'prestasi' => 0,
                'keterangan' => 'Jalur perpindahan tugas orang tua/wali 5 % (lima persen) dari peserta didik yang diterima oleh satuan pendidikan secara serentak dan terpadu menggunakan sistem offline  dan online, dengan alasan meliputi perpindahan domisili orang tua/wali perserta didik, atau terjadi bencana alam/ sosial.',
                'komponen' => [
                    [
                        'nama' => 'Bukti Kelulusan',
                        'bobot' => 0,
                        'skor' => 0,
                        'bukti' => 'Ijazah/SKHUN/SKHU Sementara/Surat Keterangan Lulus',
                        'tanggal' => 0,
                    ],
                    [
                        'nama' => 'Surat Tugas',
                        'bobot' => 0,
                        'skor' => 0,
                        'bukti' => 'Surat Penugasan dari instansi, lembaga, kantor, atau perusahaan yang mempekerjakan Orang Tua/Wali siswa',
                        'tanggal' => 0,
                    ],
                ],
                'jenis_prestasi' => NULL,
            ],
            [
                'bentuk_pendidikan_id' => 6,//smp
                'nama' => 'Prestasi',
                'kuota' => 20,
                'tautan' => 'prestasi',
                'icon' => 'trophy',
                'card' => 'bg-warning',
                'prestasi' => 1,
                'keterangan' => 'Jalur Prestasi 20 % (dua puluh persen) dari peserta didik yang diterima oleh satuan pendidikan secara serentak dan terpadu menggunakan sistem offline  dan online, Komponen, bobot dan skor maksimum adalah sebagai berikut:',
                'komponen' => [
                    [
                        'nama' => 'Bukti Kelulusan',
                        'bobot' => 0,
                        'skor' => 0,
                        'bukti' => 'Ijazah/SKHUN/SKHU Sementara/Surat Keterangan Lulus',
                        'tanggal' => 0,
                        'jenis_prestasi' => 0,
                    ],
                    /*[
                        'nama' => 'Prestasi Akademik/Non-akademik',
                        'bobot' => 90,
                        'skor' => 900,
                        'bukti' => 'Piagam/sertifikat dari Dinas Terkait',
                        'tanggal' => 1,
                        'jenis_prestasi' => 2,
                    ],*/
                    [
                        'nama' => 'Jarak tempat tinggal ke sekolah',
                        'bobot' => 5,
                        'skor' => 50,
                        'bukti' => 'KK (Kartu Keluarga) / Surat Keterangan Domisili',
                        'tanggal' => 1,
                        'jenis_prestasi' => 0,
                    ],
                    [
                        'nama' => 'Usia',
                        'bobot' => 5,
                        'skor' => 50,
                        'bukti' => 'Akte Kelahiran',
                        'tanggal' => 0,
                        'jenis_prestasi' => 0,
                    ],
                    /*[
                        'nama' => 'File Rapor',
                        'bobot' => 0,
                        'skor' => 0,
                        'bukti' => 'File Rapor Kelas IV Semester 1',
                        'tanggal' => 0,
                        'jenis_prestasi' => 1,
                    ],
                    [
                        'nama' => 'File Rapor',
                        'bobot' => 0,
                        'skor' => 0,
                        'bukti' => 'File Rapor Kelas IV Semester 2',
                        'tanggal' => 0,
                        'jenis_prestasi' => 1,
                    ],
                    [
                        'nama' => 'File Rapor',
                        'bobot' => 0,
                        'skor' => 0,
                        'bukti' => 'File Rapor Kelas V Semester 1',
                        'tanggal' => 0,
                        'jenis_prestasi' => 1,
                    ],
                    [
                        'nama' => 'File Rapor',
                        'bobot' => 0,
                        'skor' => 0,
                        'bukti' => 'File Rapor Kelas V Semester 2',
                        'tanggal' => 0,
                        'jenis_prestasi' => 1,
                    ],
                    [
                        'nama' => 'File Rapor',
                        'bobot' => 0,
                        'skor' => 0,
                        'bukti' => 'File Rapor Kelas VI Semester 1',
                        'tanggal' => 0,
                        'jenis_prestasi' => 1,
                    ],*/
                    [
                        'nama' => 'File Rapor',
                        'bobot' => 0,
                        'skor' => 0,
                        'bukti' => 'File Nilai Rapor',
                        'tanggal' => 0,
                        'jenis_prestasi' => 1,
                    ],
                ],
                'jenis_prestasi' => [
                    [
                        'nama' => 'Prestasi Akademik',
                    ],
                    [
                        'nama' => 'Prestasi Non Akademik',
                    ]
                ],
            ],
        ];
        $mata_pelajaran = [
            'Pendidikan Agama dan Budi Pekerti',
            'Pendidikan Pancasila dan Kewarganegaraan',
            'Bahasa Indonesia',
            'Matematika',
            'Ilmu Pengetahuan Alam',
            'Ilmu Pengetahuan Sosial',
            'Seni Budaya dan Prakarya',
            'Pendidikan Jasmani, Olahraga, dan Kesehatan',
            'Bahasa Madura',
        ];
        foreach($mata_pelajaran as $mapel){
            Mata_pelajaran::updateOrCreate([
                'nama' => $mapel,
            ]);
        }
        foreach($ref_jalur as $jalur){
            $create_jalur = Jalur::updateOrCreate([
                'bentuk_pendidikan_id' => $jalur['bentuk_pendidikan_id'],
                'nama' => $jalur['nama'],
                'kuota' => $jalur['kuota'],
                'tautan' => $jalur['tautan'],
                'icon' => $jalur['icon'],
                'card' => $jalur['card'],
                'prestasi' => $jalur['prestasi'],
                'keterangan' => $jalur['keterangan'],
            ]);
            if($jalur['komponen']){
                foreach($jalur['komponen'] as $komponen){
                    $jenis_prestasi = 0;
                    if(isset($komponen['jenis_prestasi'])){
                        $jenis_prestasi = $komponen['jenis_prestasi'];
                    }
                    Komponen::updateOrCreate([
                        'jalur_id' => $create_jalur->id,
                        'nama' => $komponen['nama'],
                        'bobot' => $komponen['bobot'],
                        'skor' => $komponen['skor'],
                        'bukti' => $komponen['bukti'],
                        'tanggal' => $komponen['tanggal'],
                        'jenis_prestasi' => $jenis_prestasi,
                    ]);
                }
            }
            if($jalur['jenis_prestasi']){
                foreach($jalur['jenis_prestasi'] as $jenis_prestasi){
                    Jenis_prestasi::updateOrCreate([
                        'jalur_id' => $create_jalur->id,
                        'nama' => $jenis_prestasi['nama'],
                    ]);
                }
            }
        }
        $ref_status = [
            ['nama' => 'Terima'],
            ['nama' => 'Perbaikan'],
            ['nama' => 'Tolak']
        ];
        foreach($ref_status as $status){
            $create_status = Status::updateOrCreate([
                'nama' => $status['nama'],
            ]);
        }
        $ref_kebutuhan_khusus = [
            ['nama' => 'Netra (A)'],
            ['nama' => 'Rungu (B)'],
            ['nama' => 'Grahita Ringan (C)'],
            ['nama' => 'Grahita Sedang (C1)'],
            ['nama' => 'Daksa Ringan (D)'],
            ['nama' => 'Daksa Sedang (D1)'],
            ['nama' => 'Laras (E)'],
            ['nama' => 'Wicara (F)'],
            ['nama' => 'Hyperaktif (H)'],
            ['nama' => 'Cerdas Istimewa (I)'],
            ['nama' => 'Bakat Istimewa (J)'],
            ['nama' => 'Kesulitan Belajar (K)'],
            ['nama' => 'Narkoba (N)'],
            ['nama' => 'Indigo (I)'],
            ['nama' => 'Down Syndrome (P)'],
            ['nama' => 'Autis (Q)'],
        ];
        foreach($ref_kebutuhan_khusus as $kebutuhan_khusus){
            $create_kebutuhan_khusus = Kebutuhan_khusus::updateOrCreate([
                'nama' => $kebutuhan_khusus['nama'],
            ]);
        }
        $ref_jenis_tinggal = [
            ['nama' => 'Bersama orang tua'],
            ['nama' => 'Wali'],
            ['nama' => 'Kost'],
            ['nama' => 'Asrama'],
            ['nama' => 'Panti Asuhan'],
            ['nama' => 'Pesantren'],
            ['nama' => 'Lainnya'],
        ];
        foreach($ref_jenis_tinggal as $jenis_tinggal){
            $create_jenis_tinggal = Jenis_tinggal::updateOrCreate([
                'nama' => $jenis_tinggal['nama'],
            ]);
        }
        $ref_agama = [
            ['nama' => "Islam"],
            ['nama' => "Kristen"],
            ['nama' => "Katholik"],
            ['nama' => "Hindu"],
            ['nama' => "Budha"],
            ['nama' => "Khonghucu"],
            ['nama' => "Kepercayaan kpd Tuhan YME"],
        ];
        foreach($ref_agama as $agama){
            $create_agama = Agama::updateOrCreate([
                'nama' => $agama['nama'],
            ]);
        }
        $tingkat_prestasi = ['Tingkat Internasional', 'Tingkat Nasional', 'Tingkat Provinsi', 'Tingkat Kabupaten'];
        foreach($tingkat_prestasi as $prestasi){
            Tingkat_prestasi::updateOrCreate([
                'nama' => $prestasi,
            ]);
        }
    }
}
