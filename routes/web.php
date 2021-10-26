<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DaftarController;
use App\Http\Controllers\DashboardController;
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
    Route::get('/anggota/{no_rek_anggota}/edit', [AnggotaController::class, 'edit']);
    Route::post('/anggota/{no_rek_anggota}/update', [AnggotaController::class, 'update']);
    Route::post('/anggota/store', [AnggotaController::class, 'store']);
});
