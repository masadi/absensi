<header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">

        <h1 class="logo mr-auto"><a href="{{url('/')}}">PPDB 2022</a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!--<a href="{{url('/')}}" class="logo mr-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

        <nav class="nav-menu d-none d-lg-block">
            <ul>
                <li class="active"><a href="{{url('/')}}">Home</a></li>
                <li><a href="{{url('/')}}#jadwal">Jadwal</a></li>
                <li><a href="{{url('/')}}#peraturan">Peraturan</a></li>
                <li><a href="{{url('/pengumuman')}}">Pengumuman</a></li>
            </ul>
        </nav><!-- .nav-menu -->
        @auth
        <a href="{{url('/app/dashboard')}}" class="get-started-btn scrollto">Dashboard</a>
        @else
        <a href="{{url('/login')}}" class="get-started-btn scrollto">Login</a>
        @endauth

    </div>
</header><!-- End Header -->