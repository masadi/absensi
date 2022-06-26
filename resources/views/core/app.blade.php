<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'AdminLTE') }}</title>
    <link href="{{asset('assets/img/logo/favicon-32x32.png')}}" rel="icon">
    <link href="{{asset('assets/img/logo/apple-icon-60x60.png')}}" rel="apple-touch-icon">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset(mix('css/app.css')) }}" rel="stylesheet">
    <!--link href="{{ asset('css/loader.css') }}" rel="stylesheet"-->
    <style>
        nav ul li ul:not(.dropdown-menu) {padding-left: 30px !important;}
        #nprogress .bar{
            height: 10px;
        }
    </style>
    <script>
        window.user = {!! json_encode([
            'data' => $user,
            'user_id' => $user->user_id,
            'sekolah_id' => $user->sekolah_id,
            'sekolah' => $user->sekolah,
            'name' => $user->name,
            'email' => $user->email,
            'username' => $user->username,
            'kecamatan' => $user->kecamatan,
            'desa' => $user->desa,
            'roles' => $user->roles,
            'pendaftar' => $user->pendaftar,
        ]) !!};
    </script>
</head>
<body>
    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header" id="pmp_smk">
    <!-- wrapper -->
        @yield('content')
    </div>
    <!-- ./wrapper -->

    <!-- Scripts -->
    <script src="{{ asset(mix('js/app.js')) }}" defer></script>
</body>

</html>
