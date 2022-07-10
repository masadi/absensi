@extends('layouts/contentLayoutMaster')

@section('title', 'Pengaturan Jam')

@section('content')
<livewire:data-jam />
@endsection
@section('page-script')
<script>
    Livewire.on('close-modal', event => {
        $('#addModal').modal('hide');
        $('#editModal').modal('hide');
        $('#deleteModal').modal('hide');
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
    })
</script>
@endsection
