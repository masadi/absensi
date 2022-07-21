@extends('layouts/contentLayoutMaster')

@section('title', 'Proses Absensi')

@section('content')
@livewire('absensi')
@endsection

@section('page-style')
<style>
    .swal2-container {width:500px !important;}
</style>
@endsection
