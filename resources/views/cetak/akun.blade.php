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
    <h3 style="margin-bottom: 0px; text-align:center; color:red">AKUN PPDB ONLINE</h3>
    <h4 style="text-align:center">PPDB SD/SMP Sampang {{config('ppdb.tahun')}}</h4>
    <table class="table table-bordered">
        <tr>
            <td width="20%">NIK</td>
            <td width="80%">{{$user->username}}</td>
        </tr>
        <tr>
            <td>Nama Siswa</td>
            <td>{{$user->name}}</td>
        </tr>
        <tr>
            <td>Password</td>
            <td>{{$user->sandi}}</td>
        </tr>
        <tr>
            <td>Jenjang</td>
            <td>{{($user->bentuk_pendidikan_id == 5) ? 'SD' : 'SMP'}}</td>
        </tr>
    </table>
    <p>NB. <br>
        Simpan akun anda dengan baik, segera lengkapi data agar anda bisa melakukan pendaftaran ke sekolah tujuan anda.</p>        
</div>
@endsection