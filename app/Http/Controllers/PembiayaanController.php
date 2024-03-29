<?php

namespace App\Http\Controllers;

use App\Models\Pembiayaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use PDF;

class PembiayaanController extends Controller
{

    function is_decimal($val)
    {
        return is_numeric($val) && floor($val) != $val;
    }
    public function index(Request $request)
    {
        $query = Pembiayaan::query();
        $query->select('koperasi_pembiayaan.*', 'nama_lengkap', 'nama_pembiayaan');
        $query->join('koperasi_anggota', 'koperasi_pembiayaan.no_anggota', '=', 'koperasi_anggota.no_anggota');
        $query->join('koperasi_jenispembiayaan', 'koperasi_pembiayaan.kode_pembiayaan', '=', 'koperasi_jenispembiayaan.kode_pembiayaan');
        if (isset($request->nama)) {
            $query->where('nama_lengkap', 'like', "%" . $request->nama . "%");
        }

        if (!empty($request->dari) && !empty($request->sampai)) {
            $query->whereBetween('tgl_permohonan', [$request->dari, $request->sampai]);
        }
        $query->orderBy('tgl_permohonan', 'desc');
        $query->orderBy('no_akad', 'desc');

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


        $cicilanperbulan = $tagihan / $request->jangka_waktu;
        if ($this->is_decimal($cicilanperbulan)) {
            $jmlangsuran = $cicilanperbulan;
            $jmlangsuran = ceil($jmlangsuran);
            //dd(substr($jmlangsuran, -3));
            if (substr($jmlangsuran, -3) > 500) {
                $jumlah_angsuran = round($jmlangsuran, -3);
            } else {
                $jumlah_angsuran = round($jmlangsuran, -3) + 1000;
            }
        } else {
            $jumlah_angsuran = $cicilanperbulan;
        }

        $angsuran = $request->jangka_waktu;

        $cicilan_terakhir =  ($tagihan - ($jumlah_angsuran * ($angsuran - 1)));
        // if ($request->jangka_waktu == 12) {
        //     $cicilan12 = str_replace(substr(ROUND($cicilan10), -4), "0000", ROUND($cicilan10));
        //     $sisacicilan = $tagihan - ($cicilan12 * 11);
        // }

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


            for ($i = 1; $i <= $angsuran; $i++) {
                if ($bln > 12) {
                    $blncicilan = $bln - 12;
                    $tahun = $tahun + 1;
                } else {
                    $blncicilan = $bln;
                    $tahun = $tahun;
                }


                if ($i == $angsuran) {
                    $cicilan = $cicilan_terakhir;
                } else {
                    $cicilan = $jumlah_angsuran;
                }

                DB::table('koperasi_rencanapembiayaan')
                    ->insert([
                        'no_akad' => $no_akad,
                        'cicilan_ke' => $i,
                        'bulan' => $blncicilan,
                        'tahun' => $tahun,
                        'jumlah' => $cicilan
                    ]);

                // echo "No Akad :" . $no_akad . "<br>";
                // echo "Cicilan Ke :" . $i . "<br>";
                // echo "Bulan :" . $blncicilan . "<br>";
                // echo "Tahun :" . $tahun . "<br>";
                // echo "Jumlah :" . $cicilan . "<br>";
                $bln++;
            }

            DB::commit();

            return redirect('/pembiayaan')->with(['success' => 'Data Pembiayaan Berhasil di Simpan']);
        } catch (\Exception $e) {
            //dd($e);
            DB::rollback();
            return redirect('/pembiayaan')->with(['warning' => 'Data Pembiayaan Gagal di Simpan']);
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

            return redirect('/pembiayaan')->with(['success' => 'Data Pembiayaan Berhasil di Hapus']);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('/pembiayaan')->with(['warning' => 'Data Pembiayaan Gagal di Hapus']);
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
        $totalrow = DB::table('koperasi_bayarpembiayaan')->where('no_akad', $no_akad)->count();
        return view('pembiayaan.show', compact('anggota', 'rencanabayar', 'cicilanke', 'histori', 'totalrow'));
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
        $rencana = DB::table('koperasi_rencanapembiayaan')
            ->where('no_akad', $no_akad)
            ->whereRaw('jumlah != bayar')
            ->orderBy('cicilan_ke', 'asc')
            ->get();
        $mulaicicilan = DB::table('koperasi_rencanapembiayaan')
            ->where('no_akad', $no_akad)
            ->whereRaw('jumlah != bayar')
            ->orderBy('cicilan_ke', 'asc')
            ->first();
        DB::beginTransaction();
        try {

            $jumlah = str_replace(".", "", $request->jumlah);
            $sisa = $jumlah;
            $cicilan = "";
            $i = $mulaicicilan->cicilan_ke;
            foreach ($rencana as $d) {

                if ($sisa >= $d->jumlah) {
                    DB::table('koperasi_rencanapembiayaan')
                        ->where('no_akad', $no_akad)
                        ->where('cicilan_ke', $i)
                        ->update([
                            'bayar' => $d->jumlah
                        ]);
                    //$cicilan .=  $d->cicilan_ke . ",";
                    $sisapercicilan = $d->jumlah - $d->bayar;
                    $sisa = $sisa - $sisapercicilan;

                    if ($sisa == 0) {
                        $cicilan .=  $d->cicilan_ke;
                    } else {
                        $cicilan .=  $d->cicilan_ke . ",";
                    }

                    $coba = $cicilan;
                } else {
                    if ($sisa != 0) {
                        $sisapercicilan = $d->jumlah - $d->bayar;
                        if ($d->bayar != 0) {
                            if ($sisa >= $sisapercicilan) {
                                DB::table('koperasi_rencanapembiayaan')
                                    ->where('no_akad', $no_akad)
                                    ->where('cicilan_ke', $i)
                                    ->update([
                                        'bayar' =>  DB::raw('bayar +' . $sisapercicilan)
                                    ]);
                                $cicilan .= $d->cicilan_ke . ",";
                                $sisa = $sisa - $sisapercicilan;
                            } else {
                                DB::table('koperasi_rencanapembiayaan')
                                    ->where('no_akad', $no_akad)
                                    ->where('cicilan_ke', $i)
                                    ->update([
                                        'bayar' =>  DB::raw('bayar +' . $sisa)
                                    ]);
                                //$cicilan .= $d->cicilan_ke . ",";
                                $sisa = $sisa - $sisa;
                                if ($sisa == 0) {
                                    $cicilan .=  $d->cicilan_ke;
                                } else {
                                    $cicilan .=  $d->cicilan_ke . ",";
                                }
                            }
                        } else {
                            DB::table('koperasi_rencanapembiayaan')
                                ->where('no_akad', $no_akad)
                                ->where('cicilan_ke', $i)
                                ->update([
                                    'bayar' =>  DB::raw('bayar +' . $sisa)
                                ]);
                            //$cicilan .= $d->cicilan_ke;
                            $sisa = $sisa - $sisa;
                            if ($sisa == 0) {
                                $cicilan .=  $d->cicilan_ke;
                            } else {
                                $cicilan .=  $d->cicilan_ke . ",";
                            }
                        }
                    }
                }
                $i++;
            }

            //$c = '$cicilan';
            DB::table('koperasi_bayarpembiayaan')
                ->insert([
                    'no_transaksi' => $no_transaksi,
                    'no_akad' => $no_akad,
                    'tgl_transaksi' => $request->tgl_transaksi,
                    'cicilan_ke' => $cicilan,
                    'jumlah' => str_replace(".", "", $request->jumlah),
                    'id_petugas' => Auth::user()->id
                ]);
            DB::table('koperasi_pembiayaan')
                ->where('no_akad', $no_akad)
                ->update([
                    'jmlbayar' => DB::raw('jmlbayar +' . str_replace(".", "", $request->jumlah))
                ]);

            $detail = DB::table('koperasi_pembiayaan')->where('no_akad', $no_akad)
                ->select('no_akad', 'koperasi_anggota.nama_lengkap', 'jumlah', 'persentase', 'jmlbayar', 'karyawan.no_hp')
                ->join('koperasi_anggota', 'koperasi_pembiayaan.no_anggota', '=', 'koperasi_anggota.no_anggota')
                ->leftjoin('karyawan', 'koperasi_anggota.npp', '=', 'karyawan.npp')
                ->first();
            $tagihan = $detail->jumlah + ($detail->jumlah * ($detail->persentase / 100));
            $jmlbayar = number_format($detail->jmlbayar, '0', '', '.');
            $sisa =  number_format($tagihan - $detail->jmlbayar, '0', '', '.');
            $no_k = Crypt::encrypt($no_transaksi);
            $data = [
                'api_key' => 'NHoqE4TUf6YLQhJJQAGSUjj4wOMyzh',
                'sender' => '6289670444321',
                'number' => $detail->no_hp,
                'message' => 'Terimakasih Bp/Ibu ' . $detail->nama_lengkap . ' telah melakukan pembayaran Cicilan ke ' . $cicilan . ' untuk Pembiayaan dengan No. Akad ' . $no_akad . ' Sebesar *' . $request->jumlah . '* Total Tagihan Sebesar :*' . number_format($tagihan, '0', '', '.') . '* Jumlah Yang Telah Dibayarkan Sebesar: *' . $jmlbayar . '* Sisa Yang Harus Dibayarkan Sejumlah : *' . $sisa . '* Lihat Kwitansi => http://tsarwah.persisalamin.com/pembiayaan/' . $no_k . '/cetakkwitansi'
            ];
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://wa.pedasalami.com/send-message',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            DB::commit();

            return redirect('/pembiayaan/' . Crypt::encrypt($no_akad) . '/show')->with(['success' => 'Data Pembiayaan Berhasil di Simpan']);
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return redirect('/pembiayaan/' . Crypt::encrypt($no_akad) . '/show')->with(['warning' => 'Data Pembiayaan Gagal di Simpan']);
        }
    }

