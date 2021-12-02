@extends('layouts.midone')
@section('titlepage','Laporan Tabungan')
@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Laporan</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/laporantabungan">Tabungan</a>
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


        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">

                        <form action="/cetakbayartabungan" method="POST" target="_blank">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group  @error('jenis_tabungan') error @enderror">
                                        <select name="jenis_tabungan" id="jenis_tabungan" class="form-control">
                                            <option value="">Jenis Tabungan</option>
                                            @foreach ($jenistabungan as $d)
                                            <option @if (old('jenis_tabungan')==$d->kode_tabungan) selected @endif value="{{ $d->kode_tabungan }}">{{ $d->nama_tabungan }}</option>
                                            @endforeach
                                        </select>
                                        @error('jenis_tabungan')
                                        <div class="help-block">
                                            <ul role="alert">
                                                <li>{{ $message }}</li>
                                            </ul>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <x-inputtext label="Dari" icon="feather icon-calendar" field="dari" datepicker="true" />
                                        </div>
                                        <div class="col-6">
                                            <x-inputtext label="Sampai" icon="feather icon-calendar" field="sampai" datepicker="true" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <button type="submit" name="submit" class="btn btn-primary mr-1 mb-1"><i class="fa fa-print mr-1"></i>Cetak</button>
                                            <button type="submit" name="export" class="btn btn-outline-success mr-1 mb-1"><i class="fa fa-download mr-1"></i>Export Excel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>


                        <!-- DataTable ends -->
                    </div>
                </div>
                <!-- Data list view end -->
            </div>
        </div>
    </div>
</div>
@endsection
