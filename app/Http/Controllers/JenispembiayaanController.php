<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class JenispembiayaanController extends Controller
{
    function index()
    {
        $jenispembiayaan = DB::table('koperasi_jenispembiayaan')->get();
        return view('jenispembiayaan.index', compact('jenispembiayaan'));
    }

    function create()
    {
        return view('jenispembiayaan.create');
    }

    function store(Request $request)
    {
        $request->validate([
            'kode_pembiayaan' => 'required|unique:koperasi_jenispembiayaan,kode_pembiayaan|max:3|min:3',
            'nama_pembiayaan' => 'required',
            'persentase' => 'required'
        ]);
        $simpan = DB::table('koperasi_jenispembiayaan')->insert([
            'kode_pembiayaan' => $request->kode_pembiayaan,
            'nama_pembiayaan' => $request->nama_pembiayaan,
            'persentase' => $request->persentase
        ]);
        if ($simpan) {
            return redirect('/jenispembiayaan')->with(['success' => 'Data Berhasil Disimpan']);
        } else {
            return redirect('/jenispembiayaan')->with(['warning' => 'Data Gagal Disimpan']);
        }
    }

    function edit($kode_pembiayaan)
    {
        $kode_pembiayaan = Crypt::decrypt($kode_pembiayaan);
        $jenispembiayaan = DB::table('koperasi_jenispembiayaan')->where('kode_pembiayaan', $kode_pembiayaan)->first();
        return view('jenispembiayaan.edit', compact( 'jenispembiayaan'));
    }

    function update(Request $request, $kode_pembiayaan)
    {
        $kode_pembiayaan = Crypt::decrypt($kode_pembiayaan);
        $request->validate([
            'nama_pembiayaan' => 'required',
            'persentase' => 'required'
        ]);

        $update = DB::table('koperasi_jenispembiayaan')
            ->where('kode_pembiayaan', $kode_pembiayaan)
            ->update([
                'nama_pembiayaan' => $request->nama_pembiayaan,
                'persentase' => $request->persentase
            ]);

        if ($update) {
            return redirect('/jenispembiayaan')->with(['success' => 'Data Berhasil di Update']);
        } else {
            return redirect('/jenispembiayaan')->with(['warning' => 'Data Gagal di Update']);
        }
    }


    function destroy($kode_pembiayaan)
    {
        $kode_pembiayaan = Crypt::decrypt($kode_pembiayaan);
        $hapus = DB::table('koperasi_jenispembiayaan')->where('kode_pembiayaan', $kode_pembiayaan)->delete();
        if ($hapus) {
            return redirect('/jenispembiayaan')->with(['success' => 'Data Berhasil dihapus']);
        } else {
            return redirect('/jenispembiayaan')->with(['warning' => 'Data Gagal dihapus']);
        }
    }
}