    function deletebayar($no_transaksi)
    {
        $no_transaksi = Crypt::decrypt($no_transaksi);
        $trans = DB::table('koperasi_bayarpembiayaan')->where('no_transaksi', $no_transaksi)->first();
        $cicilan_ke = array_map('intval', explode(',', $trans->cicilan_ke));
        $rencana = DB::table('koperasi_rencanapembiayaan')
            ->where('no_akad', $trans->no_akad)
            ->whereIn('cicilan_ke', $cicilan_ke)
            ->orderBy('cicilan_ke', 'desc')
            ->get();
        //dd($rencana);
        $mulaicicilan = DB::table('koperasi_rencanapembiayaan')
            ->where('no_akad', $trans->no_akad)
            ->whereIn('cicilan_ke', $cicilan_ke)
            ->orderBy('cicilan_ke', 'desc')
            ->first();
        //dd($mulaicicilan);
        DB::beginTransaction();
        try {
            $sisa = $trans->jumlah;
            $i = $mulaicicilan->cicilan_ke;
            foreach ($rencana as $d) {
                if ($sisa >= $d->bayar) {
                    DB::table('koperasi_rencanapembiayaan')
                        ->where('no_akad', $trans->no_akad)
                        ->where('cicilan_ke', $i)
                        ->update([
                            'bayar' => DB::raw('bayar -' . $d->bayar)
                        ]);
                    $sisa = $sisa - $d->bayar;
                } else {
                    if ($sisa != 0) {
                        DB::table('koperasi_rencanapembiayaan')
                            ->where('no_akad', $trans->no_akad)
                            ->where('cicilan_ke', $i)
                            ->update([
                                'bayar' =>  DB::raw('bayar -' . $sisa)
                            ]);
                        $sisa = $sisa - $sisa;
                    }
                }

                $i--;
            }
            DB::table('koperasi_bayarpembiayaan')
                ->where('no_transaksi', $no_transaksi)
                ->delete();

            DB::table('koperasi_pembiayaan')
                ->where('no_akad', $trans->no_akad)
                ->update([
                    'jmlbayar' => DB::raw('jmlbayar -' . $trans->jumlah)
                ]);
            DB::commit();

            return redirect('/pembiayaan/' . Crypt::encrypt($trans->no_akad) . '/show')->with(['success' => 'Data Pembiayaan Berhasil di Hapus']);
        } catch (\Exception $e) {
            DB::rollback();
            //dd($e);
            return redirect('/pembiayaan/' . Crypt::encrypt($trans->no_akad) . '/show')->with(['success' => 'Data Pembiayaan Gagal di Hapus']);
        }
    }

