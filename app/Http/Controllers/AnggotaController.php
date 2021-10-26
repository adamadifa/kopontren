<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class AnggotaController extends Controller
{
    public function index()
    {
        $title = "Data Anggota";
        $anggota = DB::table('koperasi_anggota')->paginate(10);
        return view('anggota.index', compact('title', 'anggota'));
    }

    public function create()
    {
        $title = "Input Data Anggota";
        return view('anggota.create', compact('title'));
    }


    public function edit($no_rek_anggota)
    {
        $title = "Edit Data Anggota";
        $no_rek_anggota = Crypt::decrypt($no_rek_anggota);
        $anggota = DB::table('koperasi_anggota')->where('no_rek_anggota', $no_rek_anggota)->first();
        return view('anggota.edit', compact('title', 'anggota'));
    }

    public function update($no_rek_anggota, Request $request)
    {
        $no_rek_anggota = Crypt::decrypt($no_rek_anggota);
        $request->validate([
            'nik' => 'required',
            'nama_lengkap' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required'
        ]);

        $update = DB::table('koperasi_anggota')
            ->where('no_rek_anggota', $no_rek_anggota)
            ->update([
                'no_rek_anggota' => $no_rek_anggota,
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
            ->select('no_rek_anggota')
            ->where(DB::raw('left(no_rek_anggota,4)'), $format)
            ->orderBy('no_rek_anggota', 'desc')
            ->first();



        if (empty($cekanggota->no_rek_anggota)) {
            $no_rek_anggota_terakhir = $format . "-" . "00000";
        } else {
            $no_rek_anggota_terakhir = $cekanggota->no_rek_anggota;
        }

        $no_rek_anggota = buatkode($no_rek_anggota_terakhir, $format . "-", 5);

        $simpan = DB::table('koperasi_anggota')->insert([
            'no_rek_anggota' => $no_rek_anggota,
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
            return redirect('/anggota')->with(['success' => 'Data Gagal Disimpan']);
        }
    }
}
