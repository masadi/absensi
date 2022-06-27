@extends('layouts/contentLayoutMaster')

@section('title', $pageConfigs['title'])
@section('vendor-style')
  {{-- vendor css files --}}
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/animate/animate.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/sweetalert2.min.css')) }}">
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
          {{--@hasanyrole('dpw|admin')--}}
          <h4 class="card-title">
            <button type="button" class="btn btn-primary waves-effect waves-float waves-light" data-bs-toggle="modal" data-bs-target="#createModal">Tambah Data</button>
          </h4>
          {{--@endhasanyrole--}}
        </div>
        <div class="card-body">
          @livewire('sumbangan')
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
@section('page-script')
  <script>
    $(function () {
      window.livewire.on('create', () => {
        $("#createModal").modal('hide');
      });
      window.livewire.on('update', () => {
        $("#updateModal").modal('hide');
      });
      window.livewire.on('delete', () => {
        $("#deleteModal").modal('hide');
      });
      window.livewire.on('donasi', () => {
        $("#donasiModal").modal('hide');
      });
    })
  </script>
@endsection
