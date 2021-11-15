@extends('layouts.midone')
@section('titlepage', 'Edit Jenis Pembiayaan')
@section('content')
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">Edit Jenis Pembiayaan</h2>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/jenispembiayaan">Jenis Pembiayaan</a></li>
                                <li class="breadcrumb-item"><a href="#">Edit</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form class="form"
                            action="/jenispembiayaan/{{ \Crypt::encrypt($jenispembiayaan->kode_pembiayaan) }}/update"
                            method="POST">
                            @csrf
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <x-inputtext label="Jenis Pembiayaan" field="nama_pembiayaan"
                                            icon="feather icon-book" value="{{ $jenispembiayaan->nama_pembiayaan }}" />
                                    </div>
                                    <div class="col-4">
                                        <x-inputtext label="Persentase" field="persentase" icon="feather icon-book"
                                            value="{{ $jenispembiayaan->persentase }}" />
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
                                        <button type="reset" class="btn btn-outline-warning mr-1 mb-1">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
