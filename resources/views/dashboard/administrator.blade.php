@extends('layouts.midone')
@section('titlepage', 'Data Pembiayaan')
@section('content')
<div class="content-wrapper">
    <div class="content-header row">
    </div>
    <div class="content-body">
        <!-- Dashboard Analytics Start -->
        <section id="dashboard-analytics">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div class="card bg-analytics text-white">
                        <div class="card-content">
                            <div class="card-body text-center">
                                <img src="{{asset('app-assets/images/elements/decore-left.png')}}" class="img-left" alt="card-img-left">
                                <img src="{{asset('app-assets/images/elements/decore-right.png')}}" class="img-right" alt="card-img-right">
                                <div class="avatar avatar-xl bg-primary shadow mt-0">
                                    <div class="avatar-content">
                                        <i class="feather icon-award white font-large-1"></i>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <h1 class="mb-2 text-white">Selamat Datang, {{ Auth::user()->name; }}</h1>
                                    <p class="m-auto w-75">Di Halaman <strong>Utama</strong> Aplikasi Kopontren Tsarwah</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-header d-flex align-items-start pb-0">
                                    <div>
                                        <h2 class="text-bold-700 mb-0">{{ $jmlanggota }}</h2>
                                        <p>Data Anggota</p>
                                    </div>
                                    <div class="avatar bg-rgba-info p-50 m-0">
                                        <div class="avatar-content">
                                            <i class="feather icon-users text-info font-medium-5"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-header d-flex align-items-start pb-0">
                                    <div>
                                        <h2 class="text-bold-700 mb-0">{{ number_format($simpanan->jmlsetoran,'0','','.') }}</h2>
                                        <p>Penerimaan Simpanan Bulan Ini</p>
                                    </div>
                                    <div class="avatar bg-rgba-success p-50 m-0">
                                        <div class="avatar-content">
                                            <i class="feather icon-corner-down-left text-success font-medium-5"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-header d-flex align-items-start pb-0">
                                    <div>
                                        <h2 class="text-bold-700 mb-0">{{ number_format($simpanan->jmlpenarikan,'0','','.') }}</h2>
                                        <p>Penarikan Simpanan Bulan Ini</p>
                                    </div>
                                    <div class="avatar bg-rgba-danger p-50 m-0">
                                        <div class="avatar-content">
                                            <i class="feather icon-corner-down-right text-danger font-medium-5"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-header d-flex align-items-start pb-0">
                                    <div>
                                        <h2 class="text-bold-700 mb-0">{{ number_format($saldosimpanan->pokok,'0','','.') }}</h2>
                                        <p>Saldo Simpanan Pokok</p>
                                    </div>
                                    <div class="avatar bg-rgba-success p-50 m-0">
                                        <div class="avatar-content">
                                            <i class="feather icon-book text-success font-medium-5"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-header d-flex align-items-start pb-0">
                                    <div>
                                        <h2 class="text-bold-700 mb-0">{{ number_format($saldosimpanan->wajib,'0','','.') }}</h2>
                                        <p>Saldo Simpanan Wajib</p>
                                    </div>
                                    <div class="avatar bg-rgba-warning p-50 m-0">
                                        <div class="avatar-content">
                                            <i class="feather icon-book text-warning font-medium-5"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-header d-flex align-items-start pb-0">
                                    <div>
                                        <h2 class="text-bold-700 mb-0">{{ number_format($saldosimpanan->sukarela,'0','','.') }}</h2>
                                        <p>Saldo Simpanan Sukarela</p>
                                    </div>
                                    <div class="avatar bg-rgba-info p-50 m-0">
                                        <div class="avatar-content">
                                            <i class="feather icon-book text-info font-medium-5"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
</div>
@endsection
