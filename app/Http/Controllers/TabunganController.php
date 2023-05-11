<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\HistoriTabungan;
use App\Models\Tabungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use PDF;

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
        try {
            DB::table('koperasi_jenistabungan')->where('kode_tabungan', $kode_tabungan)->delete();
            return redirect('/tabungan')->with(['success' => 'Data Berhasil dihapus']);
        } catch (\Exception $e) {
            return redirect('/tabungan')->with(['warning' => 'Data Gagal dihapus']);
        }
    }

    public function listrekening(Request $request)
    {
        $query = Tabungan::query();
        $query->select('koperasi_tabungan.*', 'nama_lengkap', 'nama_tabungan');
        $query->join('koperasi_anggota', 'koperasi_tabungan.no_anggota', '=', 'koperasi_anggota.no_anggota');
        $query->join('koperasi_jenistabungan', 'koperasi_tabungan.kode_tabungan', '=', 'koperasi_jenistabungan.kode_tabungan');
        if (isset($request->nama)) {
            $query->where('nama_lengkap', 'like', "%" . $request->nama . "%");
        }

        if (isset($request->kodetabungan)) {
            $query->where('koperasi_tabungan.kode_tabungan', $request->kodetabungan);
        }
        $rekening = $query->paginate(10);
        $rekening->appends($request->all());

        $tabungan = DB::table('koperasi_jenistabungan')->get();
        return view('tabungan.listrekening', compact('rekening', 'tabungan'));
    }

    public function storerekening(Request $request)
    {
        $norek = $request->kode_tabungan . "-" . $request->no_anggota;
        $cek = DB::table('koperasi_tabungan')->where('no_rekening', $norek)->count();
        if ($cek == 0) {
            $simpan = DB::table('koperasi_tabungan')->insert([
                'no_rekening' => $norek,
                'no_anggota' => $request->no_anggota,
                'kode_tabungan' => $request->kode_tabungan,
                'id_petugas' => Auth::user()->id
            ]);
            if ($simpan) {
                return redirect('/rekening')->with(['success' => 'Data Berhasil Disimpan']);
            } else {
                return redirect('/rekening')->with(['warning' => 'Data Gagal Disimpan']);
            }
        } else {
            return redirect('/rekening')->with(['warning' => 'Anggota Tersebut Sudah Memiliki No Rekening Untuk Tabungan ini']);
        }
    }

    public function destroyrekening($no_rekening)
    {
        $no_rekening = Crypt::decrypt($no_rekening);
        try {
            DB::table('koperasi_tabungan')
                ->where('no_rekening', $no_rekening)
                ->delete();
            return redirect('/rekening')->with(['success' => 'Data Berhasil Dihapus']);
        } catch (\Exception $e) {
            return redirect('/rekening')->with(['warning' => 'Data Gagal Dihapus']);
        }
    }


    public function destroyhistori($no_transaksi)
    {

        $no_transaksi = Crypt::decrypt($no_transaksi);

        $cekrekening = DB::table('koperasi_tabungan_histori')->where('no_transaksi', $no_transaksi)->first();

        $no_rekening = $cekrekening->no_rekening;
        //$kode_tabungan = $cekanggota->kode_simpanan;
        $jenis_transaksi = $cekrekening->jenis_transaksi;
        $jumlah = $cekrekening->jumlah;
        if ($jenis_transaksi == "S") {
            $operator = "-";
        } else if ($jenis_transaksi == "T") {
            $operator = "+";
        }
        DB::beginTransaction();
        try {

            DB::table('koperasi_tabungan_histori')->where('no_transaksi', $no_transaksi)->delete();
            DB::table('koperasi_tabungan')
                ->where('no_rekening', $no_rekening)
                ->update([
                    'saldo' => DB::raw('saldo' . $operator . $jumlah)
                ]);
            DB::commit();
            return redirect('/rekening/' . Crypt::encrypt($no_rekening) . '/show')->with(['success' => 'Data Berhasil Dihapus']);
        } catch (\Exception $e) {
            //dd($e);
            DB::rollback();
            return redirect('/rekening/' . Crypt::encrypt($no_rekening) . '/show')->with(['warning' => 'Data Gagal Dihapus']);
        }
    }





    public function showrekening($no_rekening, Request $request)
    {
        $no_rekening = Crypt::decrypt($no_rekening);


        $query = HistoriTabungan::query();

        $query->select('koperasi_tabungan_histori.*', 'nama_tabungan', 'name');
        $query->join('koperasi_tabungan', 'koperasi_tabungan_histori.no_rekening', '=', 'koperasi_tabungan.no_rekening');
        $query->join('koperasi_jenistabungan', 'koperasi_tabungan.kode_tabungan', '=', 'koperasi_jenistabungan.kode_tabungan');
        $query->join('users', 'koperasi_tabungan.id_petugas', '=', 'users.id');
        $query->where('koperasi_tabungan_histori.no_rekening', $no_rekening);
        $query->orderBy('created_at', 'asc')->get();
        if (isset($request->dari) and isset($request->sampai)) {
            $query->whereBetween('tgl_transaksi', [$request->dari, $request->sampai]);
        }
        $datatabungan = $query->paginate(30);
        $datatabungan->appends($request->all());

        if (isset($request->dari) and isset($request->sampai)) {
            $lastdata = DB::table('koperasi_tabungan_histori')
                ->where('tgl_transaksi', '<', $request->dari)
                ->orderBy('no_transaksi', 'desc')
                ->first();
        } else {
            $lastdata = null;
        }
        $totalrow = DB::table('koperasi_tabungan_histori')->where('no_rekening', $no_rekening)->count();
        $saldotabungan = DB::table('koperasi_tabungan')
            ->select('saldo')
            ->where('no_rekening', $no_rekening)->first();


        $anggota = DB::table('koperasi_tabungan')
            ->join('koperasi_anggota', 'koperasi_tabungan.no_anggota', '=', 'koperasi_anggota.no_anggota')
            ->join('koperasi_jenistabungan', 'koperasi_tabungan.kode_tabungan', '=', 'koperasi_jenistabungan.kode_tabungan')
            ->where('no_rekening', $no_rekening)->first();
        return view('tabungan.show', compact('anggota', 'datatabungan', 'totalrow', 'saldotabungan', 'lastdata'));
    }


    public function storemutasi(Request $request)
    {
        $no_rekening = Crypt::decrypt($request->no_rekening);
        $tanggal = $request->tgl_transaksi;
        $tgl = explode("-", $tanggal);
        $tahun = $tgl[0];
        $bulan = $tgl[1];
        if (strlen($bulan) > 1) {
            $bulan = $bulan;
        } else {
            $bulan = "0" . $bulan;
        }
        $format = $request->kode_tabungan . substr($tahun, 2, 2) . $bulan;
        //Cek Simpanan Terakhir
        $cektabungan = DB::table('koperasi_tabungan_histori')
            ->select('no_transaksi')
            ->where(DB::raw('left(no_transaksi,7)'), $format)
            ->orderBy('no_transaksi', 'desc')
            ->first();

        //dd($ceksimpanan);

        if (empty($cektabungan->no_transaksi)) {
            $no_transaksi_terakhir = $format . "-" . "000";
        } else {
            $no_transaksi_terakhir = $cektabungan->no_transaksi;
        }

        //dd($no_transaksi_terakhir);
        $no_transaksi = buatkode($no_transaksi_terakhir, $format . "-", 3);
        $jumlah = str_replace(".", "", $request->jumlah);
        if ($request->jenis_transaksi == "S") {
            $operator = "+";
        } else if ($request->jenis_transaksi == "T") {
            $operator = "-";
        }
        DB::beginTransaction();
        try {

            DB::table('koperasi_tabungan_histori')->insert([
                'no_transaksi' => $no_transaksi,
                'tgl_transaksi' => $request->tgl_transaksi,
                'no_rekening' => $no_rekening,
                'jumlah' => str_replace(".", "", $request->jumlah),
                'jenis_transaksi' => $request->jenis_transaksi,
                'berita' => $request->berita,
                'id_petugas' => Auth::user()->id
            ]);

            DB::table('koperasi_tabungan')
                ->where('no_rekening', $no_rekening)
                ->update([
                    'saldo' => DB::raw('saldo' . $operator . $jumlah)
                ]);

            $ceksaldoterakhir = DB::table('koperasi_tabungan')
                ->select('saldo')
                ->where('no_rekening', $no_rekening)
                ->first();

            DB::table('koperasi_tabungan_histori')
                ->where('no_transaksi', $no_transaksi)
                ->update([
                    'saldo' => $ceksaldoterakhir->saldo
                ]);

            DB::commit();
            return redirect('/rekening/' . Crypt::encrypt($no_rekening) . '/show')->with(['success' => 'Data Berhasil Disimpan']);
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            return redirect('/rekening/' . Crypt::encrypt($no_rekening) . '/show')->with(['warning' => 'Data Gagal Disimpan']);
        }
    }

    function cetakkwitansi($no_transaksi)
    {
        $no_transaksi = Crypt::decrypt($no_transaksi);
        $transaksi = DB::table('koperasi_tabungan_histori')
            ->select('koperasi_tabungan_histori.*', 'koperasi_tabungan.no_anggota', 'nama_lengkap', 'nama_tabungan')
            ->join('koperasi_tabungan', 'koperasi_tabungan_histori.no_rekening', '=', 'koperasi_tabungan.no_rekening')
            ->join('koperasi_anggota', 'koperasi_tabungan.no_anggota', '=', 'koperasi_anggota.no_anggota')
            ->join('koperasi_jenistabungan', 'koperasi_tabungan.kode_tabungan', '=', 'koperasi_jenistabungan.kode_tabungan')
            ->where('no_transaksi', $no_transaksi)->first();

        return view('tabungan.cetak_kwitansi', compact('transaksi'));
        // $pdf = PDF::loadview('tabungan.cetak_kwitansi', compact('transaksi'))->setPaper('a5', 'landscape');;
        //return $pdf->stream();
        //return view('pendaftar.cetak', compact('pendaftar', 'qrcode'));
    }

    public function laporantabungan()
    {
        $jenistabungan = DB::table('koperasi_jenistabungan')->get();
        return view('tabungan.laporan', compact('jenistabungan'));
    }

    function cetakbayartabungan(Request $request)
    {
        $dari = $request->dari;
        $sampai = $request->sampai;
        $tabungan = DB::table('koperasi_jenistabungan')->where('kode_tabungan', $request->jenis_tabungan)->first();
        $transaksi = DB::table('koperasi_tabungan_histori')
            ->select('koperasi_tabungan_histori.*', 'koperasi_tabungan.no_anggota', 'nama_lengkap', 'nama_tabungan')
            ->join('koperasi_tabungan', 'koperasi_tabungan_histori.no_rekening', '=', 'koperasi_tabungan.no_rekening')
            ->join('koperasi_anggota', 'koperasi_tabungan.no_anggota', '=', 'koperasi_anggota.no_anggota')
            ->join('koperasi_jenistabungan', 'koperasi_tabungan.kode_tabungan', '=', 'koperasi_jenistabungan.kode_tabungan')
            ->where('koperasi_tabungan.kode_tabungan', $request->jenis_tabungan)
            ->whereBetween('tgl_transaksi', [$request->dari, $request->sampai])->get();
        //dd($transaksi);

        return view('tabungan.cetak_lapbayar', compact('transaksi', 'dari', 'sampai', 'tabungan'));
        // $pdf = PDF::loadview('tabungan.cetak_lapbayar', compact('transaksi', 'dari', 'sampai', 'tabungan'))->setPaper('a4');
        // return $pdf->stream();
        //return view('pendaftar.cetak', compact('pendaftar', 'qrcode'));
    }

    public function rekaptabungan()
    {
        $jenistabungan = DB::table('koperasi_jenistabungan')->get();
        return view('tabungan.rekap', compact('jenistabungan'));
    }

    function cetakrekaptabungan(Request $request)
    {
        $lasttahun = $request->tahun - 1;
        $dari = $request->tahun . "-01-01";
        $lastdari = $request->tahun - 1 . "-01-01";
        $cekakhirbulan = $request->tahun . "-12-01";
        $lastcekakhirbulan = $request->tahun - 1 . "-12-01";
        $sampai = date("Y-m-t", strtotime($cekakhirbulan));
        $lastsampai = date("Y-m-t", strtotime($lastcekakhirbulan));
        $tabungan = DB::table('koperasi_jenistabungan')->where('kode_tabungan', $request->jenis_tabungan)->first();
        $transaksi = DB::table('koperasi_tabungan as kt')
            ->select(
                'kt.no_rekening',
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
            ->join('koperasi_anggota as ka', 'kt.no_anggota', '=', 'ka.no_anggota')
            ->leftJoin(
                DB::raw("(
                    SELECT kth.no_rekening,
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
                    FROM koperasi_tabungan_histori kth
                    WHERE tgl_transaksi BETWEEN '$dari' AND '$sampai'
                    GROUP BY no_rekening
                ) histori"),
                function ($join) {
                    $join->on('kt.no_rekening', '=', 'histori.no_rekening');
                }
            )
            ->leftJoin(
                DB::raw("(
                    SELECT no_rekening,saldo as saldoawal
                        FROM koperasi_tabungan_histori
                        WHERE no_transaksi IN (SELECT max(no_transaksi) as no_transaksi FROM koperasi_tabungan_histori WHERE tgl_transaksi BETWEEN '$lastdari' AND '$lastsampai' GROUP BY no_rekening)
                ) sa"),
                function ($join) {
                    $join->on('kt.no_rekening', '=', 'sa.no_rekening');
                }
            )
            ->where('kt.kode_tabungan', $request->jenis_tabungan)
            ->groupBy('kt.no_rekening', 'nama_lengkap', 'jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'agu', 'sep', 'okt', 'nov', 'des', 'saldoawal')->get();
        return view('tabungan.cetak_rekap', compact('transaksi', 'dari', 'sampai', 'tabungan', 'lasttahun'));
        // $pdf = PDF::loadview('tabungan.cetak_rekap', compact('transaksi', 'dari', 'sampai', 'tabungan', 'lasttahun'))->setPaper('legal', 'landscape');
        // return $pdf->stream();
        //return view('pendaftar.cetak', compact('pendaftar', 'qrcode'));
    }
}
