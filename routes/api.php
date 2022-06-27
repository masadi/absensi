<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Dpw;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\DonasiController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ReferensiController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('cari-dpw', [ReferensiController::class, 'cari_dpw'])->name('api.cari_dpw');
Route::get('cari-alumni', [ReferensiController::class, 'cari_alumni'])->name('api.cari_alumni');
Route::group(['prefix' => 'alumni'], function () {
    Route::post('aktif', [AlumniController::class, 'api_alumni_aktif'])->name('api.alumni_aktif');
    Route::post('non-aktif', [AlumniController::class, 'api_alumni_non_aktif'])->name('api.alumni_non_aktif');
});
Route::group(['prefix' => 'donasi'], function () {
    Route::post('list', [DonasiController::class, 'api_list_donasi'])->name('api.list_donasi');
    Route::post('riwayat', [DonasiController::class, 'api_riwayat_donasi'])->name('api.riwayat_donasi');
});
Route::post('events', [EventController::class, 'api_list_event'])->name('api.list_event');
