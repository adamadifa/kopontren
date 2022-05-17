<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboardadmin()
    {
    
        $jmlanggota = DB::table('koperasi_anggota')->count();
        $simpanan = DB::table('koperasi_simpanan')
            ->select(DB::raw('SUM(IF(jenis_transaksi="S",jumlah,0)) as jmlsetoran, SUM(IF(jenis_transaksi="T",jumlah,0)) as jmlpenarikan'))
            ->whereRaw('MONTH(tgl_transaksi) = ' . date("m"))
            ->whereRaw('YEAR(tgl_transaksi) = ' . date("Y"))
            ->first();
        $saldosimpanan = DB::table('koperasi_saldo_simpanan')
            ->select(DB::raw('SUM(IF(kode_simpanan="001",jumlah,0)) as pokok, SUM(IF(kode_simpanan="002",jumlah,0)) as wajib,SUM(IF(kode_simpanan="003",jumlah,0)) as sukarela'))
            ->first();
        //dd($simpanan);
        return view('dashboard.administrator', compact('jmlanggota', 'simpanan', 'saldosimpanan'));
    }
}
