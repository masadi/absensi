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
    <h3 style="margin-bottom: 0px; text-align:center; color:red">BUKTI PENERIMAAN</h3>
    <h4 style="text-align:center">PPDB SD/SMP Sampang {{config('ppdb.tahun')}}</h4>
    <table class="table table-bordered">
        <tr>
            <td width="40%" style="padding:15px" class="strong">NIK</td>
            <td width="60%" style="padding:15px" class="strong">{{$sekolah_pilihan->pendaftar->user->username}}</td>
        </tr>
        <tr>
            <td style="padding:15px" class="strong">NAMA SISWA</td>
            <td style="padding:15px" class="strong">{{strtoupper($sekolah_pilihan->pendaftar->user->name)}}</td>
        </tr>
        <tr>
            <td style="padding:15px" class="strong">JALUR PENDAFTARAN</td>
            <td style="padding:15px" class="strong">{{strtoupper($sekolah_pilihan->jalur->nama)}}</td>
        </tr>
        <tr>
            <td style="padding:15px" class="strong">DITERIMA DI</td>
            <td style="padding:15px" class="strong">{{strtoupper($sekolah_pilihan->sekolah->nama)}}</td>
        </tr>
    </table>
    <p>NB. <br>
        Cetak bukti penerimaan ini sebagai syarat melakukan pendaftaran ulang.</p>        
</div>
@endsection