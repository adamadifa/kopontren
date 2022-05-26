<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.3.0/paper.css">
<title>Rekap Pembiayaan</title>
<style>
    @page {
        size: A4 landscape;
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
<body class="A4 landscape">
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


        <table class="datatable3">
            <tr>
                <th>NO</th>
                <th>No. Anggota</th>
                <th>Nama Anggota</th>
                <th>Tgl Permohonan</th>
                <th>Pokok</th>
                <th>Pembiayaan</th>
                <th>Bagi Hasil</th>
                <th>Jangka Waktu</th>
                <th>Jenis Akad</th>
                <th>Status</th>
            </tr>
            @foreach ($pembiayaan as $d)

            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $d->no_anggota }}</td>
                <td>{{ $d->nama_lengkap }}</td>
                <td>{{ date("d-m-Y",strtotime($d->tgl_permohonan)) }}</td>
                <td align="right">{{ number_format($d->jumlah,'0','','.')  }}</td>
                <td align="right">{{ number_format($d->jumlah + ($d->jumlah * ($d->persentase/100)),'0','','.')  }}</td>
                <td align="right">{{ number_format(($d->jumlah * ($d->persentase/100)),'0','','.')  }}</td>
                <td>{{ $d->jangka_waktu }} Bulan</td>
                <td>{{ $d->nama_pembiayaan }}</td>
                <td>
                    @if (empty($d->sisacicilan))
                    <b style="color:green">LUNAS</b>
                    @else
                    {{ $d->sisacicilan }} x Cicilan
                    @endif
                </td>
            </tr>
            @endforeach
        </table>
    </section>
</body>
