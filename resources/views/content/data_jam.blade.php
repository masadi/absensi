@extends('layouts/contentLayoutMaster')

@section('title', 'Pengaturan Jam')

@section('content')
<livewire:data-jam />
@endsection
@section('page-script')
<script>
Livewire.on('close-modal', event => {
    $('.modal-backdrop').removeClass('show');
})
</script>
@endsection
