<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Simpanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use PDF;

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

    public function show($no_anggota, Request $request)
    {
        $title = "Detail Transaksi Simpanan Anggota";
        $no_anggota = Crypt::decrypt($no_anggota);
        $simpanan = DB::table('koperasi_jenissimpanan')->get();

        $query = Simpanan::query();

        $query->select('koperasi_simpanan.*', 'nama_simpanan', 'name');
        $query->join('koperasi_jenissimpanan', 'koperasi_simpanan.kode_simpanan', '=', 'koperasi_jenissimpanan.kode_simpanan');
        $query->join('users', 'koperasi_simpanan.id_petugas', '=', 'users.id');
        $query->where('no_anggota', $no_anggota);
        $query->orderBy('created_at', 'asc')->get();
        if (isset($request->dari) and isset($request->sampai)) {
            $query->whereBetween('tgl_transaksi', [$request->dari, $request->sampai]);
        }
        $datasimpanan = $query->paginate(30);
        $datasimpanan->appends($request->all());

        if (isset($request->dari) and isset($request->sampai)) {
            $lastdata = DB::table('koperasi_simpanan')
                ->where('tgl_transaksi', '<', $request->dari)
                ->orderBy('no_transaksi', 'desc')
                ->first();
        } else {
            $lastdata = null;
        }
        $totalrow = DB::table('koperasi_simpanan')->where('no_anggota', $no_anggota)->count();
        $saldosimpanan = DB::table('koperasi_saldo_simpanan')
            ->select('koperasi_saldo_simpanan.*', 'nama_simpanan')
            ->leftjoin('koperasi_jenissimpanan', 'koperasi_saldo_simpanan.kode_simpanan', '=', 'koperasi_jenissimpanan.kode_simpanan')
            ->where('no_anggota', $no_anggota)->get();
        $anggota = DB::table('koperasi_anggota')->where('no_anggota', $no_anggota)->first();
        return view('simpanan.show', compact('title', 'anggota', 'simpanan', 'datasimpanan', 'totalrow', 'saldosimpanan', 'lastdata'));
    }

    public function store(Request $request)
    {
        $no_anggota = Crypt::decrypt($request->no_anggota);
        $tanggal = $request->tgl_transaksi;
        $tgl = explode("-", $tanggal);
        $tahun = $tgl[0];
        $bulan = $tgl[1];
        if (strlen($bulan) > 1) {
            $bulan = $bulan;
        } else {
            $bulan = "0" . $bulan;
        }
        $format = "TS" . substr($tahun, 2, 2) . $bulan;
        //Cek Simpanan Terakhir
        $ceksimpanan = DB::table('koperasi_simpanan')
            ->select('no_transaksi')
            ->where(DB::raw('left(no_transaksi,6)'), $format)
            ->orderBy('no_transaksi', 'desc')
            ->first();

        //dd($ceksimpanan);

        if (empty($ceksimpanan->no_transaksi)) {
            $no_transaksi_terakhir = $format . "-" . "0000";
        } else {
            $no_transaksi_terakhir = $ceksimpanan->no_transaksi;
        }

        //dd($no_transaksi_terakhir);
        $no_transaksi = buatkode($no_transaksi_terakhir, $format . "-", 4);

        $ceksaldo = DB::table('koperasi_saldo_simpanan')->where('no_anggota', $no_anggota)->where('kode_simpanan', $request->kode_simpanan)->count();
        $jumlah = str_replace(".", "", $request->jumlah);
        if ($request->jenis_transaksi == "S") {
            $operator = "+";
        } else if ($request->jenis_transaksi == "T") {
            $operator = "-";
        }
        DB::beginTransaction();
        try {

            DB::table('koperasi_simpanan')->insert([
                'no_transaksi' => $no_transaksi,
                'tgl_transaksi' => $request->tgl_transaksi,
                'no_anggota' => $no_anggota,
                'kode_simpanan' => $request->kode_simpanan,
                'jumlah' => str_replace(".", "", $request->jumlah),
                'jenis_transaksi' => $request->jenis_transaksi,
                'berita' => $request->berita,
                'id_petugas' => Auth::user()->id
            ]);

            if ($ceksaldo == 0) {
                DB::table('koperasi_saldo_simpanan')->insert([
                    'no_anggota' => $no_anggota,
                    'kode_simpanan' => $request->kode_simpanan,
                    'jumlah' => str_replace(".", "", $request->jumlah)
                ]);
            } else {
                DB::table('koperasi_saldo_simpanan')
                    ->where('no_anggota', $no_anggota)
                    ->where('kode_simpanan', $request->kode_simpanan)
                    ->update([
                        'jumlah' => DB::raw('jumlah' . $operator . $jumlah)
                    ]);
            }

            $ceksaldoterakhir = DB::table('koperasi_saldo_simpanan')
                ->select(DB::raw('SUM(jumlah) as jumlah'))
                ->where('no_anggota', $no_anggota)
                ->groupBy('no_anggota')
                ->first();

            DB::table('koperasi_simpanan')
                ->where('no_transaksi', $no_transaksi)
                ->update([
                    'saldo' => $ceksaldoterakhir->jumlah
                ]);

            DB::commit();
            return redirect('/simpanan/' . Crypt::encrypt($no_anggota) . '/show')->with(['success' => 'Data Berhasil Disimpan']);
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            return redirect('/simpanan/' . Crypt::encrypt($no_anggota) . '/show')->with(['warning' => 'Data Gagal Disimpan']);
        }
    }

    public function destroy($no_transaksi)
    {
        $no_transaksi = Crypt::decrypt($no_transaksi);
        $cekanggota = DB::table('koperasi_simpanan')->where('no_transaksi', $no_transaksi)->first();
        $no_anggota = $cekanggota->no_anggota;
        $kode_simpanan = $cekanggota->kode_simpanan;
        $jenis_transaksi = $cekanggota->jenis_transaksi;
        $jumlah = $cekanggota->jumlah;
        if ($jenis_transaksi == "S") {
            $operator = "-";
        } else if ($jenis_transaksi == "T") {
            $operator = "+";
        }
        DB::beginTransaction();
        try {

            DB::table('koperasi_simpanan')->where('no_transaksi', $no_transaksi)->delete();
            DB::table('koperasi_saldo_simpanan')
                ->where('no_anggota', $no_anggota)
                ->where('kode_simpanan', $kode_simpanan)
                ->update([
                    'jumlah' => DB::raw('jumlah' . $operator . $jumlah)
                ]);
            DB::commit();
            return redirect('/simpanan/' . Crypt::encrypt($no_anggota) . '/show')->with(['success' => 'Data Berhasil Dihapus']);
        } catch (\Exception $e) {
            //dd($e);
            DB::rollback();
            return redirect('/simpanan/' . Crypt::encrypt($no_anggota) . '/show')->with(['warning' => 'Data Gagal Dihapus']);
        }
    }

    function cetakkwitansi($no_transaksi)
    {
        $no_transaksi = Crypt::decrypt($no_transaksi);
        $transaksi = DB::table('koperasi_simpanan')
            ->select('koperasi_simpanan.*', 'nama_lengkap', 'nama_simpanan')
            ->join('koperasi_anggota', 'koperasi_simpanan.no_anggota', '=', 'koperasi_anggota.no_anggota')
            ->join('koperasi_jenissimpanan', 'koperasi_simpanan.kode_simpanan', '=', 'koperasi_jenissimpanan.kode_simpanan')
            ->where('no_transaksi', $no_transaksi)->first();

        $pdf = PDF::loadview('simpanan.cetak_kwitansi', compact('transaksi'))->setPaper('a5', 'landscape');;
        return $pdf->stream();
        //return view('pendaftar.cetak', compact('pendaftar', 'qrcode'));
    }
}
