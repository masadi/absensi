<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Sekolah;
use App\User;
use App\Jalur;
use App\Jenis_prestasi;

class ReferensiController extends Controller
{
    public function index(Request $request, $query){
        $function = 'get_'.str_replace('-', '_', $query);
        return $this->{$function}($request);
    }
    public function get_all_sekolah($request){
        $all_data = Sekolah::select('sekolah_id', 'nama')->get();//->pluck('nama', 'sekolah_id');
        return response()->json(['status' => 'success', 'data' => $all_data]);
    }
    public function get_sekolah($request)
    {
        $user = User::find($request->user_id);
        $sortBy = request()->sortby;
        $all_data = Sekolah::where(function($query){
            if(request()->q){
                $query->where(function($query){
                    $query->where('nama', 'like', '%' . request()->q . '%');
                    if(request()->sekolah_id){
                        $query->where('sekolah_id', request()->sekolah_id);
                    }
                });
                $query->orWhere(function($query){
                    $query->where('npsn', 'like', '%' . request()->q . '%');
                    if(request()->sekolah_id){
                        $query->where('sekolah_id', request()->sekolah_id);
                    }
                });
            }
            if(request()->sekolah_id){
                $query->where('sekolah_id', request()->sekolah_id);
            }
            if(request()->bentuk_pendidikan_id){
                $query->where('bentuk_pendidikan_id', request()->bentuk_pendidikan_id);
            }
        })->with(['pagu', 'user'])->orderBy($sortBy, request()->sortbydesc)->paginate(request()->per_page);
        return response()->json(['status' => 'success', 'data' => $all_data]);
    }
    public function simpan_data(Request $request){
        if($request->route('query') == 'koordinat'){
            $sekolah = Sekolah::find($request->sekolah_id);
            $sekolah->bujur = $request->bujur;
            $sekolah->lintang = $request->lintang;
            $sekolah->save();
            return response()->json(['status' => 'success', 'data' => 'koordinat']);
        } 
        return response()->json(['status' => 'failed', 'data' => NULL]);
    }
    public function update_data(Request $request)
    {
        return response()->json(['title' => 'Gagal', 'status' => 'error', 'message' => 'Tidak ada data diperbaharui']);
    }
    public function delete_data(Request $request)
    {
        $id = $request->route('id');
        return response()->json(['title' => 'Gagal', 'status' => 'error', 'message' => 'Tidak ada data terhapus']);
    }
    public function get_prestasi(Request $request){
        $data = Jenis_prestasi::select('id as value', 'nama')->get();
        $data->push(['value' => '', 'nama' => '== Pilih Jenis Prestasi ==']);
        $sorted = $data->sortBy('value');
        return response()->json(['status' => 'success', 'data' => $sorted->values()->all()]);
    }
    public function get_akreditasi(Request $request){
        $response = Http::withOptions([
            'verify' => false
        ])->get('https://referensi.data.kemdikbud.go.id/carisatpen.php', [
            'q' => $request->npsn,
        ]);
        $output = [];
        if(!$response->failed()){
            $all_data = $response->body();
            $all_data = preg_replace('/<br>(.*?)<br>/', '', $all_data);
            $all_data = preg_replace('/\s+/', ' ', $all_data);
            $all_data = trim($all_data);
            $all_data = str_replace(' ','',$all_data);
            $all_data = substr($all_data, 0, -1);
            $all_data = explode('-',$all_data);
            foreach($all_data as $data){
                $response = Http::withOptions([
                    'verify' => false
                ])->asForm()->post('https://bansm.kemdikbud.go.id/akreditasi/search/0', [
                    'keywords' => $data,
                    "page" => "0",
                    "prov" => "",
                    "kabkot" => NULL,
                    "jenj" => "",
                    "sts" => "semua",
                    "tahun" => "",
                    "peringkat" => "",
                ]);
                if(!$response->failed()){
                    $set_data = $response->body();
                    $set_data = strip_tags($set_data, '<table><tr><td><th><thead>');//preg_replace('/<![^>]*!>/', '', $all_data);
                    $set_data = preg_replace('/\s+/', ' ', $set_data);
                    $set_data = str_replace("function sekdetail(id){ $('#pageContent2').load('https://bansm.kemdikbud.go.id/home/sekolah/'+id) }", "", $set_data);
                    $set_data = trim($set_data);
                    $set_data = strstr($set_data, '<');
                    $set_data = preg_replace('/<thead>(.*?)<\/thead>/', '', $set_data);
                    $dom = new \domDocument;
                    $dom->loadHTML($set_data);
                    $dom->preserveWhiteSpace = false;
                    $tables = $dom->getElementsByTagName('table');
                    $rows = $tables->item(0)->getElementsByTagName('tr');
                    foreach ($rows as $row) {
                        $record= [];
                        $cols = $row->getElementsByTagName('td');
                        $record['no'] 	= $cols->item(0)->nodeValue;
                        $record['npsn'] 	= $cols->item(1)->nodeValue;
                        $record['nama'] 	= $cols->item(2)->nodeValue;
                        $record['tahun'] 	= $cols->item(3)->nodeValue;
                        $record['nilai'] 	= $cols->item(4)->nodeValue;
                        $output[] = $record;
                    } 
                }
            }
        }
        return response()->json(['status' => 'success', 'data' => $output]);
    }
}
