@extends('layouts.midone')
@section('titlepage', 'Detail Simpanan')
@section('content')
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Detail Simpanan</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/simpanan">Simpanan</a></li>
                                <li class="breadcrumb-item"><a href="#">Detail Simpanan</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <!-- page users view start -->
            <section class="page-users-view">
                <div class="row">
                    <!-- account start -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Anggota</div>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    <div class="users-view-image">
                                        <img src="{{ asset('app-assets/images/no photo.png') }}"
                                            class="users-avatar-shadow w-100 rounded mb-2 pr-2 ml-1" alt="avatar">
                                    </div>

                                    <div class="col-md-3">
                                        <table class="table">
                                            <tr>
                                                <td class="font-weight-bold"><i class="fa fa-barcode mr-1"></i>No Anggota
                                                </td>
                                                <td>{{ $anggota->no_anggota }}</td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold"><i class="feather icon-credit-card mr-1"></i>
                                                    NIK</td>
                                                <td>{{ $anggota->nik }}</td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold"><i class="feather icon-user mr-1"></i>Nama
                                                    Lengkap</td>
                                                <td>{{ $anggota->nama_lengkap }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-3">
                                        <table class="table">
                                            <tr>
                                                <td class="font-weight-bold"><i class="feather icon-calendar mr-1"></i>TTL
                                                </td>
                                                <td>{{ $anggota->tempat_lahir }},
                                                    {{ date(
                                                        "d M
                                                                                                                                                        Y",
                                                        strtotime($anggota->tanggal_lahir),
                                                    ) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold"><i class="feather icon-phone mr-1"></i>No HP
                                                </td>
                                                <td>{{ $anggota->no_hp }}</td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold"><i class="feather icon-map mr-1"></i>Alamat
                                                </td>
                                                <td>{{ $anggota->alamat }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-3">

                                        <table class="table ">
                                            @php
                                                $total = 0;
                                            @endphp
                                            @foreach ($saldosimpanan as $d)
                                                @php
                                                    $total += $d->jumlah;
                                                @endphp
                                                <tr>
                                                    <td class="font-weight-bold"> {{ $d->kode_simpanan }} -
                                                        {{ $d->nama_simpanan }}
                                                    </td>
                                                    <td class="text-right">
                                                        {{ number_format($d->jumlah, '0', '', '.') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- account end -->
                <div class="row">
                    <div class="col-md-6">
                        <a href="#" id="inputsetoran" class="btn btn-relief-primary waves-effect waves-light btn-block"><i
                                class="feather icon-corner-down-right mr-1"></i> Setoran</a>
                    </div>
                    <div class="col-md-6">
                        <a href="#" id="inputpenarikan" class="btn btn-relief-danger waves-effect waves-light btn-block"><i
                                class="feather icon-corner-down-left mr-1"></i> Penarikan</a>
                    </div>
                </div>
        </div>
        <!-- information start -->
        <div class="row">
            <div class="col-md-12 col-12 mt-2">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title mb-2"><i class="feather icon-folder mr-1"></i>Data Mutasi</div>
                    </div>
                    <div class="card-body">
                        <form action="">
                            <div class="row">
                                <div class="col-md-5">
                                    <x-inputtext label="Dari" field="dari" icon="feather icon-calendar" datepicker="true"
                                        value="{{ Request('dari') }}" />
                                </div>
                                <div class="col-md-5">
                                    <x-inputtext label="Sampai" field="sampai" icon="feather icon-calendar"
                                        datepicker="true" value="{{ Request('sampai') }}" />
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-primary"><i class="feather icon-search mr2"></i>
                                        Tampilkan</button>
                                </div>
                            </div>
                        </form>
                        @include('layouts.notification')
                        @if ($lastdata != null)
                            @if ($lastdata->jenis_transaksi == 'S')
                                @php
                                    $setor = $lastdata->jumlah;
                                    $tarik = 0;

                                @endphp
                            @else
                                @php
                                    $setor = 0;
                                    $tarik = $d->jumlah;
                                @endphp
                            @endif
                            @php
                                $saldoawal = $lastdata->saldo;
                            @endphp
                        @else
                            @php
                                $saldoawal = 0;
                            @endphp
                        @endif
                        <input type="hidden" id="ceksaldo" value="{{ $saldoawal }}">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>NO TRANSAKSI</th>
                                    <th>TANGGAL</th>
                                    <th>JENIS SIMPANAN</th>
                                    <th>SETOR</th>
                                    <th>TARIK</th>
                                    <th>SALDO</th>
                                    <th>BERITA</th>
                                    <th>PETUGAS</th>
                                    <th></th>

                                </tr>
                                <tr>
                                    <th colspan="5" style="text-align: center">SALDO AWAL</th>
                                    <th style="text-align: right" id="saldoawal">
                                        {{ number_format($saldoawal, '0', '', '.') }}
                                    </th>
                                    <th colspan="3"></th>
                                </tr>
                            </thead>
                            <tbody>

                                @php

                                    $i = 1;
                                @endphp
                                @foreach ($datasimpanan as $d)
                                    @if ($d->jenis_transaksi == 'S')
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

                                    @if ($d->kode_simpanan == '001')
                                        @php
                                            $bg = 'bg-theme-1';
                                        @endphp
                                    @elseif($d->kode_simpanan=="002")
                                        @php
                                            $bg = 'bg-theme-29';
                                        @endphp
                                    @elseif($d->kode_simpanan=="003")
                                        @php
                                            $bg = 'bg-orange-400';
                                        @endphp
                                    @endif

                                    @if ($i == 1)
                                        @php
                                            $id1 = 'saldo';
                                            $id2 = 'setor';
                                            $id3 = 'tarik';
                                        @endphp
                                    @else
                                        @php
                                            $id1 = '';
                                            $id2 = '';
                                            $id3 = '';
                                        @endphp
                                    @endif
                                    <tr>
                                        <td class="text-center">{{ $d->no_transaksi }}</td>
                                        <td class="text-center">{{ date('d-m-Y', strtotime($d->tgl_transaksi)) }}</td>
                                        <td> {{ $d->kode_simpanan }} - {{ $d->nama_simpanan }}</td>
                                        <td class="text-right success" id="{{ $id2 }}">
                                            {{ number_format($setor, '0', '', '.') }}
                                        </td>
                                        <td class="text-right danger" id="{{ $id3 }}">
                                            {{ number_format($tarik, '0', '', '.') }}
                                        </td>
                                        <td class="text-right" id="{{ $id1 }}" style="font-weight: bold">
                                            {{ number_format($d->saldo, '0', '', '.') }}
                                        </td>
                                        <td class="text-center">
                                            @if (!empty($d->berita))
                                                {{ $d->berita }}
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $d->name }}</td>
                                        <td>
                                            @if ($i == $totalrow)
                                                <div class="flex justify-center items-center">
                                                    <form method="POST" class="deleteform"
                                                        action="/simpanan/{{ Crypt::encrypt($d->no_transaksi) }}/delete">
                                                        @csrf
                                                        @method('DELETE')
                                                        <a class="delete-confirm"><i
                                                                class="feather icon-trash danger"></i></a>
                                                    </form>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                    @php
                                        $i = $i + 1;
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                        {{ $datasimpanan->links('vendor.pagination.vuexy') }}
                    </div>
                </div>
            </div>
        </div>
        <!-- information start -->
    </div>

    </section>
    <!-- page users view end -->
    </div>
    </div>
    <div class="modal fade" id="modalsetoran" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="frmSimpanan" action="/simpanan/store" class="validate-form">
                        @csrf
                        <input type="hidden" name="no_anggota" id="no_anggota"
                            value="{{ \Crypt::encrypt($anggota->no_anggota) }}">
                        <input type="hidden" name="jenis_transaksi" id="jenis_transaksi">
                        <div class="col-12">
                            <x-inputtext label="No. Transaksi (Auto)" field="no_transaksi" icon="feather icon-maximize" />
                        </div>
                        <div class="col-12">
                            <x-inputtext label="Tanggal Transaksi" field="tgl_transaksi" icon="feather icon-calendar"
                                datepicker="true" />
                        </div>
                        <div class="col-12 mb-2">
                            <select class="form-control" name="kode_simpanan" id="kode_simpanan">
                                <option value="">Jenis Simpanan</option>
                                @foreach ($simpanan as $d)
                                    <option value="{{ $d->kode_simpanan }}">{{ $d->kode_simpanan }} -
                                        {{ $d->nama_simpanan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <x-inputtext label="Jumlah" field="jumlah" icon="feather icon-inbox" />
                        </div>
                        <div class="col-12 mb-2">
                            <textarea name="berita" placeholder="Berita" class="form-control" id="berita" cols="30"
                                rows="5"></textarea>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <button type="button" data-dismiss="modal" class="btn btn-danger">Batalkan</button>
                            </div>
                        </div>
                    </form>
                </div>


            </div>
        </div>
    </div>
@endsection
@push('myscript')
    <script type="text/javascript">
        var jumlah = document.getElementById('jumlah');
        jumlah.addEventListener('keyup', function(e) {
            // tambahkan 'Rp.' pada saat form di ketik
            // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
            jumlah.value = formatRupiah(this.value, '');
        });

        /* Fungsi formatRupiah */
        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? rupiah : '');
        }
    </script>
    <script>
        $(function() {
            function addCommas(nStr) {
                nStr += '';
                x = nStr.split('.');
                x1 = x[0];
                x2 = x.length > 1 ? '.' + x[1] : '';
                var rgx = /(\d+)(\d{3})/;
                while (rgx.test(x1)) {
                    x1 = x1.replace(rgx, '$1' + '.' + '$2');
                }
                return x1 + x2;
            }

            function loadsaldo() {
                var saldo = $("#saldo").text();
                var setor = $("#setor").text();
                var tarik = $("#tarik").text();
                var sa = $("#ceksaldo").val();
                var saldonumber = saldo.replace(/\./g, "");
                var setornumber = setor.replace(/\./g, "");
                var tariknumber = tarik.replace(/\./g, "");
                var saldoawal = parseInt(saldonumber) + parseInt(tariknumber) - parseInt(setornumber);
                console.log(sa);
                if (sa == 0) {
                    $("#saldoawal").text(addCommas(saldoawal));
                }

            }
            loadsaldo();
            $("#inputsetoran").click(function(e) {
                e.preventDefault();
                $("#modalsetoran").modal("show");
                $("#jenis_transaksi").val("S");
                $("#exampleModalCenterTitle").text("Input Setoran");

            });

            $("#inputpenarikan").click(function(e) {
                e.preventDefault();
                $("#modalsetoran").modal("show");
                $("#jenis_transaksi").val("T");
                $("#exampleModalCenterTitle").text("Input Penarikan");
            });

            $("#frmSimpanan").submit(function() {
                var kode_simpanan = $("#kode_simpanan").val();
                var jumlah = $("#jumlah").val();
                var tgl_transaksi = $("#tgl_transaksi").val();
                //alert('test');
                if (kode_simpanan == "") {
                    swal("Oops", "Kode Simpanan Harus Diisi !", "warning");
                    return false;
                } else if (jumlah == "") {
                    swal("Oops", "Jumlah Harus Diisi !", "warning");
                    return false;
                } else if (tgl_transaksi == "") {
                    swal("Oops", "Tanggal Harus Diisi !", "warning");
                    return false;
                }
            });

            $('.delete-confirm').on('click', function(event) {
                event.preventDefault();
                const url = $(this).attr('href');
                swal({
                    title: 'Anda Yakin?',
                    text: 'Data ini akan didelete secara permanen!',
                    icon: 'warning',
                    buttons: ["Cancel", "Yes!"],
                }).then(function(value) {
                    if (value) {
                        $(".deleteform").submit();
                    }
                });
            });
        });
    </script>
@endpush
