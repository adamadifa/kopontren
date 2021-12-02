<title>Laporan Pembayaran Tabungan</title>
<style>
    @page {
        margin: 20px 20px 10px 30px !important;
        padding: 0px 0px 0px 0px !important;
    }

    .judul {
        font-family: Verdana, Geneva, Tahoma, sans-serif;
        font-size: 20px;
        text-align: center;
        color: #005e2f
    }

    .judul2 {
        font-family: Verdana, Geneva, Tahoma, sans-serif;
        font-size: 16px;
        text-align: center;

    }

    .huruf {
        font-family: Verdana, Geneva, Tahoma, sans-serif;
    }

    .ukuranhuruf {
        font-size: 12px;
    }

    .datatable3 {
        border: 1px solid #05090e;
        border-collapse: collapse;
        /* font-size: 10px; */
        /*float:left; */
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        width: 100%;


    }

    .datatable3 td {
        border: 1px solid #000000;
        padding: 6px;
        font-size: 12px;

    }


    .datatable3 th {
        border: 1px solid #000000;
        font-weight: bold;
        padding: 4px;
        text-align: center;
        font-size: 12px;
        background-color: green;
        color: white;
    }

    hr.style2 {
        border-top: 3px double #8c8b8b;
    }

</style>
<table style="width:100%">
    <tr>
        <td style="width:10%">
            <img src="{{ public_path('dist\images\logo.png') }}" alt="" width="100px" height="80px">
        </td>
        <td style="text-align: center">
            <h1>
                <div class="judul">KOPONTREN TSARWAH</div>
                <div class="judul2">PESANTREN PERSATUAN ISLAM AL AMIN SINDANGKASIH - CIAMIS</div>
                <div style="font-style:italic; font-size:14px; font-weight:w400;">
                    Jln. Raya Ancol No. 27 Ancol I Sindangkasih Telp.-Fax. (0265) 325285 Ciamis 46268
                </div>
            </h1>
        </td>
        <td style="width:10%"></td>
    </tr>
</table>
<hr class="style2">
<table style="width: 100%" border="">
    <tr>
        <td style="text-align: center">
            <h1 class="judul2">DATA SETORAN {{ strtoupper($tabungan->nama_tabungan) }}</h1>
        </td>
    </tr>
</table>

<table class="datatable3">
    <tr>
        <th rowspan="2">NO</th>
        <th rowspan="2">No. Rekening</th>
        <th rowspan="2">Nama Anggota</th>
        <th rowspan="2">Saldo {{ $lasttahun }}</th>
        <th colspan="12">Bulan</th>
        <th rowspan="2">Saldo Akhir</th>
    </tr>
    <tr>
        <th>Jan</th>
        <th>Feb</th>
        <th>Mar</th>
        <th>Apr</th>
        <th>Mei</th>
        <th>Jun</th>
        <th>Jul</th>
        <th>Agu</th>
        <th>Sep</th>
        <th>Okt</th>
        <th>Nov</th>
        <th>Des</th>
    </tr>
    @php
    $totaljan = 0;
    $totalfeb = 0;
    $totalmar = 0;
    $totalapr = 0;
    $totalmei = 0;
    $totaljun = 0;
    $totaljul = 0;
    $totalagu = 0;
    $totalsep = 0;
    $totalokt = 0;
    $totalnov = 0;
    $totaldes = 0;
    $totalsaldoakhir =0;
    $totalsaldoawal = 0;
    @endphp
    @foreach ($transaksi as $d)
    @php

    $saldoakhir = $d->saldoawal + $d->jan + $d->feb + $d->mar + $d->apr + $d->mei + $d->jun + $d->jul +$d->agu + $d->sep + $d->okt + $d->nov + $d->des;
    $totaljan += $d->jan;
    $totalfeb += $d->feb;
    $totalmar += $d->mar;
    $totalapr += $d->apr;
    $totalmei += $d->mei;
    $totaljun += $d->jun;
    $totaljul += $d->jul;
    $totalagu += $d->agu;
    $totalsep += $d->sep;
    $totalokt += $d->okt;
    $totalnov += $d->nov;
    $totaldes += $d->des;
    $totalsaldoakhir += $saldoakhir;
    $totalsaldoawal += $d->saldoawal;
    @endphp
    <tr>
        <td align="center">{{ $loop->iteration }}</td>
        <td align="center">{{ $d->no_rekening }}</td>
        <td align="left">{{ $d->nama_lengkap }}</td>
        <td align="right">{{ number_format($d->saldoawal,'0','','.') }}</td>
        <td align="right">{{ number_format($d->jan,'0','','.') }}</td>
        <td align="right">{{ number_format($d->feb,'0','','.') }}</td>
        <td align="right">{{ number_format($d->mar,'0','','.') }}</td>
        <td align="right">{{ number_format($d->apr,'0','','.') }}</td>
        <td align="right">{{ number_format($d->mei,'0','','.') }}</td>
        <td align="right">{{ number_format($d->jun,'0','','.') }}</td>
        <td align="right">{{ number_format($d->jul,'0','','.') }}</td>
        <td align="right">{{ number_format($d->agu,'0','','.') }}</td>
        <td align="right">{{ number_format($d->sep,'0','','.') }}</td>
        <td align="right">{{ number_format($d->okt,'0','','.') }}</td>
        <td align="right">{{ number_format($d->nov,'0','','.') }}</td>
        <td align="right">{{ number_format($d->des,'0','','.') }}</td>
        <td align="right">{{ number_format($saldoakhir,'0','','.') }}</td>
    </tr>
    @endforeach
    <tr>
        <th colspan="3">TOTAL</th>
        <th style="text-align: right">{{ number_format($totalsaldoawal,'0','','.') }}</td>
        <th style="text-align: right">{{ number_format($totaljan,'0','','.') }}</th>
        <th style="text-align: right">{{ number_format($totalfeb,'0','','.') }}</th>
        <th style="text-align: right">{{ number_format($totalmar,'0','','.') }}</th>
        <th style="text-align: right">{{ number_format($totalapr,'0','','.') }}</th>
        <th style="text-align: right">{{ number_format($totalmei,'0','','.') }}</th>
        <th style="text-align: right">{{ number_format($totaljun,'0','','.') }}</th>
        <th style="text-align: right">{{ number_format($totaljul,'0','','.') }}</th>
        <th style="text-align: right">{{ number_format($totalagu,'0','','.') }}</th>
        <th style="text-align: right">{{ number_format($totalsep,'0','','.') }}</th>
        <th style="text-align: right">{{ number_format($totalokt,'0','','.') }}</th>
        <th style="text-align: right">{{ number_format($totalnov,'0','','.') }}</th>
        <th style="text-align: right">{{ number_format($totaldes,'0','','.') }}</th>
        <th style="text-align: right">{{ number_format($totalsaldoakhir,'0','','.') }}</th>
    </tr>
</table>
