@extends('layouts/fullLayoutMaster')

@section('title', 'Report Harian')


@section('content')
@livewire('layar-utama')
@endsection
@section('vendor-script')
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
@endsection
@section('page-script')
<script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('bc531acdb4578535bf7a', {
      cluster: 'ap1'
    });

    var channel = pusher.subscribe('notify-channel');
    channel.bind('App\\Events\\Notify', function(data) {
        Livewire.emit('newScan', data)
        console.log(data);
      //alert(JSON.stringify(data));
    });
  </script>
@endsection