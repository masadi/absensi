<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaterkitController extends Controller
{
    // home
    public function home()
    {
        $breadcrumbs = [
            ['link' => "home", 'name' => "Beranda"], ['name' => "Index"]
        ];
        return view('/content/home', ['breadcrumbs' => $breadcrumbs]);
    }
    public function absensi(Request $request){
        $breadcrumbs = [['link' => "/", 'name' => "Beranda"], ['name' => "Proses Absensi"]];
        return view('content.absensi', ['breadcrumbs' => $breadcrumbs]);
    }
    public function rekapitulasi(Request $request){
        $breadcrumbs = [['link' => "/", 'name' => "Beranda"], ['name' => "Rekapitulasi"]];
        return view('content.rekapitulasi', ['breadcrumbs' => $breadcrumbs]);
    }
    public function ptk(){
        $breadcrumbs = [['link' => "/", 'name' => "Beranda"], ['name' => "Data PTK"]];
        return view('content.ptk', ['breadcrumbs' => $breadcrumbs]);
    }
    public function pengaturan(){
        $breadcrumbs = [['link' => "/", 'name' => "Beranda"], ['name' => "Pengaturan Aplikasi"]];
        return view('content.pengaturan', ['breadcrumbs' => $breadcrumbs]);
    }
    public function data_sekolah(){
        $breadcrumbs = [['link' => "/", 'name' => "Beranda"], ['name' => "Data Sekolah"]];
        return view('content.data_sekolah', ['breadcrumbs' => $breadcrumbs]);
    }
    public function data_kategori(){
        $breadcrumbs = [['link' => "/", 'name' => "Beranda"], ['name' => "Pengaturan Kategori"]];
        return view('content.data_kategori', ['breadcrumbs' => $breadcrumbs, 'tombol_add' => 1]);
    }
    public function data_jam(){
        $breadcrumbs = [['link' => "/", 'name' => "Beranda"], ['name' => "Pengaturan Jam"]];
        return view('content.data_jam', ['breadcrumbs' => $breadcrumbs, 'tombol_add' => 1]);
    }
    // Layout collapsed menu
    public function collapsed_menu()
    {
        $pageConfigs = ['sidebarCollapsed' => true];
        $breadcrumbs = [
            ['link' => "home", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "Layouts"], ['name' => "Collapsed menu"]
        ];
        return view('/content/layout-collapsed-menu', ['breadcrumbs' => $breadcrumbs, 'pageConfigs' => $pageConfigs]);
    }

    // layout boxed
    public function layout_full()
    {
        $pageConfigs = ['layoutWidth' => 'full'];

        $breadcrumbs = [
            ['link' => "home", 'name' => "Home"], ['name' => "Layouts"], ['name' => "Layout Full"]
        ];
        return view('/content/layout-full', ['pageConfigs' => $pageConfigs, 'breadcrumbs' => $breadcrumbs]);
    }

    // without menu
    public function without_menu()
    {
        $pageConfigs = ['showMenu' => false];
        $breadcrumbs = [
            ['link' => "home", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "Layouts"], ['name' => "Layout without menu"]
        ];
        return view('/content/layout-without-menu', ['breadcrumbs' => $breadcrumbs, 'pageConfigs' => $pageConfigs]);
    }

    // Empty Layout
    public function layout_empty()
    {
        $breadcrumbs = [['link' => "home", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "Layouts"], ['name' => "Layout Empty"]];
        return view('/content/layout-empty', ['breadcrumbs' => $breadcrumbs]);
    }
    // Blank Layout
    public function layout_blank()
    {
        $pageConfigs = ['blankPage' => true];
        return view('/content/layout-blank', ['pageConfigs' => $pageConfigs]);
    }
}
