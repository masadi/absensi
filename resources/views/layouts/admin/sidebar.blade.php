<?php
$user = auth()->user();
?>
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
                @if(session('tukar_akses'))
                <li>
                    <a class="nav-link text-success" href="{{route('tukar_akses', ['user_id' => session('user_sekolah')])}}">
                        <i class="metismenu-icon pe-7s-power"></i> Kembali ke Login Sekolah
                    </a>
                </li>
                @endif
                @if($user->isAbleTo('users-create'))
                    <li>
                        <router-link tag="a" to="/sekolah">
                            <i class="metismenu-icon pe-7s-right-arrow"></i>
                            Sekolah
                        </router-link>
                    </li>
                    <li>
                        <router-link tag="a" to="/pendaftar">
                            <i class="metismenu-icon pe-7s-right-arrow"></i>
                            Pendaftar
                        </router-link>
                    </li>
                    <li>
                        <a href="#">
                            <i class="metismenu-icon pe-7s-right-arrow"></i>
                            Hasil Verifikasi
                            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                        </a>
                        <ul>
                            @if($user->bentuk_pendidikan_id)
                                @foreach ($all_jalur as $jalur)
                                <li>
                                    <router-link tag="a" to="/{{$jalur->tautan}}/seleksi">
                                        <i class="metismenu-icon"></i>
                                        {{$jalur->nama}}
                                    </router-link>
                                </li>
                            @endforeach
                            @else
                                @foreach ($semua_jalur as $jenjang => $semua)
                                <li>
                                    <a href="#">
                                        <i class="metismenu-icon pe-7s-right-arrow"></i>
                                        {{$jenjang}}
                                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                    </a>
                                    <ul>
                                        <!--li>
                                            <router-link tag="a" to="/report/{{$jenjang}}">
                                                <i class="metismenu-icon"></i>
                                                Web Report
                                            </router-link>
                                        </li-->
                                        @foreach ($semua as $s)
                                        <li>
                                            <router-link tag="a" to="/{{$s->tautan}}/seleksi/{{$s->bentuk_pendidikan_id}}">
                                                <i class="metismenu-icon pe-7s-right-arrow"></i>
                                                {{$s->nama}}
                                            </router-link>
                                        </li>
                                        @endforeach
                                    </ul>
                                </li>
                                @endforeach
                            @endif
                        </ul>
                    </li>
                @endif
                @if($user->hasRole('sekolah'))
                <li>
                    <router-link tag="a" to="/pendaftar">
                        <i class="metismenu-icon pe-7s-right-arrow"></i>
                        Pendaftar
                    </router-link>
                </li>
                <li>
                    <a href="#">
                        <i class="metismenu-icon pe-7s-right-arrow"></i>
                        Hasil Verifikasi
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul>
                    @foreach ($all_jalur as $jalur)
                        <li>
                            <router-link tag="a" to="/{{$jalur->tautan}}/seleksi">
                                <i class="metismenu-icon"></i>
                                {{$jalur->nama}}
                            </router-link>
                        </li>
                    @endforeach
                    </ul>
                </li>
                @endif
                @if($user->isAbleTo('daftar-create'))
                <li class="app-sidebar__heading">Pilih Jalur</li>
                @foreach ($all_jalur as $jalur)
                <li>
                    <a href="#">
                        <i class="metismenu-icon pe-7s-right-arrow"></i>
                        Jalur {{$jalur->nama}}
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul>
                        <li>
                            <router-link tag="a" to="/{{$jalur->tautan}}/informasi">
                                <i class="metismenu-icon"></i>
                                Informasi
                            </router-link>
                        </li>
                        <li>
                            <router-link tag="a" to="/{{$jalur->tautan}}/daftar">
                                <i class="metismenu-icon"></i>
                                Daftar
                            </router-link>
                        </li>
                        <li>
                            <router-link tag="a" to="/{{$jalur->tautan}}/seleksi">
                                <i class="metismenu-icon"></i>
                                Hasil Seleksi
                            </router-link>
                        </li>
                    </ul>
                </li>
                @endforeach
                @endif
                @if($user->isAbleTo('users-create'))
                <li class="app-sidebar__heading"></li>
                <li>
                    <router-link tag="a" to="/pengguna">
                        <i class="metismenu-icon pe-7s-right-arrow"></i>
                        Data Siswa
                    </router-link>
                </li>
                <li>
                    <router-link tag="a" to="/operator">
                        <i class="metismenu-icon pe-7s-right-arrow"></i>
                        Operator Sekolah
                    </router-link>
                </li>
                @endif
                <li class="app-sidebar__heading">Profile</li>
                @if($user->hasRole('sekolah'))
                <li>
                    <router-link tag="a" to="/sekolah">
                        <i class="metismenu-icon pe-7s-culture"></i>
                        Profil Sekolah
                    </router-link>
                </li>
                @endif
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