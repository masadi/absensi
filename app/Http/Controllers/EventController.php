<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kegiatan;
use DataTables;

class EventController extends Controller
{
    public function index(){
        $pageConfigs = ['title' => 'Data Kegiatan', 'pageHeader' => false];
        $breadcrumbs = [['link' => "/", 'name' => "Dashboard"], ['name' => $pageConfigs['title']]];
        $user = auth()->user();
        return view('/aplikasi/event/list', ['pageConfigs' => $pageConfigs, 'user' => $user]); 
    }
    public function api_list_event(){
        $model = Kegiatan::query();
        return DataTables::of($model)
        ->addColumn('aksi', function(Donasi $donasi) {
            return 'Aksi';
        })
        ->toJson();
    }
}
