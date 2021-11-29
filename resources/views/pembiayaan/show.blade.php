@extends('layouts.midone')
@section('titlepage', 'Detail')
@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Detail</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/pembiayaan">Pembiayaan</a></li>
                            <li class="breadcrumb-item"><a href="#">Detail</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <!-- page users view start -->
        <section class="">
            <div class="row">
                <!-- account start -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Data Anggota</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="users-view-image">
                                        <img src="{{ asset('app-assets/images/no photo.png') }}" class="users-avatar-shadow w-100 rounded mb-2 pr-2 ml-1" alt="avatar">
                                    </div>
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
                                <div class="col-md-4">
                                    <table class="table">
                                        <tr>
                                            <td class="font-weight-bold"><i class="feather icon-credit-card mr-1"></i>No
                                                Akad
                                            </td>
                                            <td>{{ $anggota->no_akad }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold"><i class="feather icon-book mr-1"></i>Jenis
                                                Pembiayaan
                                            </td>
                                            <td>{{$anggota->nama_pembiayaan}}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold"><i class="feather icon-book mr-1"></i>Sisa Tagihan
                                            </td>
                                            <td style="text-align: right; font-weight:bold">
                                            </td>
                                        </tr>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- account end -->
            <div class="row match-height">
                <div class="col-lg-4 col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h4>Data Pembiayaan</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">

                                <table class="table">
                                    <tr>
                                        <td>No. Akad</td>
                                        <td>{{ $anggota->no_akad; }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Permohonan</td>
                                        <td>{{ date("d-m-Y",strtotime($anggota->tgl_permohonan) )}}</td>
                                    </tr>
                                    <tr>
                                        <td>Jenis Pembiayaan</td>
                                        <td>{{ $anggota->nama_pembiayaan}}</td>
                                    </tr>
                                    <tr>
                                        <td>Persentase</td>
                                        <td>{{ $anggota->persentase }}%</td>
                                    </tr>
                                    <tr>
                                        <td>Jumlah</td>
                                        <td align="right">{{ number_format($anggota->jumlah,'0','','.') }}</td>
                                    </tr>
                                    <tr>
                                        @php
                                        $tagihan = $anggota->jumlah + (($anggota->persentase/100)*$anggota->jumlah);
                                        @endphp
                                        <td>Tagihan</td>
                                        <td align="right">{{ number_format($tagihan,'0','','.') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Jangka Waktu</td>
                                        <td>{{ $anggota->jangka_waktu }} Bulan</td>
                                    </tr>
                                    <tr>
                                        <td>Keperluan</td>
                                        <td>{{ $anggota->keperluan }}</td>
                                    </tr>
                                    <tr>
                                        <td>Jaminan</td>
                                        <td>{{ $anggota->jaminan }}</td>
                                    </tr>
                                </table>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th colspan="2">Data Dokumen</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td>KTP Pemohon</td>
                                        <td>
                                            @if ($anggota->ktp_pemohon == 1)
                                            <span class="badge bg-success"><i class="fa fa-check"></i></span>
                                            @else
                                            <span class="badge bg-warning"><i class="fa fa-history"></i></span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>KTP Pasangan</td>
                                        <td>
                                            @if ($anggota->ktp_pasangan == 1)
                                            <span class="badge bg-success"><i class="fa fa-check"></i></span>
                                            @else
                                            <span class="badge bg-warning"><i class="fa fa-history"></i></span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Kartu Keluarga</td>
                                        <td>
                                            @if ($anggota->kartu_keluarga == 1)
                                            <span class="badge bg-success"><i class="fa fa-check"></i></span>
                                            @else
                                            <span class="badge bg-warning"><i class="fa fa-history"></i></span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Struk Gaji</td>
                                        <td>
                                            @if ($anggota->struk_gaji == 1)
                                            <span class="badge bg-success"><i class="fa fa-check"></i></span>
                                            @else
                                            <span class="badge bg-warning"><i class="fa fa-history"></i></span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h4>Rencana Pembayaran</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <table class="table table-bordered table-striped" style="width:100% !important">
                                    <thead>
                                        <th>NO</th>
                                        <th>JATUH TEMPO</th>
                                        <th>JUMLAH</th>
                                        <th>BAYAR</th>
                                        <th>TUNGGAKAN</th>
                                    </thead>
                                    <tbody>
                                        @php
                                        $total = 0;
                                        @endphp
                                        @foreach ($rencanabayar as $d)
                                        @php
                                        $tagihan = $d->jumlah - $d->bayar;
                                        $total += $tagihan;
                                        @endphp
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>05-{{ $d->bulan }}-{{ $d->tahun }}</td>
                                            <td align="right">{{ number_format($d->jumlah,'0','','.') }}</td>
                                            <td align="right">{{ number_format($d->bayar,'0','','.') }}</td>
                                            <td align="right">{{ number_format($d->jumlah-$d->bayar,'0','','.') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <th colspan="4">TOTAL</th>
                                        <th style="text-align: right">{{ number_format($total,'0','','.') }}</th>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h4>Histori Pembayaran</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <a href="#" id="bayar" class="btn btn-primary mb-2"><i class="fa fa-money mr-1"></i>Bayar</a>
                                <table class="table table-bordered table-striped" style="width:100% !important">
                                    <thead>
                                        <th>NO. TRANSAKSI</th>
                                        <th>TANGGAL</th>
                                        <th>#</th>
                                        <th>JUMLAH</th>
                                        <th>AKSI</th>
                                    </thead>
                                    <tbody>
                                        @php
                                        $i = 1;
                                        @endphp
                                        @foreach ($histori as $d)
                                        <tr>
                                            <td>{{ $d->no_transaksi }}</td>
                                            <td>{{ date("d/m/y",strtotime($d->tgl_transaksi)) }}</td>
                                            <td class="text-center">{{ $d->cicilan_ke }}</td>
                                            <td align="right">{{ number_format($d->jumlah,'0','','.') }}</td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <a href="/pembiayaan/{{ Crypt::encrypt($d->no_transaksi) }}/cetakkwitansi" class="primary" target="_blank"><i class="feather icon-printer"></i></a>
                                                    @if ($i==$totalrow)
                                                    <form method="POST" class="deleteform" action="/pembiayaan/{{ Crypt::encrypt($d->no_transaksi) }}/deletebayar">
                                                        @csrf
                                                        @method('DELETE')
                                                        <a class="delete-confirm ml-1">
                                                            <i class="feather icon-trash danger"></i>
                                                        </a>
                                                    </form>
                                                    @endif

                                                </div>
                                            </td>
                                        </tr>
                                        @php
                                        $i++;
                                        @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<div class="modal fade" id="modalbayar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="frmbayar" action="/pembiayaan/bayar" class="validate-form">
                    @csrf
                    <input type="hidden" name="no_akad" id="no_akad" value="{{ \Crypt::encrypt($anggota->no_akad) }}">
                    <div class="row">
                        <div class="col-12">
                            <x-inputtext label="No. Transaksi (Auto)" field="no_transaksi" icon="feather icon-maximize" readonly="true" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <x-inputtext label="Tanggal Transaksi" field="tgl_transaksi" icon="feather icon-calendar" datepicker="true" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <x-inputtext label="Cicilan Ke" field="cicilan_ke" icon="feather icon-inbox" value="{{ $cicilanke->cicilan_ke }}" readonly="true" />
                        </div>
                        <div class="col-9">
                            <x-inputtext label="Jumlah" field="jumlah" value="{{ number_format($cicilanke->jumlah,'0','','.') }}" readonly="true" icon="feather icon-inbox" />
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-12 mb-2">
                            <textarea name="berita" placeholder="Berita" class="form-control" id="berita" cols="30" rows="5"></textarea>
                        </div>
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
<script>
    $(function() {
        $("#bayar").click(function(e) {
            e.preventDefault();
            $("#modalbayar").modal("show");
            $("#exampleModalCenterTitle").text("Input Pembayaran");
        });

        $('.delete-confirm').on('click', function(event) {
            event.preventDefault();
            const url = $(this).attr('href');
            swal({
                title: 'Anda Yakin?'
                , text: 'Data ini akan didelete secara permanen!'
                , icon: 'warning'
                , buttons: ["Cancel", "Yes!"]
            , }).then(function(value) {
                if (value) {
                    $(".deleteform").submit();
                }
            });
        });

        $("#frmbayar").submit(function() {
            var no_akad = $("#no_akad").val();
            var cicilan_ke = $("#cicilan_ke").val();
            var jumlah = $("#jumlah").val();
            var tgl_transaksi = $("#tgl_transaksi").val();
            //alert('test');
            if (no_akad == "") {
                swal("Oops", "No. Akad Harus Diisi !", "warning");
                return false;
            } else if (cicilan_ke == "") {
                swal("Oops", "Cicilan Ke Harus Diisi !", "warning");
                return false;
            } else if (jumlah == "") {
                swal("Oops", "Jumlah Harus Diisi !", "warning");
                return false;
            } else if (tgl_transaksi == "") {
                swal("Oops", "Tanggal Harus Diisi !", "warning");
                return false;
            }
        });
    });

</script>
@endpush
