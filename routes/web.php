<?php

use Illuminate\Support\Facades\Route;
use App\Jalur;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/pengumuman', function () {
    return view('pengumuman');
});
Route::get('/hasil_ppdb/{sekolah_id}/{jalur_id}', 'CetakController@hasil_ppdb')->name('cetak.hasil_ppdb');
Auth::routes();
Route::get('/tukar-akses/{user_id}/{user_sekolah?}', 'DashboardController@tukar_akses')->name('tukar_akses');
Route::group(['prefix' => 'cetak'], function(){
    Route::get('/akun/{user_id?}', 'CetakController@akun')->name('cetak.akun');
    Route::get('/pendaftaran/{sekolah_pilihan_id}', 'CetakController@pendaftaran')->name('cetak.pendaftaran');
    Route::get('/penerimaan/{sekolah_pilihan_id}', 'CetakController@penerimaan')->name('cetak.penerimaan');
    Route::get('/hasil/{jalur_id}/{sekolah_id?}', 'CetakController@hasil')->name('cetak.hasil');
    Route::get('/hasil/{jalur_id}/{filter}/{output}/{sekolah_id?}', 'CetakController@hasil_opsi')->name('cetak.hasil_opsi');
    Route::get('/excel', 'CetakController@cetak_excel')->name('cetak.excel');
    Route::get('/pdf', 'CetakController@cetak_pdf')->name('cetak.pdf');
    Route::get('/biodata/{jalur_id}/{sekolah_id}', 'CetakController@biodata')->name('cetak.biodata');
});
Route::get('/table', 'DapodikController@nama_table')->name('dashboard.nama_table');
Route::get('/dashboard', 'DashboardController@index')->name('dashboard.index');
Route::get('/kortim', function () {
    return view('kortim');
});
Route::get('/page/{query}/{id_level_wilayah?}/{kode_wilayah?}', 'PageController@index')->name('page');
Route::get('/berita/{slug}', 'PageController@detil_berita')->name('detil_berita');
Route::get('/app/{vue_capture?}', function () {
    if (Auth::check()) {
        $semua_jalur = [];
        if(Auth::user()->hasRole('admin')){
            $semua_jalur = [
                'SD' => Jalur::where('bentuk_pendidikan_id', 5)->get(),
                'SMP' => Jalur::where('bentuk_pendidikan_id', 6)->get()
            ];
        }
        return view('admin')->with([
            'user' => Auth::user(),
            'all_jalur' => Jalur::where('bentuk_pendidikan_id', Auth::user()->bentuk_pendidikan_id)->get(),
            'semua_jalur' => $semua_jalur,
        ]);
    }
    return redirect('/login');
})->where('vue_capture', '[\/\w\.-]*')->middleware('auth');