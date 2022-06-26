<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Sekolah;
use App\User;
use App\HelperModel;
use App\Wilayah;
use App\Pagu;
use App\Jalur;
use Validator;
use File;

class SekolahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_data = Sekolah::orderBy(request()->sortby, request()->sortbydesc)
            ->when(request()->q, function($berita) {
                $all_data = $all_data->where('nama', 'LIKE', '%' . request()->q . '%')
                ->orWhere('npsn', 'LIKE', '%' . request()->q . '%')
                ->orWhere('kabupaten', 'LIKE', '%' . request()->q . '%')
                ->orWhere('provinsi', 'LIKE', '%' . request()->q . '%');
        })->with(['pagu'])->paginate(request()->per_page); //KEMUDIAN LOAD PAGINATIONNYA BERDASARKAN LOAD PER_PAGE YANG DIINGINKAN OLEH USER
        return response()->json(['status' => 'success', 'data' => $all_data]);
    }

    public function store(Request $request)
    {
        $user = User::find($request->user_id);
        if(!$user){
            return redirect('login');
        }
        $data = NULL;
        if($user->hasRole('sekolah')){
            $data = Sekolah::find($user->sekolah_id);
        } elseif($user->hasRole('penjamin_mutu')){
            $data = [
                'jml_sekolah_sasaran' => Sekolah::whereHas('sekolah_sasaran', function($query) use ($request){
                    $query->where('verifikator_id', $request->user_id);
                })->count(),
                'jml_sekolah_sasaran_instrumen' => Sekolah::whereHas('sekolah_sasaran', function($query) use ($request){
                    $query->where('verifikator_id', $request->user_id);
                    $query->has('pakta_integritas');
                })->count(),
                'jml_sekolah_sasaran_no_instrumen' => Sekolah::whereHas('sekolah_sasaran', function($query) use ($request){
                    $query->where('verifikator_id', $request->user_id);
                    $query->doesntHave('pakta_integritas');
                })->count(),
                'jml_sekolah_sasaran_verval' => Sekolah::whereHas('sekolah_sasaran', function($query) use ($request){
                    $query->where('verifikator_id', $request->user_id);
                    $query->has('rapor_mutu');
                })->count(),
            ];
        }
        return response()->json(['status' => 'success', 'data' => $data]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $all_data = Sekolah::select('sekolah_id as value', 'nama as text')->where('bentuk_pendidikan_id', $id)->get();
        return response()->json(['status' => 'success', 'data' => $all_data]);
    }
    public function detil($id)
    {
        $data = Sekolah::find($id);
        $jalur = Jalur::with(['pagu' => function($query) use ($data){
            $query->where('sekolah_id', $data->sekolah_id);
        }])->where('bentuk_pendidikan_id', $data->bentuk_pendidikan_id)->get();
        return response()->json(['status' => 'success', 'data' => $data, 'jalur' => $jalur]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $messages = [
            'nama.required'	=> 'Nama Sekolah tidak boleh kosong',
            'npsn.required'	=> 'NPSN Sekolah tidak boleh kosong',
            'nama_kepsek.required'	=> 'Nama Kepala Sekolah tidak boleh kosong',
            'nip_kepsek.required'	=> 'NIP Kepala Sekolah tidak boleh kosong',
            'jml_rombel.required'	=> 'Jumlah Rombel Sekolah tidak boleh kosong',
            'jml_rombel.numeric'	=> 'Jumlah Rombel Sekolah harus berupa angka',
            'pagu.*.required'	=> 'Jumlah Pagu tidak boleh kosong',
            'pagu.*.numeric'	=> 'Jumlah Pagu harus berupa angka',
        ];
        $validator = Validator::make(request()->all(), [
            'nama' => 'required',
            'npsn' => 'required',
            'nama_kepsek' => 'required',
            'nip_kepsek' => 'required',
            'jml_rombel' => 'required|numeric',
            'pagu.*' => 'required|numeric',
        ],
        $messages
        )->validate();
        $sekolah = Sekolah::with(['user'])->find($id);
        $sekolah->nama = $request->nama;
        $sekolah->npsn = $request->npsn;
        $sekolah->nama_kepsek = $request->nama_kepsek;
        $sekolah->nip_kepsek = $request->nip_kepsek;
        $sekolah->jml_rombel = $request->jml_rombel;
        //$sekolah->pagu = $request->pagu;
        $sekolah->save();
        foreach($request->pagu as $key => $value){
            Pagu::updateOrCreate(
                [
                    'sekolah_id' => $id,
                    'jalur_id' => $key,
                ],
                [
                    'jumlah' => $request->pagu[$key]
                ]
            );
        }
        return response()->json(['message' => 'Data Sekolah berhasil diperbaharui']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Sekolah::find($id);
        $data->delete();
        return response()->json(['message' => 'Data Sekolah berhasil dihapus']);
    }
    public function koordinat(Request $request){
        $sekolah = Sekolah::find($request->sekolah_id);
        $wilayah = Wilayah::with('parrentRecursive')->find($request->kode_wilayah);
		$geojson = NULL;
		$geojson = File::get(public_path('geojson').'/'.trim($wilayah->parrentRecursive->mst_kode_wilayah).'.geojson');
		$geojson = json_decode($geojson);
		return response()->json(['status' => 'success', 'data' => $sekolah, 'geojson' => $geojson]);
    }
}
