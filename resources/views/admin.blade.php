@extends('core.app')

@section('content')
    <!-- Navbar -->
    @include('layouts.admin.nav')
    <!-- /.navbar -->
    <div class="app-main">
    <!-- Main Sidebar Container -->
    @include('layouts.admin.sidebar')
    <!-- /.Main Sidebar Container -->
    <div class="app-main__outer">
    <!-- Content Wrapper. Contains page content -->
    @include('layouts.admin.content')
    <!-- /.content-wrapper -->

    <!-- Admin Footer -->
    @include('layouts.admin.footer')
    </div>
    </div>
@endsection
