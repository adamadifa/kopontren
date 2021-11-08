<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class JenissimpananController extends Controller
{
    function index()
    {
        $title = "Jenis Simpanan";
        $jenissimpanan = DB::table('koperasi_jenissimpanan')->get();
        return view('jenissimpanan.index', compact('title', 'jenissimpanan'));
    }

    function create()
    {
        $title = "Tambah Jenis Simpanan";
        return view('jenissimpanan.create', compact('title'));
    }

    function store(Request $request)
    {
        $request->validate([
            'kode_simpanan' => 'required|unique:koperasi_jenissimpanan,kode_simpanan|max:3|min:3',
            'nama_simpanan' => 'required'
        ]);
        $simpan = DB::table('koperasi_jenissimpanan')->insert([
            'kode_simpanan' => $request->kode_simpanan,
            'nama_simpanan' => $request->nama_simpanan
        ]);
        if ($simpan) {
            return redirect('/jenissimpanan')->with(['success' => 'Data Berhasil Disimpan']);
        } else {
            return redirect('/jenissimpanan')->with(['warning' => 'Data Gagal Disimpan']);
        }
    }

    function edit($kode_simpanan)
    {
        $title = "Edit Jenis Simpanan";
        $kode_simpanan = Crypt::decrypt($kode_simpanan);
        $jenissimpanan = DB::table('koperasi_jenissimpanan')->where('kode_simpanan', $kode_simpanan)->first();
        return view('jenissimpanan.edit', compact('title', 'jenissimpanan'));
    }

    function update(Request $request, $kode_simpanan)
    {
        $kode_simpanan = Crypt::decrypt($kode_simpanan);
        $request->validate([
            'kode_simpanan' => 'required',
            'nama_simpanan' => 'required'
        ]);

        $update = DB::table('koperasi_jenissimpanan')
            ->where('kode_simpanan', $kode_simpanan)
            ->update([
                'kode_simpanan' => $request->kode_simpanan,
                'nama_simpanan' => $request->nama_simpanan
            ]);

        if ($update) {
            return redirect('/jenissimpanan')->with(['success' => 'Data Berhasil di Update']);
        } else {
            return redirect('/jenissimpanan')->with(['warning' => 'Data Gagal di Update']);
        }
    }

    function destroy($kode_simpanan)
    {

        dd($kode_simpanan);
        $kode_simpanan = Crypt::decrypt($kode_simpanan);
        $hapus = DB::table('koperasi_jenissimpanan')->where('kode_simpanan', $kode_simpanan)->delete();
        if ($hapus) {
            return redirect('/jenissimpanan')->with(['success' => 'Data Berhasil dihapus']);
        } else {
            return redirect('/jenissimpanan')->with(['warning' => 'Data Gagal dihapus']);
        }
    }
}
