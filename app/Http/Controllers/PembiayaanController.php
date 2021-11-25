<?php

namespace App\Http\Controllers;

use App\Models\Pembiayaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class PembiayaanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pembiayaan::query();
        $query->select('koperasi_pembiayaan.*', 'nama_lengkap', 'nama_pembiayaan');
        $query->join('koperasi_anggota', 'koperasi_pembiayaan.no_anggota', '=', 'koperasi_anggota.no_anggota');
        $query->join('koperasi_jenispembiayaan', 'koperasi_pembiayaan.kode_pembiayaan', '=', 'koperasi_jenispembiayaan.kode_pembiayaan');
        $pembiayaan = $query->paginate(10);
        $pembiayaan->appends($request->all());
        return view('pembiayaan.index', compact('pembiayaan'));
    }

    public function create()
    {
        $jenispembiayaan = DB::table('koperasi_jenispembiayaan')->get();
        $propinsi = DB::table('provinces')->orderBy('prov_name', 'asc')->get();
        return view('pembiayaan.create', compact('propinsi', 'jenispembiayaan'));
    }

    public function store(Request $request)
    {


        $request->validate([
            'tgl_permohonan' => 'required',
            'kode_anggota' => 'required',
            'kode_pembiayaan' => 'required',
            'jangka_waktu' => 'required',
            'jumlah' => 'required',
            'keperluan' => 'required',
            'jaminan' => 'required',
            'ktp_pemohon' => 'accepted',
            'ktp_pasangan' => 'accepted',
            'kartu_keluarga' => 'accepted',
            'struk_gaji' => 'accepted'

        ]);
        $tanggal = $request->tgl_permohonan;
        $tgl = explode("-", $tanggal);
        $tahun = $tgl[0];
        $bulan = $tgl[1];
        if (strlen($bulan) > 1) {
            $bulan = $bulan;
        } else {
            $bulan = "0" . $bulan;
        }
        $format = "PB" . substr($tahun, 2, 2) . $bulan;
        //Cek Simpanan Terakhir
        $cekpembiayaan = DB::table('koperasi_pembiayaan')
            ->select('no_akad')
            ->where(DB::raw('left(no_akad,6)'), $format)
            ->orderBy('no_akad', 'desc')
            ->first();

        //dd($ceksimpanan);

        if (empty($cekpembiayaan->no_akad)) {
            $no_akad_terakhir = $format . "-" . "000";
        } else {
            $no_akad_terakhir = $cekpembiayaan->no_akad;
        }

        $tagihan = str_replace(".", "", $request->jumlah) + (str_replace(".", "", $request->jumlah) * ($request->persentase / 100));
        $no_akad = buatkode($no_akad_terakhir, $format . "-", 3);
        $cicilan10 = $tagihan / $request->jangka_waktu;


        if ($request->jangka_waktu == 12) {
            $cicilan12 = str_replace(substr(ROUND($cicilan10), -4), "0000", ROUND($cicilan10));
            $sisacicilan = $tagihan - ($cicilan12 * 11);
        }

        $bln = $bulan + 1;
        DB::beginTransaction();
        try {

            DB::table('koperasi_pembiayaan')
                ->insert([
                    'no_akad' => $no_akad,
                    'tgl_permohonan' => $request->tgl_permohonan,
                    'no_anggota' => $request->kode_anggota,
                    'kode_pembiayaan' => $request->kode_pembiayaan,
                    'jumlah' => str_replace(".", "", $request->jumlah),
                    'persentase' => $request->persentase,
                    'jangka_waktu' => $request->jangka_waktu,
                    'keperluan' => $request->keperluan,
                    'jaminan' => $request->jaminan,
                    'ktp_pemohon' => $request->ktp_pemohon,
                    'ktp_pasangan' => $request->ktp_pasangan,
                    'kartu_keluarga' => $request->kartu_keluarga,
                    'struk_gaji' => $request->struk_gaji,
                ]);


            for ($i = 1; $i <= $request->jangka_waktu; $i++) {
                if ($bln > 12) {
                    $bln = 1;
                    $tahun = $tahun + 1;
                } else {
                    $bln = $bln;
                    $tahun = $tahun;
                }

                if ($request->jangka_waktu == 12) {
                    if ($i == 12) {
                        $cicilan = $sisacicilan;
                    } else {
                        $cicilan = $cicilan12;
                    }
                } else {
                    $cicilan = $cicilan10;
                }
                DB::table('koperasi_rencanapembiayaan')
                    ->insert([
                        'no_akad' => $no_akad,
                        'cicilan_ke' => $i,
                        'bulan' => $bln,
                        'tahun' => $tahun,
                        'jumlah' => $cicilan
                    ]);

                $bln++;
            }

            DB::commit();

            return redirect('/pembiayaan')->with(['success' => 'Data SPP Berhasil di Simpan']);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('/pembiayaan')->with(['warning' => 'Data SPP Gagal di Simpan']);
        }
    }

    public function delete($no_akad)
    {
        $no_akad = Crypt::decrypt($no_akad);
        DB::beginTransaction();
        try {
            DB::table('koperasi_pembiayaan')
                ->where('no_akad', $no_akad)
                ->delete();

            DB::commit();

            return redirect('/pembiayaan')->with(['success' => 'Data SPP Berhasil di Hapus']);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('/pembiayaan')->with(['warning' => 'Data SPP Gagal di Hapus']);
        }
    }

    public function show($no_akad)
    {
        $no_akad = Crypt::decrypt($no_akad);
        $anggota = DB::table('koperasi_pembiayaan')
            ->join('koperasi_anggota', 'koperasi_pembiayaan.no_anggota', '=', 'koperasi_anggota.no_anggota')
            ->join('koperasi_jenispembiayaan', 'koperasi_pembiayaan.kode_pembiayaan', '=', 'koperasi_jenispembiayaan.kode_pembiayaan')
            ->where('no_akad', $no_akad)->first();
        $rencanabayar = DB::table('koperasi_rencanapembiayaan')->where('no_akad', $no_akad)->get();
        $cicilanke = DB::table('koperasi_rencanapembiayaan')
            ->where('no_akad', $no_akad)
            ->whereRaw('bayar < jumlah')
            ->orderBy('cicilan_ke', 'asc')
            ->first();
        $histori = DB::table('koperasi_bayarpembiayaan')->where('no_akad', $no_akad)->get();
        return view('pembiayaan.show', compact('anggota', 'rencanabayar', 'cicilanke', 'histori'));
    }

    public function bayar(Request $request)
    {
        $no_akad = Crypt::decrypt($request->no_akad);
        $tanggal = $request->tgl_transaksi;
        $tgl = explode("-", $tanggal);
        $tahun = $tgl[0];
        $bulan = $tgl[1];
        if (strlen($bulan) > 1) {
            $bulan = $bulan;
        } else {
            $bulan = "0" . $bulan;
        }
        $format = "TSW" . substr($tahun, 2, 2) . $bulan;
        //Cek Simpanan Terakhir
        $cekpembiayaan = DB::table('koperasi_bayarpembiayaan')
            ->select('no_transaksi')
            ->where(DB::raw('left(no_transaksi,7)'), $format)
            ->orderBy('no_transaksi', 'desc')
            ->first();

        //dd($ceksimpanan);

        if (empty($cekpembiayaan->no_transaksi)) {
            $no_transaksi_terakhir = $format . "-" . "000";
        } else {
            $no_transaksi_terakhir = $cekpembiayaan->no_transaksi;
        }

        //dd($no_transaksi_terakhir);
        $no_transaksi = buatkode($no_transaksi_terakhir, $format . "-", 3);
        DB::beginTransaction();
        try {
            DB::table('koperasi_bayarpembiayaan')
                ->insert([
                    'no_transaksi' => $no_transaksi,
                    'no_akad' => $no_akad,
                    'tgl_transaksi' => $request->tgl_transaksi,
                    'cicilan_ke' => $request->cicilan_ke,
                    'jumlah' => str_replace(".", "", $request->jumlah),
                    'id_petugas' => Auth::user()->id
                ]);

            DB::table('koperasi_rencanapembiayaan')
                ->where('no_akad', $no_akad)
                ->where('cicilan_ke', $request->cicilan_ke)
                ->update([
                    'bayar' => str_replace(".", "", $request->jumlah)
                ]);

            DB::commit();

            return redirect('/pembiayaan/' . Crypt::encrypt($no_akad) . '/show')->with(['success' => 'Data SPP Berhasil di Simpan']);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('/pembiayaan/' . Crypt::encrypt($no_akad) . '/show')->with(['warning' => 'Data SPP Gagal di Simpan']);
        }
    }

    function deletebayar($no_transaksi)
    {
        $no_transaksi = Crypt::decrypt($no_transaksi);
        DB::beginTransaction();
        try {
            $trans = DB::table('koperasi_bayarpembiayaan')->where('no_transaksi', $no_transaksi)->first();
            //dd($trans);
            DB::table('koperasi_rencanapembiayaan')
                ->where('no_akad', $trans->no_akad)
                ->where('cicilan_ke', $trans->cicilan_ke)
                ->update([
                    'bayar' => 0
                ]);
            DB::table('koperasi_bayarpembiayaan')
                ->where('no_transaksi', $no_transaksi)
                ->delete();


            DB::commit();

            return redirect('/pembiayaan/' . Crypt::encrypt($trans->no_akad) . '/show')->with(['success' => 'Data SPP Berhasil di Hapus']);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('/pembiayaan/' . Crypt::encrypt($trans->no_akad) . '/show')->with(['success' => 'Data SPP Gagal di Hapus']);
        }
    }
}
