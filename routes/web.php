<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaterkitController;
use App\Http\Controllers\LanguageController;

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

/*Route::get('/', [StaterkitController::class, 'home'])->name('home');
Route::get('home', [StaterkitController::class, 'home'])->name('home');*/
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/', function () {
        return view('content.dashboard');
    })->name('dashboard');
    Route::get('/dashboard', function () {
        return view('content.dashboard');
    })->name('dashboard');
    // Route Components
    Route::get('absensi', [StaterkitController::class, 'absensi'])->name('absensi.index');
    Route::get('ptk', [StaterkitController::class, 'ptk'])->name('absensi.ptk');
    Route::get('rekapitulasi', [StaterkitController::class, 'rekapitulasi'])->name('absensi.rekapitulasi');
    Route::get('pengaturan', [StaterkitController::class, 'pengaturan'])->name('absensi.pengaturan');
    Route::get('data-sekolah', [StaterkitController::class, 'data_sekolah'])->name('absensi.data_sekolah');
    Route::group(['prefix' => 'setting'], function(){
        Route::get('/kategori', [StaterkitController::class, 'data_kategori'])->name('setting.data_kategori');
        Route::get('/jam', [StaterkitController::class, 'data_jam'])->name('setting.data_jam');
    });
});


// locale Route
Route::get('lang/{locale}', [LanguageController::class, 'swap']);


