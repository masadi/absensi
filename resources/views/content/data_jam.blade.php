@extends('layouts/contentLayoutMaster')

@section('title', 'Pengaturan Jam')

@section('content')
<livewire:mapping.index />
@endsection
@section('page-script')
<script>
    var addModal = document.getElementById('addModal'),
        editModal = document.getElementById('editModal'),
        deleteModal = document.getElementById('deleteModal'),
        detilModal = document.getElementById('detilModal'),
        copyModal = document.getElementById('copyModal');
    editModal.addEventListener('hide.bs.modal', function (event) {
        console.log('editModal');
        Livewire.emit('cancel')
    })
    deleteModal.addEventListener('hide.bs.modal', function (event) {
        console.log('deleteModal');
        Livewire.emit('cancel')
    })
    addModal.addEventListener('hidden.bs.modal', function (event) {
        console.log('addModal');
        Livewire.emit('cancel')
    })
    detilModal.addEventListener('hidden.bs.modal', function (event) {
        console.log('detilModal');
        Livewire.emit('cancel')
    })
    copyModal.addEventListener('hidden.bs.modal', function (event) {
        console.log('copyModal');
        Livewire.emit('cancel')
    })
    Livewire.on('close-modal', event => {
        $('#editModal').modal('hide');
        $('#addModal').modal('hide');
        $('#deleteModal').modal('hide');
        $('#copyModal').modal('hide');
        /*$('body').removeClass('modal-open');
        $('.modal-backdrop').remove();*/
    })
</script>
@endsection
