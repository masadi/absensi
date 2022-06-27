<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DataTables;

class AlumniController extends Controller
{
    public function index(){
        return $this->alumni_aktif();
    }
    public function alumni_aktif(){
        $pageConfigs = ['title' => 'Alumni Aktif', 'pageHeader' => false];
        $breadcrumbs = [['link' => "/", 'name' => "Dashboard"], ['name' => $pageConfigs['title']]];
        return view('/aplikasi/alumni/aktif', ['pageConfigs' => $pageConfigs]); 
    }
    public function alumni_non_aktif(){
        $pageConfigs = ['title' => 'Alumni Non Aktif', 'pageHeader' => false];
        $breadcrumbs = [['link' => "/", 'name' => "Dashboard"], ['name' => $pageConfigs['title']]];
        return view('/aplikasi/alumni/non-aktif', ['pageConfigs' => $pageConfigs]); 
    }
    public function api_alumni_aktif(){
        $model = User::query()->role('alumni');
        return DataTables::of($model)
        ->addColumn('dpw', function(User $user) {
            $dpw = ($user->dpw) ? $user->dpw->name : '-';
            return $dpw;
        })
        ->addColumn('aksi', function(User $user) {
            return 'Aksi';
        })
        ->toJson();
    }
    public function api_alumni_non_aktif(){
        $model = User::query()->doesntHave('roles');
        return DataTables::of($model)
        ->addColumn('dpw', function(User $user) {
            $dpw = ($user->dpw) ? $user->dpw->name : '-';
            return $dpw;
        })
        ->addColumn('aksi', function(User $user) {
            return 'Aksi';
        })
        ->toJson();
    }
}
