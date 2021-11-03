<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Simpanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class SimpananController extends Controller
{
    public function index(Request $request)
    {
        $title = "Data Simpanan Anggota";

        $query = Anggota::query();
        $query->select('*');
        if (isset($request->cari)) {
            $query->where('nama_lengkap', 'like', "%" . $request->cari . "%");
        }
        $anggota = $query->paginate(10);
        $anggota->appends($request->all());

        return view('simpanan.index', compact('title', 'anggota'));
    }

    public function show($no_anggota)
    {
        $title = "Detail Transaksi Simpanan Anggota";
        $no_anggota = Crypt::decrypt($no_anggota);
        $anggota = DB::table('koperasi_anggota')->where('no_anggota', $no_anggota)->first();
        return view('simpanan.show', compact('title', 'anggota'));
    }
}
