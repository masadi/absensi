@extends('layouts.app_statis')
@section('title', 'Pengumuman Hasil')
@section('content')
<section>
    <div class="container" data-aos="fade-up" id="hasil">
        <div class="section-title">
            <h3 style="margin-bottom: 0px; text-align:center; color:red">HASIL SELEKSI JENJANG {{($jalur->bentuk_pendidikan_id == 5) ? 'SD' : 'SMP'}}</h3>
            <h4 style="text-align:center">PPDB SD/SMP {{ config('ppdb.wilayah', 'Kab. Sampang') }} {{ config('ppdb.tahun_pelajaran', '2022/2023') }}</h4>
            <h4 style="text-align:center">{{strtoupper($sekolah->nama)}}</h4>
            <h4 style="text-align:center">JALUR {{strtoupper($jalur->nama)}}</h4>
        </div>
        <div class="row">
            <div class="col-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">Rangking</th>
                            <th class="text-center">Nama Siswa</th>
                            <th class="text-center">NIK</th>
                            <!--th class="text-center">Usia</th>
                            <th class="text-center">Jarak Ke Sekolah Tujuan</th-->
                            <th class="text-center">Nilai Akhir</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($sekolah_pilihan->count())
                            @foreach ($sekolah_pilihan as $sekolah)
                            <tr>
                                <td class="text-center">{{$loop->iteration}}</td>
                                <td>{{strtoupper($sekolah->pendaftar->user->name)}}</td>
                                <td class="text-center">{{strtoupper($sekolah->pendaftar->user->username)}}</td>
                                <!--td class="text-center">{{$sekolah->pendaftar->user->usia}} Tahun</td>
                                <td class="text-center">{{$sekolah->jarak}} Meter</td-->
                                <td class="text-center">{{$sekolah->nilai_akhir}}</td>
                                <td class="text-center">Diterima</td>
                            </tr>
                            @endforeach
                        @else
                        <tr>
                            <td class="text-center" colspan="6">Tidak ada data untuk ditampilkan</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section><!-- End Team Section -->
@endsection