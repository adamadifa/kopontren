<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class AnggotaController extends Controller
{
    public function index(Request $request)
    {

        $query = Anggota::query();
        $query->select('*');
        if (isset($request->cari)) {
            $query->where('nama_lengkap', 'like', "%" . $request->cari . "%");
        }
        $anggota = $query->paginate(10);
        $anggota->appends($request->all());
        return view('anggota.index', compact('anggota'));
    }

    public function create()
    {
        $propinsi = DB::table('provinces')->orderBy('prov_name', 'asc')->get();
        return view('anggota.create', compact('propinsi'));
    }


    public function edit($no_anggota)
    {
        $title = "Edit Data Anggota";
        $no_anggota = Crypt::decrypt($no_anggota);
        $karyawan = DB::table('karyawan')->orderBy('nama_lengkap', 'asc')->get();
        $siswa = DB::table('siswa')->orderBy('nama_lengkap', 'asc')->get();
        $propinsi = DB::table('provinces')->orderBy('prov_name', 'asc')->get();
        $anggota = DB::table('koperasi_anggota')->where('no_anggota', $no_anggota)->first();
        return view('anggota.edit', compact('propinsi', 'anggota', 'karyawan', 'siswa'));
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
            'jenis_kelamin' => 'required',
            'pendidikan_terakhir' => 'required',
            'status_pernikahan' => 'required',
            'id_propinsi' => 'required',
            'id_kota' => 'required',
            'id_kecamatan' => 'required',
            'id_kelurahan' => 'required',
            'status_tinggal' => 'required',
            'no_hp' => 'required',

        ]);

        $update = DB::table('koperasi_anggota')
            ->where('no_anggota', $no_anggota)
            ->update([
                'no_anggota' => $no_anggota,
                'nik' => $request->nik,
                'nama_lengkap' => $request->nama_lengkap,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'pendidikan_terakhir' => $request->pendidikan_terakhir,
                'status_pernikahan' => $request->status_pernikahan,
                'jml_tanggungan' => $request->jml_tanggungan,
                'nama_pasangan' => $request->nama_pasangan,
                'pekerjaan_pasangan' => $request->pekerjaan_pasangan,
                'nama_ibu' => $request->nama_ibu,
                'nama_saudara' => $request->nama_saudara,
                'alamat' => $request->alamat,
                'id_propinsi' => $request->id_propinsi,
                'id_kota' => $request->id_kota,
                'id_kecamatan' => $request->id_kecamatan,
                'id_kelurahan' => $request->id_kelurahan,
                'kode_pos' => $request->kode_pos,
                'status_tinggal' => $request->status_tinggal,
                'no_hp' => $request->no_hp,
                'npp' => $request->npp,
                'id_siswa' => $request->id_siswa
            ]);

        if ($update) {
            return Redirect::back()->with(['success' => 'Data Berhasil Disimpan']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Disimpan']);
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
            'jenis_kelamin' => 'required',
            'pendidikan_terakhir' => 'required',
            'status_pernikahan' => 'required',
            'id_propinsi' => 'required',
            'id_kota' => 'required',
            'id_kecamatan' => 'required',
            'id_kelurahan' => 'required',
            'status_tinggal' => 'required',
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
            'jenis_kelamin' => $request->jenis_kelamin,
            'pendidikan_terakhir' => $request->pendidikan_terakhir,
            'status_pernikahan' => $request->status_pernikahan,
            'jml_tanggungan' => $request->jml_tanggungan,
            'nama_pasangan' => $request->nama_pasangan,
            'pekerjaan_pasangan' => $request->pekerjaan_pasangan,
            'nama_ibu' => $request->nama_ibu,
            'nama_saudara' => $request->nama_saudara,
            'alamat' => $request->alamat,
            'id_propinsi' => $request->id_propinsi,
            'id_kota' => $request->id_kota,
            'id_kecamatan' => $request->id_kecamatan,
            'id_kelurahan' => $request->id_kelurahan,
            'kode_pos' => $request->kode_pos,
            'status_tinggal' => $request->status_tinggal,
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
