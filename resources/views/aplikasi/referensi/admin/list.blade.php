@extends('layouts/contentLayoutMaster')

@section('title', $pageConfigs['title'])
@section('vendor-style')
  {{-- vendor css files --}}
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
<section id="ajax-datatable">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header border-bottom">
          <h4 class="card-title">{{$pageConfigs['title']}}</h4>
          <h4 class="card-title">
            <button type="button" class="btn btn-primary waves-effect waves-float waves-light" data-bs-toggle="modal" data-bs-target="#createModal">Tambah Data</button>
          </h4>
        </div>
        <div class="card-body">
          @livewire('ref-admin')
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
@section('vendor-script')
{{-- vendor files --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection
@section('page-script')
  <script>
    $(function () {
      /*var picker = new Pikaday({
        field: document.getElementById('waktu'),
        format: 'DD-MM-YYYY',
        onSelect: function() {
            Livewire.emit('setWaktu', this.getMoment().format('DD-MM-YYYY'))
        }
      });*/
      window.livewire.on('create', () => {
        $("#createModal").modal('hide');
      });
      window.livewire.on('update', () => {
        $("#updateModal").modal('hide');
      });
      window.livewire.on('delete', () => {
        $("#deleteModal").modal('hide');
      });
      window.livewire.on('hadir', () => {
        $("#hadirModal").modal('hide');
      });
      window.livewire.on('batal', () => {
        $("#batalModal").modal('hide');
      });
    })
  </script>
@endsection
