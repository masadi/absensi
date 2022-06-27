@extends('layouts/contentLayoutMaster')

@section('title', $pageConfigs['title'])
@section('content')
<section id="ajax-datatable">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header border-bottom">
          <h4 class="card-title">{{$pageConfigs['title']}}</h4>
        </div>
        <div class="card-body">
          @livewire('riwayat-donasi')
        </div>
      </div>
    </div>
  </div>
</section>
@endsection