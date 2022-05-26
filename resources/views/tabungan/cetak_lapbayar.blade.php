<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.3.0/paper.css">
<title>Laporan Pembayaran Tabungan</title>
<style>
    @page {
        size: A4;
        margin: 10mm 5mm 10mm 5mm;

    }

    .sheet {
        overflow: visible;
        height: auto !important;
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
<body class="A4">
    <section class="sheet padding-10mm">
        <table style="width:100%">
            <tr>
                <td style="width:10%">
                    <img src="{{ URL::to('/')}}/dist/images/logo.png" alt="" width="100px" height="80px">
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
        <table style="width: 100%" border="0">
            <tr>
                <td style="text-align: center">
                    <h1 class="judul2">DATA SETORAN {{ strtoupper($tabungan->nama_tabungan) }}</h1>
                </td>
            </tr>
        </table>

        <table class="datatable3">
            <tr>
                <th>NO</th>
                <th>No. Bukti</th>
                <th>Tgl Transaksi</th>
                <th>No. Rekening</th>
                <th>Nama Anggota</th>
                <th>Setor</th>
                <th>Tarik</th>
                <th>Petugas</th>
            </tr>
            @php
            $totalsetor = 0;
            $totaltarik = 0;
            @endphp
            @foreach ($transaksi as $d)
            @if ($d->jenis_transaksi=="S")
            @php
            $setor = $d->jumlah;
            $tarik = 0;
            @endphp
            @else
            @php
            $setor = 0;
            $tarik = $d->jumlah;
            @endphp
            @endif
            @php
            $totalsetor += $setor;
            $totaltarik += $tarik;
            @endphp
            <tr>
                <td align="center">{{ $loop->iteration }}</td>
                <td align="center">{{ $d->no_transaksi }}</td>
                <td align="center">{{ date("d-m-Y",strtotime($d->tgl_transaksi)) }}</td>
                <td align="center">{{ $d->no_rekening }}</td>
                <td align="">{{ $d->nama_lengkap }}</td>
                <td align="right">{{ number_format($setor,'0','','.') }}</td>
                <td align="right">{{ number_format($tarik,'0','','.') }}</td>
                <td align="center">{{ $d->id_petugas }}</td>
            </tr>
            @endforeach
            <tr>
                <th align="center" colspan="5">TOTAL</th>
                <td align="right">{{ number_format($totalsetor,'0','','.') }}</td>
                <td align="right">{{ number_format($totaltarik,'0','','.') }}</td>
                <td></td>
            </tr>
        </table>
    </section>

</body>