    function cetakkwitansi($no_transaksi)
    {
        $no_transaksi = Crypt::decrypt($no_transaksi);
        $transaksi = DB::table('koperasi_bayarpembiayaan')
            ->select('koperasi_bayarpembiayaan.*', 'koperasi_pembiayaan.no_akad', 'keperluan', 'koperasi_pembiayaan.no_anggota', 'nama_lengkap', 'name')
            ->join('koperasi_pembiayaan', 'koperasi_bayarpembiayaan.no_akad', '=', 'koperasi_pembiayaan.no_akad')
            ->join('koperasi_anggota', 'koperasi_pembiayaan.no_anggota', '=', 'koperasi_anggota.no_anggota')
            ->join('users', 'koperasi_bayarpembiayaan.id_petugas', '=', 'users.id')
            ->where('no_transaksi', $no_transaksi)->first();

        return view('pembiayaan.cetak_kwitansi', compact('transaksi'));
        // $pdf = PDF::loadview('pembiayaan.cetak_kwitansi', compact('transaksi'))->setPaper('a5', 'landscape');;
        // return $pdf->stream();
        //return view('pendaftar.cetak', compact('pendaftar', 'qrcode'));
    }

    public function laporanpembiayaan()
    {

        return view('pembiayaan.laporan');
    }

