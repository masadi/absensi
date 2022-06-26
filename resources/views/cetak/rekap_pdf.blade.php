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
    <h3 style="margin-bottom: 0px; text-align:center; color:red">REKAPITULASI HASIL PPDB JENJANG {{($user->bentuk_pendidikan_id == 5) ? 'SD' : 'SMP'}}</h3>
    <h4 style="text-align:center">PPDB SD/SMP Sampang {{config('ppdb.tahun')}}</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center">NO</th>
                <th class="text-center">NAMA SEKOLAH</th>
                @foreach ($all_jalur as $jalur)
                <th class="text-center">{{strtoupper($jalur->nama)}}</th>
                @endforeach
                <th class="text-center">TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @if($all_sekolah->count())
                @foreach ($all_sekolah as $sekolah)
                <tr>
                    <td class="text-center">{{$loop->iteration}}</td>
                    <td>{{strtoupper($sekolah->nama)}}</td>
                    @if($user->bentuk_pendidikan_id == 5)
                    <td class="text-center">{{$sekolah->zonasi}}</td>
                    <td class="text-center">{{$sekolah->afirmasi}}</td>
                    <td class="text-center">{{$sekolah->perpindahan}}</td>
                    <td class="text-center">{{$sekolah->zonasi + $sekolah->afirmasi + $sekolah->perpindahan}}</td>
                    @else
                    <td class="text-center">{{$sekolah->zonasi}}</td>
                    <td class="text-center">{{$sekolah->afirmasi}}</td>
                    <td class="text-center">{{$sekolah->perpindahan}}</td>
                    <td class="text-center">{{$sekolah->prestasi}}</td>
                    <td class="text-center">{{$sekolah->zonasi + $sekolah->afirmasi + $sekolah->perpindahan + $sekolah->prestasi}}</td>
                    @endif
                </tr>
                @endforeach
            @else
            <tr>
                @if($user->bentuk_pendidikan_id == 5)
                <td class="text-center" colspan="6">Tidak ada data untuk ditampilkan</td>
                @else
                <td class="text-center" colspan="7">Tidak ada data untuk ditampilkan</td>
                @endif
            </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection