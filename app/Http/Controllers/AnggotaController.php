<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class AnggotaController extends Controller
{
    public function index(Request $request)
    {
        $title = "Data Anggota";

        $query = Anggota::query();
        $query->select('*');
        if (isset($request->cari)) {
            $query->where('nama_lengkap', 'like', "%" . $request->cari . "%");
        }
        $anggota = $query->paginate(10);
        $anggota->appends($request->all());

        return view('anggota.index', compact('title', 'anggota'));
    }

    public function create()
    {
        $title = "Input Data Anggota";
        return view('anggota.create', compact('title'));
    }


    public function edit($no_anggota)
    {
        $title = "Edit Data Anggota";
        $no_anggota = Crypt::decrypt($no_anggota);
        $anggota = DB::table('koperasi_anggota')->where('no_anggota', $no_anggota)->first();
        return view('anggota.edit', compact('title', 'anggota'));
    }

    public function show($no_anggota)
    {
        $title = "Detail Data Anggota";
        $no_anggota = Crypt::decrypt($no_anggota);
        $anggota = DB::table('koperasi_anggota')->where('no_anggota', $no_anggota)->first();
        return view('anggota.show', compact('title', 'anggota'));
    }

    public function update($no_anggota, Request $request)
    {
        $no_anggota = Crypt::decrypt($no_anggota);
        $request->validate([
            'nik' => 'required',
            'nama_lengkap' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required'
        ]);

        $update = DB::table('koperasi_anggota')
            ->where('no_anggota', $no_anggota)
            ->update([
                'no_anggota' => $no_anggota,
                'nik' => $request->nik,
                'nama_lengkap' => $request->nama_lengkap,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp
            ]);

        if ($update) {
            return redirect('/anggota')->with(['success' => 'Data Berhasil Disimpan']);
        } else {
            return redirect('/anggota')->with(['warning' => 'Data Gagal Disimpan']);
        }
    }
    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|unique:koperasi_anggota,nik',
            'nama_lengkap' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required|unique:koperasi_anggota,no_hp'
        ]);

        $tahun = date("Y");
        $bulan = date("m");
        if (strlen($bulan) > 1) {
            $bulan = $bulan;
        } else {
            $bulan = "0" . $bulan;
        }
        $format = substr($tahun, 2, 2) . $bulan;

        //Cek Pendaftaran Terakhir
        $cekanggota = DB::table('koperasi_anggota')
            ->select('no_anggota')
            ->where(DB::raw('left(no_anggota,4)'), $format)
            ->orderBy('no_anggota', 'desc')
            ->first();



        if (empty($cekanggota->no_anggota)) {
            $no_anggota_terakhir = $format . "-" . "00000";
        } else {
            $no_anggota_terakhir = $cekanggota->no_anggota;
        }

        $no_anggota = buatkode($no_anggota_terakhir, $format . "-", 5);

        $simpan = DB::table('koperasi_anggota')->insert([
            'no_anggota' => $no_anggota,
            'nik' => $request->nik,
            'nama_lengkap' => $request->nama_lengkap,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp
        ]);

        if ($simpan) {
            return redirect('/anggota')->with(['success' => 'Data Berhasil Disimpan']);
        } else {
            return redirect('/anggota')->with(['warning' => 'Data Gagal Disimpan']);
        }
    }

    function destroy($no_anggota, Request $request)
    {
        $no_anggota = Crypt::decrypt($no_anggota);
        $hapus = DB::table('koperasi_anggota')
            ->where('no_anggota', $no_anggota)
            ->delete();
        if ($hapus) {
            return redirect('/anggota')->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return redirect('/anggota')->with(['warning' => 'Data Gagal Dihapus']);
        }
    }



    public function autocompleteAnggota(Request $request)
    {

        $search = $request->search;

        if ($search == '') {
            $autocomplate = Anggota::orderby('nama_lengkap', 'asc')->select('no_anggota', 'nama_lengkap')->limit(5)->get();
        } else {
            $autocomplate = Anggota::orderby('nama_lengkap', 'asc')->select('no_anggota', 'nama_lengkap')->where('nama_lengkap', 'like', '%' . $search . '%')->limit(5)->get();
        }


        //dd($autocomplate);
        $response = array();
        foreach ($autocomplate as $autocomplate) {
            $response[] = array("value" => $autocomplate->nama_lengkap, "label" => $autocomplate->nama_lengkap, 'val' => $autocomplate->no_anggota);
        }

        echo json_encode($response);
        exit;
    }
}
