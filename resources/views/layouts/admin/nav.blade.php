<!--nav class="main-header navbar navbar-expand navbar-white navbar-light stycky-top">
    
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item h4 mb-0">
            {{auth()->user()->name}} {!!(config('app.tahun_pendataan') ? ' &raquo; Tahun Pendataan '.config('app.tahun_pendataan') : NULL)!!}
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">

        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
                <i  class="fas fa-th-large"></i>
            </a>
        </li>

    </ul>

</nav-->
<div class="app-header header-shadow">
    <div class="app-header__logo">
        <strong>{{config('app.name')}}</strong>
        <div class="header__pane ml-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic"
                    data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>
    <div class="app-header__content">
        <div class="app-header-left">
            <h3>{{config('setting.nama_sekolah')}}</h3>
        </div>
        <div class="app-header-right">
            <div class="header-btn-lg pr-0">
                <div class="widget-content p-0">
                    <div class="widget-content-wrapper">
                        <div class="widget-content-left">
                            <div class="btn-group">
                                <router-link tag="a" to="/profil">
                                    <img width="42" class="rounded-circle" src="{{ (auth()->user()->photo) ? '/images/245/'.auth()->user()->photo : '/vendor/img/avatar3.png' }}" alt="">
                                </router-link>
                            </div>
                        </div>
                        <div class="widget-content-left  ml-3 header-user-info">
                            <div class="widget-heading">
                                <router-link tag="a" to="/profil">{{auth()->user()->name}}</router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>