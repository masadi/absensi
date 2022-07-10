@extends('layouts/contentLayoutMaster')

@section('title', 'Pengaturan Kategori')

@section('content')
<livewire:data-kategori />
@endsection
@section('page-script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
<script>
    Livewire.on('close-modal', event => {
        $('#addModal').modal('hide');
        $('#editModal').modal('hide');
        $('#deleteModal').modal('hide');
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
    })
    var startDate,
        endDate,
    updateStartDate = function() {
        startPicker.setStartRange(startDate);
        endPicker.setStartRange(startDate);
        endPicker.setMinDate(startDate);
    },
    updateEndDate = function() {
        startPicker.setEndRange(endDate);
        startPicker.setMaxDate(endDate);
        endPicker.setEndRange(endDate);
    },
    startPicker = new Pikaday({
        field: document.getElementById('tanggal_mulai'),
        format: 'DD-MM-YYYY',
        minDate: new Date(),
        maxDate: new Date(2020, 12, 31),
        onSelect: function() {
            startDate = this.getDate();
            updateStartDate();
            Livewire.emit('getStart', startDate)
        }
    }),
    endPicker = new Pikaday({
        field: document.getElementById('tanggal_akhir'),
        format: 'DD-MM-YYYY',
        minDate: new Date(),
        maxDate: new Date(2020, 12, 31),
        onSelect: function() {
            endDate = this.getDate();
            updateEndDate();
            Livewire.emit('getEnd', endDate)
        }
    }),
    _startDate = startPicker.getDate(),
    _endDate = endPicker.getDate();
    if (_startDate) {
        startDate = _startDate;
        updateStartDate();
    }
    if (_endDate) {
        endDate = _endDate;
        updateEndDate();
    }
</script>
@endsection
@section('page-style')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
@endsection