    function cetakbayarpembiayaan(Request $request)
    {
        $dari = $request->dari;
        $sampai = $request->sampai;
        $transaksi = DB::table('koperasi_bayarpembiayaan')
            ->select('koperasi_bayarpembiayaan.*', 'koperasi_pembiayaan.no_akad', 'keperluan', 'koperasi_pembiayaan.no_anggota', 'nama_lengkap')
            ->join('koperasi_pembiayaan', 'koperasi_bayarpembiayaan.no_akad', '=', 'koperasi_pembiayaan.no_akad')
            ->join('koperasi_anggota', 'koperasi_pembiayaan.no_anggota', '=', 'koperasi_anggota.no_anggota')
            ->whereBetween('tgl_transaksi', [$request->dari, $request->sampai])->get();
        return view('pembiayaan.cetak_lapbayar', compact('transaksi', 'dari', 'sampai'));
        // $pdf = PDF::loadview('pembiayaan.cetak_lapbayar', compact('transaksi', 'dari', 'sampai'))->setPaper('a4', 'landscape');
        // return $pdf->stream();
        //return view('pendaftar.cetak', compact('pendaftar', 'qrcode'));
    }
    function cetakrekappembiayaan()
    {

        $pembiayaan = DB::table('koperasi_pembiayaan as kp')
            ->select('kp.no_akad', 'tgl_permohonan', 'kp.no_anggota', 'nama_lengkap', 'jumlah', 'kp.persentase', 'jmlbayar', 'jangka_waktu', 'kp.kode_pembiayaan', 'nama_pembiayaan', 'sisacicilan')
            ->join('koperasi_jenispembiayaan as kj', 'kp.kode_pembiayaan', '=', 'kj.kode_pembiayaan')
            ->join('koperasi_anggota as ka', 'kp.no_anggota', '=', 'ka.no_anggota')
            ->leftJoin(
                DB::raw("(
                    SELECT no_akad,COUNT(bayar) as sisacicilan
                    FROM koperasi_rencanapembiayaan kr
                    WHERE bayar = 0
                    GROUP BY no_akad
                ) rencana"),
                function ($join) {
                    $join->on('kp.no_akad', '=', 'rencana.no_akad');
                }
            )
            ->get();
        return view('pembiayaan.cetak_rekap', compact('pembiayaan'));
        // $pdf = PDF::loadview('pembiayaan.cetak_rekap', compact('pembiayaan'))->setPaper('a4', 'landscape');
        // return $pdf->stream();
        //return view('pendaftar.cetak', compact('pendaftar', 'qrcode'));
    }


