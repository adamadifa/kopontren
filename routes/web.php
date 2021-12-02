<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DaftarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JenispembiayaanController;
use App\Http\Controllers\JenissimpananController;
use App\Http\Controllers\LoaddataController;
use App\Http\Controllers\PembiayaanController;
use App\Http\Controllers\SimpananController;
use App\Http\Controllers\TabunganController;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
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
    Route::post('/anggota/getautocomplete', [AnggotaController::class, 'autocompleteAnggota']);
    Route::get('getAnggota', function (Request $request) {
        if ($request->ajax()) {
            $data = Anggota::get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="#"
                    no-anggota="' . $row->no_anggota .
                        '" nama="' . $row->nama_lengkap .
                        '" nik="' . $row->nik .
                        '" tempat_lahir="' . $row->tempat_lahir .
                        '" tanggal_lahir="' . $row->tanggal_lahir .
                        '" jenis_kelamin="' . $row->jenis_kelamin .
                        '" pendidikan_terakhir="' . $row->pendidikan_terakhir .
                        '" status_pernikahan="' . $row->status_pernikahan .
                        '" jml_tanggungan="' . $row->jml_tanggungan .
                        '" nama_pasangan="' . $row->nama_pasangan .
                        '" pekerjaan_pasangan="' . $row->pekerjaan_pasangan .
                        '" nama_ibu="' . $row->nama_ibu .
                        '" nama_saudara="' . $row->nama_saudara .
                        '" no_hp="' . $row->no_hp .
                        '" alamat="' . $row->alamat .
                        '" id_propinsi="' . $row->id_propinsi .
                        '" id_kota="' . $row->id_kota .
                        '" id_kecamatan="' . $row->id_kecamatan .
                        '" id_kelurahan="' . $row->id_kelurahan .
                        '" kode_pos="' . $row->kode_pos .
                        '" status_tinggal="' . $row->status_tinggal .
                        '" class="pilih btn btn-success btn-sm">Pilih</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    })->name('dataanggota');


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
    Route::get('/rekening', [TabunganController::class, 'listrekening']);
    Route::post('/rekening/store', [TabunganController::class, 'storerekening']);
    Route::delete('/rekening/{no_rekening}/delete', [TabunganController::class, 'destroyrekening']);
    Route::get('/rekening/{no_rekening}/show', [TabunganController::class, 'showrekening']);
    Route::get('/tabungan/{no_transaksi}/cetakkwitansi', [TabunganController::class, 'cetakkwitansi']);
    Route::post('/rekening/storemutasi', [TabunganController::class, 'storemutasi']);
    Route::get('/laporantabungan', [TabunganController::class, 'laporantabungan']);
    Route::get('/rekaptabungan', [TabunganController::class, 'rekaptabungan']);
    Route::post('/cetakbayartabungan', [TabunganController::class, 'cetakbayartabungan']);
    Route::post('/cetakrekaptabungan', [TabunganController::class, 'cetakrekaptabungan']);

    //Jenis Simpanan
    Route::get('/jenispembiayaan', [JenispembiayaanController::class, 'index']);
    Route::get('/jenispembiayaan/create', [JenispembiayaanController::class, 'create']);
    Route::post('/jenispembiayaan/store', [JenispembiayaanController::class, 'store']);
    Route::get('/jenispembiayaan/{kode_pembiayaan}/edit', [JenispembiayaanController::class, 'edit']);
    Route::post('/jenispembiayaan/{kode_pembiayaan}/update', [JenispembiayaanController::class, 'update']);
    Route::delete('/jenispembiayaan/{kode_pembiayaan}/delete', [JenispembiayaanController::class, 'destroy']);


    //Simpanan
    Route::get('/simpanan', [SimpananController::class, 'index']);
    Route::get('/simpanan/{no_anggota}/show', [SimpananController::class, 'show']);
    Route::post('/simpanan/store', [SimpananController::class, 'store']);
    Route::delete('/simpanan/{no_transaksi}/delete', [SimpananController::class, 'destroy']);
    Route::get('/simpanan/{no_transaksi}/cetakkwitansi', [SimpananController::class, 'cetakkwitansi']);
    Route::get('/laporansimpanan', [SimpananController::class, 'laporansimpanan']);
    Route::post('/cetakbayarsimpanan', [SimpananController::class, 'cetakbayarsimpanan']);
    Route::get('/rekapsimpanan', [SimpananController::class, 'rekapsimpanan']);
    Route::post('/cetakrekapsimpanan', [SimpananController::class, 'cetakrekapsimpanan']);
    //Pembiayaan
    Route::get('/pembiayaan', [PembiayaanController::class, 'index']);
    Route::get('/pembiayaan/create', [PembiayaanController::class, 'create']);
    Route::post('/pembiayaan/store', [PembiayaanController::class, 'store']);
    Route::delete('/pembiayaan/{no_akad}/delete', [PembiayaanController::class, 'delete']);
    Route::get('/pembiayaan/{no_akad}/show', [PembiayaanController::class, 'show']);
    Route::post('/pembiayaan/bayar', [PembiayaanController::class, 'bayar']);
    Route::delete('/pembiayaan/{no_transaksi}/deletebayar', [PembiayaanController::class, 'deletebayar']);
    Route::get('/pembiayaan/{no_transaksi}/cetakkwitansi', [PembiayaanController::class, 'cetakkwitansi']);
    Route::get('/laporanpembiayaan', [PembiayaanController::class, 'laporanpembiayaan']);
    Route::post('/cetakbayarpembiayaan', [PembiayaanController::class, 'cetakbayarpembiayaan']);
    Route::get('/cetakrekappembiayaan', [PembiayaanController::class, 'cetakrekappembiayaan']);
    //Loaddata
    Route::post('/loaddata/getkota', [LoaddataController::class, 'getkota']);
    Route::post('/loaddata/getkecamatan', [LoaddataController::class, 'getkecamatan']);
    Route::post('/loaddata/getkelurahan', [LoaddataController::class, 'getkelurahan']);
});
