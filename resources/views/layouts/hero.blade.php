<section id="hero" class="d-flex align-items-center">

    <div class="container">
        <div class="row">
            <div class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1"
                data-aos="fade-up" data-aos-delay="200">
                <h1>Aplikasi PPDB Online</h1>
                <h2>Dinas Pendidikan {{config('ppdb.wilayah', 'Kabupaten Sampang')}} <br>Tahun Ajaran {{ config('ppdb.tahun_pelajaran', '2022/2023') }}</h2>
                <div class="d-lg-flex">
                    <a href="{{url('/')}}#register" class="btn-get-started scrollto">Daftar Sekarang</a>
                    <a href="https://youtu.be/EjjMv7tZ6wI" class="venobox btn-watch-video" data-vbtype="video" data-autoplay="true"> Cara Mendaftar
                        <i class="icofont-play-alt-2"></i></a>
                </div>
            </div>
            <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="200">
                <img src="{{asset('assets/img/pks2022.png')}}" class="img-fluid animated" alt="">
            </div>
        </div>
    </div>

</section><!-- End Hero -->