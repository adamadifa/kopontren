<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DaftarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JenissimpananController;
use App\Http\Controllers\SimpananController;
use App\Http\Controllers\TabunganController;
use Illuminate\Support\Facades\Route;

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
    return view('Auth.login');
})->name('login');


Route::post('/postlogin', [AuthController::class, 'postlogin']);
Route::post('/postlogout', [AuthController::class, 'postlogout']);

Route::middleware(['auth', 'ceklevel:admin'])->group(function () {
    Route::get('/dashboardadmin', [DashboardController::class, 'dashboardadmin']);

    //Anggota
    Route::get('/anggota', [AnggotaController::class, 'index']);
    Route::get('/anggota/create', [AnggotaController::class, 'create']);
    Route::get('/anggota/{no_anggota}/edit', [AnggotaController::class, 'edit']);
    Route::get('/anggota/{no_anggota}/show', [AnggotaController::class, 'show']);
    Route::post('/anggota/{no_anggota}/update', [AnggotaController::class, 'update']);
    Route::delete('/anggota/{no_anggota}/delete', [AnggotaController::class, 'destroy']);
    Route::post('/anggota/store', [AnggotaController::class, 'store']);

    //Jenis Simpanan
    Route::get('/jenissimpanan', [JenissimpananController::class, 'index']);
    Route::get('/jenissimpanan/create', [JenissimpananController::class, 'create']);
    Route::post('/jenissimpanan/store', [JenissimpananController::class, 'store']);
    Route::get('/jenissimpanan/{kode_simpanan}/edit', [JenissimpananController::class, 'edit']);
    Route::post('/jenissimpanan/{kode_simpanan}/update', [JenissimpananController::class, 'update']);
    Route::delete('/jenissimpanan/{kode_simpanan}/delete', [JenissimpananController::class, 'destroy']);

    //Tabungan
    Route::get('/tabungan', [TabunganController::class, 'index']);
    Route::get('/tabungan/create', [TabunganController::class, 'create']);
    Route::post('/tabungan/store', [TabunganController::class, 'store']);
    Route::get('/tabungan/{kode_tabungan}/edit', [TabunganController::class, 'edit']);
    Route::post('/tabungan/{kode_tabungan}/update', [TabunganController::class, 'update']);
    Route::delete('/tabungan/{kode_tabungan}/delete', [TabunganController::class, 'destroy']);

    //Simpanan

    Route::get('/simpanan', [SimpananController::class, 'index']);
    Route::get('/simpanan/{no_anggota}/show', [SimpananController::class, 'show']);
});
