@extends('layouts/fullLayoutMaster')

@section('title', 'Absensi Siswa')


@section('content')
@livewire('absensi-siswa')
@endsection
@section('vendor-script')
<script type="text/javascript" src="{{asset('js/core/instascan.min.js')}}"></script>
@endsection