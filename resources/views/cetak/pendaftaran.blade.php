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
    <h3 style="margin-bottom: 0px; text-align:center; color:red">BUKTI PENDAFTARAN</h3>
    <h4 style="text-align:center">PPDB SD/SMP Kab. Sampang Tahun {{config('ppdb.tahun')}}</h4>
    <br>
    <br>
    <h4 class="text-center"><span class="strong">DATA DIRI SISWA</span></h4>
    <table class="table table-bordered">
        <tr>
            <td class="text-center" rowspan="7">
                @if($sekolah_pilihan->pendaftar->user->photo)
                <img style="width: 143px; height:181px" src="{{asset('images/'.$sekolah_pilihan->pendaftar->user->photo)}}" alt="" class="img-responsive">
                @elseif($sekolah_pilihan->pendaftar->user->jenis_kelamin == 'L')
                <img style="width: 143px; height:181px" src="{{asset('vendor/img/no_avatar.jpg')}}" alt="" class="img-responsive">
                @else
                <img style="width: 143px; height:181px" src="{{asset('vendor/img/no_avatar_f.jpg')}}" alt="" class="img-responsive">
                @endif
            </td>
        </tr>
        <tr>
            <td style="padding-left: 30px;">
                <u>Nomor Induk Kependudukan</u> <br>
                <span class="strong">{{$sekolah_pilihan->pendaftar->user->username}}</span>
            </td>
        </tr>
        <tr>
            <td style="padding-left: 30px;">
                <u>Nama Siswa <br>
                <span class="strong">{{strtoupper($sekolah_pilihan->pendaftar->user->name)}}</span>
            </td>
        </tr>
        <tr>
            <td style="padding-left: 30px;">
                <u>Sekolah Tujuan</u> <br>
                <span class="strong">{{$sekolah_pilihan->sekolah->nama}}</span>
            </td>
        </tr>
        <tr>
            <td style="padding-left: 30px;">
                <u>Jenis Kelamin</u> <br>
                <span class="strong">{{($sekolah_pilihan->pendaftar->user->jenis_kelamin == 'L') ? 'Laki-laki' : 'Perempuan'}}</span>
            </td>
        </tr>
        <tr>
            <td style="padding-left: 30px;">
                <u>Jalur</u> <br>
                <span class="strong">{{$sekolah_pilihan->jalur->nama}}</span>
            </td>
        </tr>
        <tr>
            <td style="padding-left: 30px;">
                <u>Waktu Pendaftaran</u> <br>
                <span class="strong">{{$sekolah_pilihan->created_at}}</span>
            </td>
        </tr>
    </table>
    <br>
    <table class="table table-bordered">
        <tr>
            <td class="text-center" colspan="2"><span class="strong">DOKUMEN YANG DIUPLOAD</span></td>
        </tr>
        @if($sekolah_pilihan->dokumen)
            @foreach ($sekolah_pilihan->dokumen as $dokumen)
            <tr>
                <td width="60%">{{$loop->iteration}}. {{$dokumen->komponen->bukti}}</td>
                <td width="40%">&nbsp;</td>
            </tr>
            @endforeach
        @else
        <tr>
            <td class="text-center" colspan="2">Tidak ada dokumen</td>
        </tr>
        @endif
    </table>
    <br>
    <table border="0" width="100%">
        <tr>
            <td width="50%">&nbsp;</td>
            <td width="50%" class="text-center">
                Petugas Verifikator
                <br><br><br><br><br><br>
                <strong>{{strtoupper(($sekolah_pilihan->verifikator) ? $sekolah_pilihan->verifikator->name : '-')}}</strong>
            </td>
        </tr>
    </table>
    <br>
    <ol>
        <li>Pendaftar yang telah melakukan KUNCI PENDAFTARAN tidak dapat merubah data dan pilihan pendaftaran</li>
        <li>Informasi Penerimaan akan diumumkan tanggal {{config('ppdb.tanggal_pengumuman')}}</li>
        <li>Untuk update informasi silahkan kunjungi web https://ppdb.sampangkab.go.id/</li>
    </ol>
</div>
@endsection