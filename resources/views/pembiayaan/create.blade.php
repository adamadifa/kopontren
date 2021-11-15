@extends('layouts.midone')
@section('titlepage', 'Data Anggota')
@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Input Pembiayaan</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/pembiayaan">Pembiayaan</a></li>
                            <li class="breadcrumb-item"><a href="#">Input Pembiayaan</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="content-body">
    <form class="form" action="/anggota/store" method="POST">
        <div class="col-md-12">

            <div class="row">
                <div class="col-md-6 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Data Diri Anggota</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <x-inputtext label="Nomor Identitas" field="nik" icon="feather icon-credit-card" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <x-inputtext label="Nama Lengkap" field="nama_lengkap" icon="feather icon-user" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <x-inputtext label="Tempat Lahir" field="tempat_lahir" icon="feather icon-map" />
                                        </div>
                                        <div class="col-6">
                                            <x-inputtext label="Tanggal Lahir" field="tanggal_lahir" icon="feather icon-calendar" datepicker="true" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group  @error('jenis_kelamin') error @enderror">
                                                <select name="jenis_kelamin" id="" class="form-control">
                                                    <option value="">Jenis Kelamin</option>
                                                    <option @if (old('jenis_kelamin')=='L' ) selected @endif value="L">Laki - Laki</option>
                                                    <option @if (old('jenis_kelamin')=='P' ) selected @endif value="P">Perempuan</option>
                                                </select>
                                                @error('jenis_kelamin')
                                                <div class="help-block">
                                                    <ul role="alert">
                                                        <li>{{ $message }}</li>
                                                    </ul>
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group  @error('pendidikan_terakhir') error @enderror">
                                                <select name="pendidikan_terakhir" id="pendidikan_terakhir" class="form-control">
                                                    <option value="">Pendidikan Terakhir</option>
                                                    <option {{ old('pendidikan_terakhir') == 'SD' ? 'selected' : '' }} value="SD">
                                                        SD
                                                    </option>
                                                    <option {{ old('pendidikan_terakhir') == 'SMP' ? 'selected' : '' }} value="SMP">
                                                        SMP
                                                    </option>
                                                    <option {{ old('pendidikan_terakhir') == 'SMA' ? 'selected' : '' }} value="SMA">
                                                        SMA
                                                    </option>
                                                    <option {{ old('pendidikan_terakhir') == 'D3' ? 'selected' : '' }} value="D3">
                                                        D3
                                                    </option>
                                                    <option {{ old('pendidikan_terakhir') == 'S1' ? 'selected' : '' }} value="S1">
                                                        S1
                                                    </option>
                                                    <option {{ old('pendidikan_terakhir') == 'S2' ? 'selected' : '' }} value="S2">
                                                        S2
                                                    </option>
                                                </select>
                                                @error('pendidikan_terakhir')
                                                <div class="help-block">
                                                    <ul role="alert">
                                                        <li>{{ $message }}</li>
                                                    </ul>
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group @error('status_pernikahan') error @enderror">
                                                <select name="status_pernikahan" id="status_pernikahan" class="form-control">
                                                    <option value="">Status Perkawinan</option>
                                                    <option {{ old('status_pernikahan') == 'M' ? 'selected' : '' }} value="M">
                                                        Menikah
                                                    </option>
                                                    <option {{ old('status_pernikahan') == 'BM' ? 'selected' : '' }} value="BM">
                                                        Belum
                                                        Menikah
                                                    </option>
                                                    <option {{ old('status_pernikahan') == 'JD' ? 'selected' : '' }} value="JD">
                                                        Janda/Duda
                                                    </option>
                                                </select>
                                                @error('status_pernikahan')
                                                <div class="help-block">
                                                    <ul role="alert">
                                                        <li>{{ $message }}</li>
                                                    </ul>
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <x-inputtext label="Jumlah Tanggungan" field="jml_tanggungan" icon="feather icon-users" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <x-inputtext label="Nama Pasangan" field="nama_pasangan" icon="feather icon-user" />
                                        </div>
                                        <div class="col-6">
                                            <x-inputtext label="Pekerjaan Pasangan" field="pekerjaan_pasangan" icon="feather icon-anchor" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <x-inputtext label="Nama Ibu Kandung" field="nama_ibu" icon="feather icon-user" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <x-inputtext label="Nama Saudara Tidak Serumah" field="nama_saudara" icon="feather icon-user" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <x-inputtext label="No. HP" field="no_hp" icon="feather icon-phone" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Data Alamat</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group  @error('alamat') error @enderror">
                                            <fieldset class="form-label-group mb-0">
                                                <textarea autocomplete="off" data-length=100 class="form-control char-textarea" name="alamat" id="alamat" rows="3" placeholder="Alamat Sesuai KTP">{{ old('alamat') }}</textarea>
                                            </fieldset>
                                            <small class="counter-value float-right"><span class="char-count">0</span> /
                                                100
                                            </small>
                                            @error('alamat')
                                            <div class="help-block">
                                                <ul role="alert">
                                                    <li>{{ $message }}</li>
                                                </ul>
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group  @error('id_propinsi') error @enderror">
                                            <select name="id_propinsi" id="id_propinsi" class="form-control">
                                                <option value="">Propinsi</option>
                                                @foreach ($propinsi as $p)
                                                <option {{ old('id_propinsi') == $p->id ? 'selected' : '' }} value="{{ $p->id }}">
                                                    {{ $p->prov_name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('id_propinsi')
                                            <div class="help-block">
                                                <ul role="alert">
                                                    <li>{{ $message }}</li>
                                                </ul>
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group  @error('id_kota') error @enderror">
                                            <select name="id_kota" id="id_kota" class="form-control">
                                                <option value="">Kabupaten/Kota</option>
                                            </select>
                                            @error('id_kota')
                                            <div class="help-block">
                                                <ul role="alert">
                                                    <li>{{ $message }}</li>
                                                </ul>
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group @error('id_kecamatan') error @enderror"">
                                                                        <select name=" id_kecamatan" id="id_kecamatan" class="form-control">
                                            <option value="">Kecamatan</option>
                                            </select>
                                            @error('id_kecamatan')
                                            <div class="help-block">
                                                <ul role="alert">
                                                    <li>{{ $message }}</li>
                                                </ul>
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group @error('id_kelurahan') error @enderror">
                                            <select name="id_kelurahan" id="id_kelurahan" class="form-control">
                                                <option value="">Kelurahan</option>
                                            </select>
                                            @error('id_kelurahan')
                                            <div class="help-block">
                                                <ul role="alert">
                                                    <li>{{ $message }}</li>
                                                </ul>
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <x-inputtext label="Kode Pos" field="kode_pos" icon="feather icon-codepen" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group @error('status_tinggal') error @enderror">
                                            <select name="status_tinggal" id="status_tinggal" class="form-control">
                                                <option value="">Status Tinggal</option>
                                                <option {{ old('status_tinggal') == 'MS' ? 'selected' : '' }} value="MS">
                                                    Milik Sendiri
                                                </option>
                                                <option {{ old('status_tinggal') == 'MK' ? 'selected' : '' }} value="MK">
                                                    Milik Keluarga
                                                </option>
                                                <option {{ old('status_tinggal') == 'S' ? 'selected' : '' }} value="S">
                                                    Sewa / Kontrak
                                                </option>
                                            </select>
                                            @error('status_tinggal')
                                            <div class="help-block">
                                                <ul role="alert">
                                                    <li>{{ $message }}</li>
                                                </ul>
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
                                        <button type="reset" class="btn btn-outline-warning mr-1 mb-1">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@push('myscript')
<script>
    $(function() {
        $("#id_propinsi").change(function() {
            var id_propinsi = $("#id_propinsi").val();
            $.ajax({
                type: 'POST'
                , url: '/loaddata/getkota'
                , data: {
                    _token: "{{ csrf_token() }}"
                    , id_propinsi: id_propinsi
                }
                , cache: false
                , success: function(respond) {
                    $("#id_kota").html(respond);
                }
            });
        });

        $("#id_kota").change(function() {
            var id_kota = $("#id_kota").val();
            $.ajax({
                type: 'POST'
                , url: '/loaddata/getkecamatan'
                , data: {
                    _token: "{{ csrf_token() }}"
                    , id_kota: id_kota
                }
                , cache: false
                , success: function(respond) {
                    $("#id_kecamatan").html(respond);
                }
            });
        });

        $("#id_kecamatan").change(function() {
            var id_kecamatan = $("#id_kecamatan").val();
            $.ajax({
                type: 'POST'
                , url: '/loaddata/getkelurahan'
                , data: {
                    _token: "{{ csrf_token() }}"
                    , id_kecamatan: id_kecamatan
                }
                , cache: false
                , success: function(respond) {
                    $("#id_kelurahan").html(respond);
                }
            });
        });
    });

</script>
@endpush
