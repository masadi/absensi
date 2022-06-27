@extends('layouts/contentLayoutMaster')

@section('title', $pageConfigs['title'])
@section('vendor-style')
  {{-- vendor css files --}}
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
@endsection
@section('page-style')
<link rel="stylesheet" href="{{asset(mix('css/base/plugins/extensions/ext-component-sweet-alerts.css'))}}">
@endsection
@section('content')
<section id="ajax-datatable">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header border-bottom">
          <h4 class="card-title">{{$pageConfigs['title']}}</h4>
          @hasanyrole('dpw|admin')
          <h4 class="card-title">
            <button type="button" class="btn btn-primary waves-effect waves-float waves-light" data-bs-toggle="modal" data-bs-target="#createModal">Tambah Data</button>
          </h4>
          @endhasanyrole
        </div>
        <div class="card-body">
          @livewire('kegiatans', ['user' => $user])
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
@section('vendor-script')
{{-- vendor files --}}
  <script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
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