    public function updaterencanabayar($no_akad)
    {


        $no_akad = Crypt::decrypt($no_akad);
        $pembiayaan = DB::table('koperasi_pembiayaan')->where('no_akad', $no_akad)->first();
        $rencana = DB::table('koperasi_rencanapembiayaan')->where('no_akad', $no_akad)->where('cicilan_ke', 1)->first();
        $bln = $rencana->bulan;
        $tahunangsuran = $rencana->tahun;
        $angsuran = $pembiayaan->jangka_waktu;
        $jml_pembiayaan = $pembiayaan->jumlah;
        $persentase = $pembiayaan->persentase;
        $jumlah_pinjaman = $jml_pembiayaan + ($jml_pembiayaan * ($persentase / 100));
        $cicilanperbulan = $jumlah_pinjaman / $angsuran;
        //dd($cicilanperbulan);
        if ($this->is_decimal($cicilanperbulan)) {
            $jmlangsuran = $cicilanperbulan;
            $jmlangsuran = ceil($jmlangsuran);
            //dd(substr($jmlangsuran, -3));
            if (substr($jmlangsuran, -3) > 500) {
                $jumlah_angsuran = round($jmlangsuran, -3);
            } else {
                $jumlah_angsuran = round($jmlangsuran, -3) + 1000;
            }
        } else {
            $jumlah_angsuran = $cicilanperbulan;
        }




        // echo "Jumlah Angsuran * Angsuran = " .  $jumlah_angsuran * ($angsuran - 1) . "<br>";
        // echo "Jumlah Pinjaman = " .  $jumlah_pinjaman . "<br>";
        // echo "Sisa = " . ($jumlah_pinjaman - ($jumlah_angsuran * ($angsuran - 1))) . "<br>";
        $cicilan_terakhir =  ($jumlah_pinjaman - ($jumlah_angsuran * ($angsuran - 1)));
        //echo $cicilan_terakhir;

        DB::beginTransaction();
        try {
            DB::table('koperasi_rencanapembiayaan')->where('no_akad', $no_akad)->delete();
            for ($i = 1; $i <= $angsuran; $i++) {
                if ($bln > 12) {
                    $blncicilan = $bln - 12;
                    $tahun = $tahunangsuran + 1;
                } else {
                    $blncicilan = $bln;
                    $tahun = $tahunangsuran;
                }


                if ($i == $angsuran) {
                    $cicilan = $cicilan_terakhir;
                } else {
                    $cicilan = $jumlah_angsuran;
                }

                DB::table('koperasi_rencanapembiayaan')
                    ->insert([
                        'no_akad' => $no_akad,
                        'cicilan_ke' => $i,
                        'bulan' => $blncicilan,
                        'tahun' => $tahun,
                        'jumlah' => $cicilan
                    ]);

                // echo "No Akad :" . $no_akad . "<br>";
                // echo "Cicilan Ke :" . $i . "<br>";
                // echo "Bulan :" . $blncicilan . "<br>";
                // echo "Tahun :" . $tahun . "<br>";
                // echo "Jumlah :" . $cicilan . "<br>";
                $bln++;
            }


            $jumlah = $pembiayaan->jmlbayar;
            $sisa = $jumlah;
            $cicilan = "";
            $mulaicicilan = DB::table('koperasi_rencanapembiayaan')
                ->where('no_akad', $no_akad)
                ->whereRaw('jumlah != bayar')
                ->orderBy('cicilan_ke', 'asc')
                ->first();
            $i = $mulaicicilan->cicilan_ke;
            $rencana2 = DB::table('koperasi_rencanapembiayaan')
                ->where('no_akad', $no_akad)
                ->whereRaw('jumlah != bayar')
                ->orderBy('cicilan_ke', 'asc')
                ->get();

            //dd($sisa);

            foreach ($rencana2 as $d) {

                if ($sisa >= $d->jumlah) {
                    DB::table('koperasi_rencanapembiayaan')
                        ->where('no_akad', $no_akad)
                        ->where('cicilan_ke', $i)
                        ->update([
                            'bayar' => $d->jumlah
                        ]);
                    //$cicilan .=  $d->cicilan_ke . ",";
                    $sisapercicilan = $d->jumlah - $d->bayar;
                    $sisa = $sisa - $sisapercicilan;

                    if ($sisa == 0) {
                        $cicilan .=  $d->cicilan_ke;
                    } else {
                        $cicilan .=  $d->cicilan_ke . ",";
                    }

                    $coba = $cicilan;
                } else {
                    if ($sisa != 0) {
                        $sisapercicilan = $d->jumlah - $d->bayar;
                        if ($d->bayar != 0) {
                            if ($sisa >= $sisapercicilan) {
                                DB::table('koperasi_rencanapembiayaan')
                                    ->where('no_akad', $no_akad)
                                    ->where('cicilan_ke', $i)
                                    ->update([
                                        'bayar' =>  DB::raw('bayar +' . $sisapercicilan)
                                    ]);
                                $cicilan .= $d->cicilan_ke . ",";
                                $sisa = $sisa - $sisapercicilan;
                            } else {
                                DB::table('koperasi_rencanapembiayaan')
                                    ->where('no_akad', $no_akad)
                                    ->where('cicilan_ke', $i)
                                    ->update([
                                        'bayar' =>  DB::raw('bayar +' . $sisa)
                                    ]);
                                //$cicilan .= $d->cicilan_ke . ",";
                                $sisa = $sisa - $sisa;
                                if ($sisa == 0) {
                                    $cicilan .=  $d->cicilan_ke;
                                } else {
                                    $cicilan .=  $d->cicilan_ke . ",";
                                }
                            }
                        } else {
                            DB::table('koperasi_rencanapembiayaan')
                                ->where('no_akad', $no_akad)
                                ->where('cicilan_ke', $i)
                                ->update([
                                    'bayar' =>  DB::raw('bayar +' . $sisa)
                                ]);
                            //$cicilan .= $d->cicilan_ke;
                            $sisa = $sisa - $sisa;
                            if ($sisa == 0) {
                                $cicilan .=  $d->cicilan_ke;
                            } else {
                                $cicilan .=  $d->cicilan_ke . ",";
                            }
                        }
                    }
                }
                $i++;
            }
            DB::commit();
            return Redirect::back()->with(['success' => 'Berhasil Di update']);
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }
}
