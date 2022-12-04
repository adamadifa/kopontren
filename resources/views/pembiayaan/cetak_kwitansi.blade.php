<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.3.0/paper.css">
<style>
    @page {
        size: A4 landscape
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
        border: 2px solid #D6DDE6;
        border-collapse: collapse;
        /* font-size: 10px; */
        /*float:left; */
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        width: 100%;


    }

    .datatable3 td {
        border: 1px solid #000000;
        padding: 6px;
        font-size: 10px;

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
<body class="A5 landscape">


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
                    <h1 class="judul2">KUITANSI<br>{{ $transaksi->no_transaksi }}</h1>
                </td>
            </tr>
        </table>
        <table style="width: 100%" border="0">
            <tr>
                <td>Telah Terima dari</td>
                <td>:</td>
                <td>{{ $transaksi->no_anggota }} - {{ $transaksi->nama_lengkap }}</td>
            </tr>
            <tr>
                <td>Jumlah Uang</td>
                <td>:</td>
                <td>Rp. {{ number_format($transaksi->jumlah,'0','','.') }}</td>
            </tr>
            <tr>
                <td>Terbilang</td>
                <td>:</td>
                <td>{{ ucwords(terbilang($transaksi->jumlah)) }} Rupiah</td>
            </tr>
            <tr>
                <td>Untuk Pembayaran</td>
                <td>:</td>
                <td>Pembayaran Cicilan Ke {{ $transaksi->cicilan_ke }} No. Akad {{ $transaksi->no_akad }} - {{ $transaksi->keperluan }}</td>
            </tr>
        </table>
        <br>
        <br>
        <br>
        <table style="width: 100%">
            <tr>
                <td align="center"><br>Penyetor</td>
                <td align="center">
                    Ciamis, {{ date("d M Y") }}<br>
                    Petugas,
                </td>
            </tr>
            <tr>
                <td style="height: 50px"></td>
                <td></td>
            </tr>
            <tr>
                <td align="center">{{ $transaksi->nama_lengkap }}</td>
                <td align="center">{{ Auth::user()->name  }}</td>
            </tr>
        </table>
    </section>
</body>
