@extends('layouts.midone')
@section('titlepage','Data Anggota')
@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Detail Anggota</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/anggota">Anggota</a></li>
                            <li class="breadcrumb-item"><a href="#">Detail Anggota</a></li>
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
                                    <img src="{{asset('app-assets/images/no photo.png')}}"
                                        class="users-avatar-shadow w-100 rounded mb-2 pr-2 ml-1" alt="avatar">
                                </div>
                                <div class="col-12 col-sm-9 col-md-6 col-lg-5">
                                    <table>
                                        <tr>
                                            <td class="font-weight-bold">No Anggota</td>
                                            <td>{{$anggota->no_anggota}}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">NIK</td>
                                            <td>{{$anggota->nik}}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Nama Lengkap</td>
                                            <td>{{$anggota->nama_lengkap}}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-12 col-md-12 col-lg-5">
                                    <table class="ml-0 ml-sm-0 ml-lg-0">
                                        <tr>
                                            <td class="font-weight-bold">TTL</td>
                                            <td>{{$anggota->tempat_lahir}}, {{date("d M
                                                Y",strtotime($anggota->tanggal_lahir))}}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">No HP</td>
                                            <td>{{$anggota->no_hp}}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Alamat</td>
                                            <td>{{$anggota->alamat}}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- account end -->
                <!-- information start -->
                <div class="col-md-6 col-12 ">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title mb-2">Saldo Simpanan</div>
                        </div>
                        <div class="card-body">

                        </div>
                    </div>
                </div>
                <!-- information start -->
                <!-- social links end -->
                <div class="col-md-6 col-12 ">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title mb-2">Saldo Tabungan</div>
                        </div>
                        <div class="card-body">

                        </div>
                    </div>
                </div>
                <!-- social links end -->
                <!-- permissions start -->

                <!-- permissions end -->
            </div>
        </section>
        <!-- page users view end -->

    </div>
</div>
@endsection
