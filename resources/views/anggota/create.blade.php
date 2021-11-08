@extends('layouts.midone')
@section('titlepage','Data Anggota')
@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Tambah Anggota</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/anggota">Anggota</a></li>
                            <li class="breadcrumb-item"><a href="/anggota">Tambah Anggota</a></li>
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
                    <form class="form" action="/anggota/store" method="POST">
                        @csrf
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12">
                                    <x-inputtext label="NIK" field="nik" icon="feather icon-credit-card" />
                                </div>
                                <div class="col-12">
                                    <x-inputtext label="Nama Lengkap" field="nama_lengkap" icon="feather icon-user" />
                                </div>
                                <div class="col-12">
                                    <x-inputtext label="Tempat Lahir" field="tempat_lahir" icon="feather icon-map" />
                                </div>
                                <div class="col-12">
                                    <x-inputtext label="Tanggal Lahir" field="tanggal_lahir"
                                        icon="feather icon-calendar" datepicker="true" />
                                </div>
                                <div class="col-12">
                                    <div class="form-group  @error('alamat') error @enderror"">
                                    <fieldset class=" form-label-group mb-0">
                                        <textarea autocomplete="off" data-length=100 class="form-control char-textarea"
                                            name="alamat" id="alamat" rows="3" placeholder="Alamat">
                                            {{old('alamat')}}
                                        </textarea>
                                        </fieldset>
                                        <small class="counter-value float-right"><span class="char-count">0</span> / 100
                                        </small>
                                        @error('alamat')
                                        <div class="help-block">
                                            <ul role="alert">
                                                <li>{{$message}}</li>
                                            </ul>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <x-inputtext label="No. HP" field="no_hp" icon="feather icon-phone" />
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
