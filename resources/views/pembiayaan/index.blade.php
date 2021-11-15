@extends('layouts.midone')
@section('titlepage', 'Data Tabungan Anggota')
@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Data Pembiayaan</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/pembiayaan">Pembiayaan</a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <!-- Data list view starts -->
        <!-- DataTable starts -->
        @include('layouts.notification')
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-12">
                        <a href="/pembiayaan/create" id="tambahpembiayaan" class="btn btn-primary"><i class="feather icon-file-text mr-2"></i>Tambah Pembiayaan</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <form action="/pembiayaan">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class=" form-label-group position-relative has-icon-left">
                                        <input type="text" value="{{ Request('dari') }}" id="dari" name="dari" class="form-control pickadate-months-year picker__input" placeholder="Dari">
                                        <div class="form-control-position">
                                            <i class="feather icon-calendar"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class=" form-label-group position-relative has-icon-left">
                                        <input type="text" value="{{ Request('sampai') }}" id="sampai" name="sampai" class="form-control pickadate-months-year picker__input" placeholder="Sampai" datepicker="true">
                                        <div class="form-control-position">
                                            <i class="feather icon-calendar"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class=" form-label-group position-relative has-icon-left">
                                        <input type="text" value="{{ Request('nama') }}" id="nama" name="nama" class="form-control" placeholder="Nama Anggota">
                                        <div class="form-control-position">
                                            <i class="feather icon-user"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>NO AKAD</th>
                                <th>TANGGAL</th>
                                <th class="text-center">NO ANGGOTA</th>
                                <th>NAMA LENGKAP</th>
                                <th>JENIS PEMBIAYAAN</th>
                                <th>JUMLAH PEMBIAYAAN</th>
                                <th>STATUS</th>
                                <th>ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>

                </div>

                <!-- DataTable ends -->
            </div>
        </div>
        <!-- Data list view end -->
    </div>
</div>
@endsection
