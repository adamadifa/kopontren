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

    public function laporansimpanan()
    {
        $jenissimpanan = DB::table('koperasi_jenissimpanan')->get();
        return view('simpanan.laporan', compact('jenissimpanan'));
    }

    function cetakbayarsimpanan(Request $request)
    {
        $dari = $request->dari;
        $sampai = $request->sampai;
        $simpanan = DB::table('koperasi_jenissimpanan')->where('kode_simpanan', $request->kode_simpanan)->first();
        $transaksi = DB::table('koperasi_simpanan')
            ->select('koperasi_simpanan.*', 'nama_lengkap', 'nama_simpanan')
            ->join('koperasi_anggota', 'koperasi_simpanan.no_anggota', '=', 'koperasi_anggota.no_anggota')
            ->join('koperasi_jenissimpanan', 'koperasi_simpanan.kode_simpanan', '=', 'koperasi_jenissimpanan.kode_simpanan')
            ->where('koperasi_simpanan.kode_simpanan', $request->kode_simpanan)
            ->whereBetween('tgl_transaksi', [$request->dari, $request->sampai])->get();

        $pdf = PDF::loadview('simpanan.cetak_lapbayar', compact('transaksi', 'dari', 'sampai', 'simpanan'))->setPaper('a4');
        return $pdf->stream();
        //return view('pendaftar.cetak', compact('pendaftar', 'qrcode'));
    }

    public function rekapsimpanan()
    {
        return view('simpanan.rekap');
    }

    function cetakrekapsimpanan(Request $request)
    {
        $lasttahun = $request->tahun - 1;
        $dari = $request->tahun . "-01-01";
        $lastdari = $request->tahun - 1 . "-01-01";
        $cekakhirbulan = $request->tahun . "-12-01";
        $lastcekakhirbulan = $request->tahun - 1 . "-12-01";
        $sampai = date("Y-m-t", strtotime($cekakhirbulan));
        $lastsampai = date("Y-m-t", strtotime($lastcekakhirbulan));
        $transaksi = DB::table('koperasi_anggota as ka')
            ->select(
                'ka.no_anggota',
                'nama_lengkap',
                DB::raw('ifnull(saldoawal,0) as saldoawal'),
                DB::raw('ifnull(jan,0) as jan'),
                DB::raw('ifnull(feb,0) as feb'),
                DB::raw('ifnull(mar,0) as mar'),
                DB::raw('ifnull(apr,0) as apr'),
                DB::raw('ifnull(mei,0) as mei'),
                DB::raw('ifnull(jun,0) as jun'),
                DB::raw('ifnull(jul,0) as jul'),
                DB::raw('ifnull(agu,0) as agu'),
                DB::raw('ifnull(sep,0) as sep'),
                DB::raw('ifnull(okt,0) as okt'),
                DB::raw('ifnull(nov,0) as nov'),
                DB::raw('ifnull(des,0) as des')
            )
            ->leftJoin(
                DB::raw("(
                    SELECT ks.no_anggota,
                    SUM(IF(MONTH(tgl_transaksi)=1 AND jenis_transaksi='S',jumlah,0)) - SUM(IF(MONTH(tgl_transaksi)=1 AND jenis_transaksi='T',jumlah,0)) as 'jan',
                    SUM(IF(MONTH(tgl_transaksi)=2 AND jenis_transaksi='S',jumlah,0)) -SUM(IF(MONTH(tgl_transaksi)=2 AND jenis_transaksi='T',jumlah,0)) as 'feb',
                    SUM(IF(MONTH(tgl_transaksi)=3 AND jenis_transaksi='S',jumlah,0)) -SUM(IF(MONTH(tgl_transaksi)=3 AND jenis_transaksi='T',jumlah,0)) as 'mar',
                    SUM(IF(MONTH(tgl_transaksi)=4 AND jenis_transaksi='S',jumlah,0)) -SUM(IF(MONTH(tgl_transaksi)=4 AND jenis_transaksi='T',jumlah,0)) as 'apr',
                    SUM(IF(MONTH(tgl_transaksi)=5 AND jenis_transaksi='S',jumlah,0)) - SUM(IF(MONTH(tgl_transaksi)=5 AND jenis_transaksi='T',jumlah,0))  as 'mei',
                    SUM(IF(MONTH(tgl_transaksi)=6 AND jenis_transaksi='S',jumlah,0)) - SUM(IF(MONTH(tgl_transaksi)=6 AND jenis_transaksi='T',jumlah,0))  as 'jun',
                    SUM(IF(MONTH(tgl_transaksi)=7 AND jenis_transaksi='S',jumlah,0)) - SUM(IF(MONTH(tgl_transaksi)=7 AND jenis_transaksi='T',jumlah,0))  as 'jul',
                    SUM(IF(MONTH(tgl_transaksi)=8 AND jenis_transaksi='S',jumlah,0)) - SUM(IF(MONTH(tgl_transaksi)=8 AND jenis_transaksi='T',jumlah,0))  as 'agu',
                    SUM(IF(MONTH(tgl_transaksi)=9 AND jenis_transaksi='S',jumlah,0)) - SUM(IF(MONTH(tgl_transaksi)=9 AND jenis_transaksi='T',jumlah,0)) as 'sep',
                    SUM(IF(MONTH(tgl_transaksi)=10 AND jenis_transaksi='S',jumlah,0)) - SUM(IF(MONTH(tgl_transaksi)=10 AND jenis_transaksi='T',jumlah,0)) as 'okt',
                    SUM(IF(MONTH(tgl_transaksi)=11 AND jenis_transaksi='S',jumlah,0)) - SUM(IF(MONTH(tgl_transaksi)=11 AND jenis_transaksi='T',jumlah,0)) as 'nov',
                    SUM(IF(MONTH(tgl_transaksi)=12 AND jenis_transaksi='S',jumlah,0)) - SUM(IF(MONTH(tgl_transaksi)=12 AND jenis_transaksi='T',jumlah,0)) as 'des'
                    FROM koperasi_simpanan ks
                    WHERE tgl_transaksi BETWEEN '$dari' AND '$sampai'
                    GROUP BY ks.no_anggota
                ) histori"),
                function ($join) {
                    $join->on('ka.no_anggota', '=', 'histori.no_anggota');
                }
            )
            ->leftJoin(
                DB::raw("(
                    SELECT no_anggota,saldo as saldoawal
                        FROM koperasi_simpanan
                        WHERE no_transaksi IN (SELECT max(no_transaksi) as no_transaksi FROM koperasi_simpanan)
                        AND tgl_transaksi BETWEEN '$lastdari' AND '$lastsampai'
                ) sa"),
                function ($join) {
                    $join->on('ka.no_anggota', '=', 'sa.no_anggota');
                }
            )
            ->groupBy('ka.no_anggota', 'nama_lengkap', 'jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des', 'saldoawal')->get();
        $pdf = PDF::loadview('simpanan.cetak_rekap', compact('transaksi', 'dari', 'sampai', 'lasttahun'))->setPaper('legal', 'landscape');
        return $pdf->stream();
        //return view('pendaftar.cetak', compact('pendaftar', 'qrcode'));
    }
}
