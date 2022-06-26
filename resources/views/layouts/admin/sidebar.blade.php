<div class="app-sidebar sidebar-shadow">
    <div class="app-header__logo">
        <div class="logo-src"></div>
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
            <button type="button"
                class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>
    <div class="scrollbar-sidebar">
        <div class="app-sidebar__inner">
            <ul class="vertical-nav-menu">
                <li class="app-sidebar__heading">Menu Aplikasi</li>
                <li>
                    <router-link tag="a" to="/beranda">
                        <i class="metismenu-icon pe-7s-right-arrow"></i>
                        Beranda
                     </router-link>
                </li>
                @if($user->hasRole('admin'))
                    <li>
                        <router-link tag="a" to="/sekolah">
                            <i class="metismenu-icon pe-7s-right-arrow"></i>
                            Sekolah
                        </router-link>
                    </li>
                    <li>
                        <router-link tag="a" to="/pendaftar">
                            <i class="metismenu-icon pe-7s-right-arrow"></i>
                            Pengaturan
                        </router-link>
                    </li>
                @else
                <li>
                    <router-link tag="a" to="/pendaftar">
                        <i class="metismenu-icon pe-7s-right-arrow"></i>
                        Absensi
                    </router-link>
                </li>
                @endif
                <li class="app-sidebar__heading">Profile</li>
                <li>
                    <router-link tag="a" to="/profil">
                        <i class="metismenu-icon pe-7s-add-user"></i>
                        Profil Pengguna
                    </router-link>
                </li>
                <li>
                    <router-link tag="a" to="/ganti-password">
                        <i class="metismenu-icon pe-7s-lock"></i>
                        Ganti Password
                    </router-link>
                </li>
                <li>
                    <a class="nav-link text-danger" href="javascript:{}"
                        onclick="document.getElementById('logout-form-sidebar').submit();">
                        <i class="metismenu-icon pe-7s-power"></i> Keluar Aplikasi
                    </a>
                    <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>