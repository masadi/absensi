@extends('layouts/contentLayoutMaster')

@section('title', $pageConfigs['title'])
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
          @livewire('alumni-aktif')
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
    })
  </script>
@endsection
