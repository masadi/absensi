@extends('layouts.cetak')
@section('content')
<htmlpagefooter name="page-footer">
    <table width="100%">
        <tr>
            <td width="33%">
                <span style="font-weight: bold; font-style: italic; font-size:7pt;">{DATE j-m-Y}</span>
            </td>
            <td width="33%" align="center" style="font-weight: bold; font-style: italic; font-size:7pt;">
                {PAGENO}/{nbpg}
            </td>
            <td width="33%" style="text-align: right;font-style: italic; font-size:7pt;">
                Dicetak dari Aplikasi PPDB Dinas Kab. Sampang
            </td>
        </tr>
    </table>
</htmlpagefooter>
<div class="container-fluid">
    @include('cetak.header')
    <hr class="s8">
    <h3 style="margin-bottom: 0px; text-align:center; color:red">HASIL SELEKSI JENJANG {{($jalur->bentuk_pendidikan_id == 5) ? 'SD' : 'SMP'}}</h3>
    <h4 style="text-align:center">PPDB SD/SMP Sampang {{config('ppdb.tahun')}}</h4>
    @if($sekolah)
    <h4 style="text-align:center">{{strtoupper($sekolah->nama)}}</h4>
    @endif
    <h4 style="text-align:center">JALUR {{strtoupper($jalur->nama)}}</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Nama Siswa</th>
                <th class="text-center">NIK</th>
                @role(['admin', 'dinas'])
                <th class="text-center">SEKOLAH TUJUAN</th>
                @endrole
                @if($jalur->tautan == 'zonasi')
                    @if($sekolah->bentuk_pendidikan_id == 5)
                        <th class="text-center">UMUR (60%)</th>
                        <th class="text-center">JARAK (40%)</th>
                    @else
                        <th class="text-center">UMUR (5%)</th>
                        <th class="text-center">JARAK (90%)</th>
                        <th class="text-center">NILAI RAPOR (5%)</th>
                    @endif
                @endif
                <th class="text-center">NILAI AKHIR</th>
            </tr>
        </thead>
        <tbody>
            @if($sekolah_pilihan->count())
                @foreach ($sekolah_pilihan as $sekolah)
                <tr>
                    <td class="text-center">{{$loop->iteration}}</td>
                    <td>{{strtoupper($sekolah->pendaftar->user->name)}}</td>
                    <td class="text-center">{{strtoupper($sekolah->pendaftar->user->username)}}</td>
                    @role(['admin', 'dinas'])
                    <td>{{strtoupper($sekolah->sekolah->nama)}}</td>
                    @endrole
                    @if($jalur->tautan == 'zonasi')
                        @if($sekolah->pendaftar->bentuk_pendidikan_id == 5)
                            <td class="text-center">{{$sekolah->pendaftar->user->usia}}</td>
                            <td class="text-center">{{$sekolah->jarak}} Meter</td>
                        @else
                            <td class="text-center">{{$sekolah->pendaftar->user->usia}}</td>
                            <td class="text-center">{{$sekolah->jarak}} Meter</td>
                            <td class="text-center">{{$sekolah->nilai_mapel}}</td>
                        @endif
                    @endif
                    <td class="text-center">{{$sekolah->nilai_akhir}}</td>
                </tr>
                @endforeach
            @else
            <tr>
                @if($jalur->tautan == 'zonasi')
                <td class="text-center" colspan="6">Tidak ada data untuk ditampilkan</td>
                @else
                @role(['admin', 'dinas'])
                <td class="text-center" colspan="5">Tidak ada data untuk ditampilkan</td>
                @else
                <td class="text-center" colspan="4">Tidak ada data untuk ditampilkan</td>
                @endrole
                @endif
            </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection