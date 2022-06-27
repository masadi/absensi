<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Dpw;
class ReferensiController extends Controller
{
    public function index(){
        $pageConfigs = ['title' => 'Referensi DPW', 'pageHeader' => false];
        $breadcrumbs = [['link' => "/", 'name' => "Dashboard"], ['name' => $pageConfigs['title']]];
        $user = auth()->user();
        return view('/aplikasi/referensi/dpw/list', ['pageConfigs' => $pageConfigs, 'user' => $user]);
    }
    public function admin(){
        $pageConfigs = ['title' => 'Referensi Admin DPW', 'pageHeader' => false];
        $breadcrumbs = [['link' => "/", 'name' => "Dashboard"], ['name' => $pageConfigs['title']]];
        $user = auth()->user();
        return view('/aplikasi/referensi/admin/list', ['pageConfigs' => $pageConfigs, 'user' => $user]);
    }
    public function cari_alumni(Request $request){
        $results = User::role('alumni')->select('id', 'name as text')->where('name', 'LIKE', '%'.$request->q.'%')->doesntHave('ketua')->doesntHave('sekretaris')->doesntHave('bendahara')->paginate(10);
        return response()->json(['results' => $results, 'pagination' => true]);
    }
    public function cari_dpw(Request $request){
        $regencies = Dpw::select('id', 'nama as text')->where('nama', 'LIKE', '%'.$request->q.'%')->paginate(10);
        return response()->json(['results' => $regencies, 'pagination' => true]);
    }
}
