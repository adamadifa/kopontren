<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class TabunganController extends Controller
{
    public function index()
    {
        $title = "Data Jenis Tabungan";
        $tabungan = DB::table('koperasi_jenistabungan')->orderBy('kode_tabungan', 'asc')->get();
        return view('tabungan.index', compact('title', 'tabungan'));
    }

    function create()
    {
        $title = "Input Data Jenis Tabungan";
        return view('tabungan.create', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_tabungan' => 'required|unique:koperasi_jenistabungan,kode_tabungan|max:3|min:3',
            'nama_tabungan' => 'required'
        ]);
        $simpan = DB::table('koperasi_jenistabungan')->insert([
            'kode_tabungan' => $request->kode_tabungan,
            'nama_tabungan' => $request->nama_tabungan
        ]);
        if ($simpan) {
            return redirect('/tabungan')->with(['success' => 'Data Berhasil Disimpan']);
        } else {
            return redirect('/tabungan')->with(['warning' => 'Data Gagal Disimpan']);
        }
    }

    public function edit($kode_tabungan)
    {
        $title = "Edit Jenis Tabungan";
        $kode_tabungan = Crypt::decrypt($kode_tabungan);
        $tabungan = DB::table('koperasi_jenistabungan')->where('kode_tabungan', $kode_tabungan)->first();
        return view('tabungan.edit', compact('title', 'tabungan'));
    }

    public function update(Request $request, $kode_tabungan)
    {
        $request->validate([
            'nama_tabungan' => 'required'
        ]);

        $update = DB::table('koperasi_jenistabungan')
            ->where('kode_tabungan', $kode_tabungan)
            ->update([
                'nama_tabungan' => $request->nama_tabungan
            ]);

        if ($update) {
            return redirect('/tabungan')->with(['success' => 'Data Berhasil di Update']);
        } else {
            return redirect('/tabungan')->with(['warning' => 'Data Gagal di Update']);
        }
    }

    function destroy($kode_tabungan)
    {
        $kode_tabungan = Crypt::decrypt($kode_tabungan);
        $hapus = DB::table('koperasi_jenistabungan')->where('kode_tabungan', $kode_tabungan)->delete();
        if ($hapus) {
            return redirect('/tabungan')->with(['success' => 'Data Berhasil dihapus']);
        } else {
            return redirect('/tabungan')->with(['warning' => 'Data Gagal dihapus']);
        }
    }

    public function listrekening()
    {
        $title = "Data Rekening Tabungan";
        return view('tabungan.listrekening', compact('title'));
    }

    public function autocompleteAnggota(Request $request)
    {
        $query = $request->get('query');
        $filterResult = Anggota::where('nama_lengkap', 'LIKE', '%' . $query . '%')->get();
        return response()->json($filterResult);
    }
}
