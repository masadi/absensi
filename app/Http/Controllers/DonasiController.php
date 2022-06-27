<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donasi;
use App\Models\Dana;
use App\Models\User;
use DataTables;
class DonasiController extends Controller
{
    public function index(){
        return $this->list_donasi();
    }
    public function list_donasi(){
        $pageConfigs = ['title' => 'Data Donasi', 'pageHeader' => false];
        $breadcrumbs = [['link' => "/", 'name' => "Dashboard"], ['name' => $pageConfigs['title']]];
        $user = auth()->user();
        return view('/aplikasi/donasi/list', ['pageConfigs' => $pageConfigs, 'user' => $user]); 
    }
    public function riwayat_donasi(){
        $pageConfigs = ['title' => 'Riwayat Donasi', 'pageHeader' => false];
        $breadcrumbs = [['link' => "/", 'name' => "Dashboard"], ['name' => $pageConfigs['title']]];
        $user = auth()->user();
        return view('/aplikasi/donasi/riwayat', ['pageConfigs' => $pageConfigs, 'user' => $user]); 
    }
    public function edit_donasi($id){
        return view('/aplikasi/donasi/edit', ['id' => $id]); 
    }
    public function api_list_donasi(Request $request){
        $user = User::find($request->user_id);
        $model = Donasi::query()->where('aktif', 1);
        return DataTables::of($model)
        ->addColumn('dana', function(Donasi $dana) {
            return number_format($dana->dana->sum('nominal'),0,'','.');
        })
        ->addColumn('aksi', function(Donasi $donasi) use ($user){
            $aksi = '<div class="btn-group">';
            $aksi .= '<button type="button" class="btn btn-primary btn-sm dropdown-toggle waves-effect waves-float waves-light" data-bs-toggle="dropdown" aria-expanded="false">Aksi</button>';
            $aksi .= '<div class="dropdown-menu">';
            if($user->hasRole('admin')){
                $switch = ($donasi->aktif) ? 'Non Aktifkan' : 'Aktifkan';
                $aksi .= '<a class="dropdown-item edit" data-bs-toggle="modal" data-bs-target="#updateModal" wire:click="edit('.$donasi->id.')">Edit</a>';
                $aksi .= '<a class="dropdown-item" href="#">'.$switch.'</a>';
                $aksi .= '<a class="dropdown-item confirm" href="javascript:void(0)">Hapus</a>';
            } else {
                $aksi .= '<a class="dropdown-item" href="#">Option 3</a>';
            }
            $aksi .= '</div>';
            $aksi .= '</div>';
            return $aksi;
        })
        ->rawColumns(['aksi'])
        ->toJson();
    }
    public function api_riwayat_donasi(Request $request){
        $model = Dana::query()->where('user_id', $request->user_id);
        return DataTables::of($model)
        ->addColumn('nama', function(Dana $dana) {
            return $dana->donasi->dana;
        })
        ->addColumn('jumlah', function(Dana $dana) {
            return number_format($data->nominal,0,'','.');
        })
        ->addColumn('status', function(Dana $dana) {
            return ($dana->approved) ? 'Diterima' : 'Menunggu Persetujuan';
        })
        ->toJson();
    }
}
