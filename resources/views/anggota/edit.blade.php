@extends('layouts.midone')
@section('titlepage', 'Data Anggota')
@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Edit Anggota</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/anggota">Anggota</a></li>
                            <li class="breadcrumb-item"><a href="#">Edit Anggota</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="content-body">
    <form class="form" action="/anggota/{{ \Crypt::encrypt($anggota->no_anggota) }}/update" method="POST">
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
                                            <x-inputtext label="Nomor Identitas" field="nik" icon="feather icon-credit-card" value="{{ $anggota->nik }}" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <x-inputtext label="Nama Lengkap" field="nama_lengkap" icon="feather icon-user" value="{{ $anggota->nama_lengkap }}" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <x-inputtext label="Tempat Lahir" field="tempat_lahir" icon="feather icon-map" value="{{ $anggota->tempat_lahir }}" />
                                        </div>
                                        <div class="col-6">
                                            <x-inputtext label="Tanggal Lahir" field="tanggal_lahir" icon="feather icon-calendar" datepicker="true" value="{{ $anggota->tanggal_lahir }}" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group  @error('jenis_kelamin') error @enderror">
                                                <select name="jenis_kelamin" id="" class="form-control">
                                                    <option value="">Jenis Kelamin</option>
                                                    <option @isset($anggota->jenis_kelamin) @if (old('jenis_kelamin'))
                                                        {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}
                                                        @else
                                                        {{ $anggota->jenis_kelamin == 'L' ? 'selected' : '' }}
                                                        @endif
                                                        @else
                                                        {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}
                                                        @endisset value="L">Laki - Laki</option>
                                                    <option @isset($anggota->jenis_kelamin) @if (old('jenis_kelamin'))
                                                        {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}
                                                        @else
                                                        {{ $anggota->jenis_kelamin == 'P' ? 'selected' : '' }}
                                                        @endif
                                                        @else
                                                        {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}
                                                        @endisset value="P">Perempuan</option>
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
                                                    <option @isset($anggota->pendidikan_terakhir)
                                                        @if (old('pendidikan_terakhir'))
                                                        {{ old('pendidikan_terakhir') == 'SD' ? 'selected' : '' }}
                                                        @else
                                                        {{ $anggota->pendidikan_terakhir == 'SD' ? 'selected' : '' }}
                                                        @endif
                                                        @else
                                                        {{ old('pendidikan_terakhir') == 'SD' ? 'selected' : '' }}
                                                        @endisset
                                                        value="SD">
                                                        SD
                                                    </option>
                                                    <option @isset($anggota->pendidikan_terakhir) @if (old('pendidikan_terakhir'))
                                                        {{ old('pendidikan_terakhir') == 'SMP' ? 'selected' : '' }}
                                                        @else
                                                        {{ $anggota->pendidikan_terakhir == 'SMP' ? 'selected' : '' }}
                                                        @endif
                                                        @else
                                                        {{ old('pendidikan_terakhir') == 'SMP' ? 'selected' : '' }}
                                                        @endisset value="SMP"> SMP </option>
                                                    <option @isset($anggota->pendidikan_terakhir) @if (old('pendidikan_terakhir'))
                                                        {{ old('pendidikan_terakhir') == 'SMA' ? 'selected' : '' }}
                                                        @else
                                                        {{ $anggota->pendidikan_terakhir == 'SMA' ? 'selected' : '' }}
                                                        @endif
                                                        @else
                                                        {{ old('pendidikan_terakhir') == 'SMA' ? 'selected' : '' }}
                                                        @endisset
                                                        value="SMA">SMA</option>
                                                    <option @isset($anggota->pendidikan_terakhir) @if (old('pendidikan_terakhir'))
                                                        {{ old('pendidikan_terakhir') == 'D3' ? 'selected' : '' }}
                                                        @else
                                                        {{ $anggota->pendidikan_terakhir == 'D3' ? 'selected' : '' }}
                                                        @endif
                                                        @else
                                                        {{ old('pendidikan_terakhir') == 'D3' ? 'selected' : '' }}
                                                        @endisset
                                                        value="D3">D3</option>
                                                    <option @isset($anggota->pendidikan_terakhir) @if (old('pendidikan_terakhir'))
                                                        {{ old('pendidikan_terakhir') == 'S1' ? 'selected' : '' }}
                                                        @else
                                                        {{ $anggota->pendidikan_terakhir == 'S1' ? 'selected' : '' }}
                                                        @endif
                                                        @else
                                                        {{ old('pendidikan_terakhir') == 'S1' ? 'selected' : '' }}
                                                        @endisset
                                                        value="S1"> S1 </option>
                                                    <option @isset($anggota->pendidikan_terakhir) @if (old('pendidikan_terakhir'))
                                                        {{ old('pendidikan_terakhir') == 'S2' ? 'selected' : '' }}
                                                        @else
                                                        {{ $anggota->pendidikan_terakhir == 'S2' ? 'selected' : '' }}
                                                        @endif
                                                        @else
                                                        {{ old('pendidikan_terakhir') == 'S2' ? 'selected' : '' }}
                                                        @endisset
                                                        value="S2">
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
                                                    <option @isset($anggota->status_pernikahan)
                                                        @if (old('status_pernikahan'))
                                                        {{ old('status_pernikahan') == 'M' ? 'selected' : '' }}
                                                        @else
                                                        {{ $anggota->status_pernikahan == 'M' ? 'selected' : '' }}
                                                        @endif
                                                        @else
                                                        {{ old('status_pernikahan') == 'M' ? 'selected' : '' }}
                                                        @endisset value="M">
                                                        Menikah
                                                    </option>
                                                    <option @isset($anggota->status_pernikahan) @if (old('status_pernikahan'))
                                                        {{ old('status_pernikahan') == 'BM' ? 'selected' : '' }}
                                                        @else
                                                        {{ $anggota->status_pernikahan == 'BM' ? 'selected' : '' }}
                                                        @endif
                                                        @else
                                                        {{ old('status_pernikahan') == 'BM' ? 'selected' : '' }}
                                                        @endisset value="BM">
                                                        Belum Menikah
                                                    </option>
                                                    <option @isset($anggota->status_pernikahan) @if (old('status_pernikahan'))
                                                        {{ old('status_pernikahan') == 'JD' ? 'selected' : '' }}
                                                        @else
                                                        {{ $anggota->status_pernikahan == 'JD' ? 'selected' : '' }}
                                                        @endif
                                                        @else
                                                        {{ old('status_pernikahan') == 'JD' ? 'selected' : '' }}
                                                        @endisset value="JD">
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
                                            <x-inputtext label="Jumlah Tanggungan" field="jml_tanggungan" icon="feather icon-users" value="{{ $anggota->jml_tanggungan }}" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <x-inputtext label="Nama Pasangan" field="nama_pasangan" icon="feather icon-user" value="{{ $anggota->nama_pasangan }}" />
                                        </div>
                                        <div class="col-6">
                                            <x-inputtext label="Pekerjaan Pasangan" field="pekerjaan_pasangan" icon="feather icon-anchor" value="{{ $anggota->pekerjaan_pasangan }}" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <x-inputtext label="Nama Ibu Kandung" field="nama_ibu" icon="feather icon-user" value="{{ $anggota->nama_ibu }}" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <x-inputtext label="Nama Saudara Tidak Serumah" field="nama_saudara" icon="feather icon-user" value="{{ $anggota->nama_saudara }}" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <x-inputtext label="No. HP" field="no_hp" icon="feather icon-phone" value="{{ $anggota->no_hp }}" />
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
                                                <textarea autocomplete="off" data-length=100 class="form-control char-textarea" name="alamat" id="alamat" rows="3" placeholder="Alamat Sesuai KTP">@if (!empty(old('alamat'))){{ old('alamat') }}@else{{ $anggota->alamat }}@endif</textarea>
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
                                                <option @isset($anggota->id_propinsi) @if (old('id_propinsi'))
                                                    {{ old('id_propinsi') == $p->id ? 'selected' : '' }} @else
                                                    {{ $anggota->id_propinsi == $p->id ? 'selected' : '' }} @endif @else
                                                    {{ old('id_propinsi') == $p->id ? 'selected' : '' }}
                                                    @endisset {{ old('id_propinsi') == $p->id ? 'selected' : '' }} value="{{ $p->id }}">
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
                                        <x-inputtext label="Kode Pos" field="kode_pos" icon="feather icon-codepen" value="{{ $anggota->kode_pos }}" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group @error('status_tinggal') error @enderror">
                                            <select name="status_tinggal" id="status_tinggal" class="form-control">
                                                <option value="">Status Tinggal</option>
                                                <option @isset($anggota->status_tinggal) @if (old('status_tinggal'))
                                                    {{ old('status_tinggal') == 'MS' ? 'selected' : '' }} @else
                                                    {{ $anggota->status_tinggal == 'MS' ? 'selected' : '' }} @endif @else
                                                    {{ old('status_tinggal') == 'MS' ? 'selected' : '' }}
                                                    @endisset value="MS">
                                                    Milik Sendiri
                                                </option>
                                                <option @isset($anggota->status_tinggal) @if (old('status_tinggal'))
                                                    {{ old('status_tinggal') == 'MK' ? 'selected' : '' }} @else
                                                    {{ $anggota->status_tinggal == 'MK' ? 'selected' : '' }} @endif @else
                                                    {{ old('status_tinggal') == 'MK' ? 'selected' : '' }}
                                                    @endisset value="MK">
                                                    Milik Keluarga
                                                </option>
                                                <option @isset($anggota->status_tinggal) @if (old('status_tinggal'))
                                                    {{ old('status_tinggal') == 'S' ? 'selected' : '' }} @else
                                                    {{ $anggota->status_tinggal == 'S' ? 'selected' : '' }} @endif @else
                                                    {{ old('status_tinggal') == 'S' ? 'selected' : '' }}
                                                    @endisset value="S">
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
                                    <div class="col-md-6">
                                        <div class="form-group  @error('npp') error @enderror">
                                            <select name="npp" id="npp" class="form-control">
                                                <option value="">Npp</option>
                                                @foreach ($karyawan as $d)
                                                <option @isset($anggota->npp) @if (old('npp'))
                                                    {{ old('npp') == $d->npp ? 'selected' : '' }} @else
                                                    {{ $anggota->npp == $d->npp ? 'selected' : '' }} @endif @else
                                                    {{ old('npp') == $d->npp ? 'selected' : '' }}
                                                    @endisset {{ old('npp') == $d->npp ? 'selected' : '' }} value="{{ $d->npp }}">
                                                    {{ $d->npp }} - {{$d->nama_lengkap}}
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
        $('#npp').select2();
        function loadkota() {
            var id_propinsi = $("#id_propinsi").val();
            var id_kota = "{{ $anggota->id_kota }}";
            //alert(id_kota);
            $.ajax({
                type: 'POST'
                , url: '/loaddata/getkota'
                , data: {
                    _token: "{{ csrf_token() }}"
                    , id_propinsi: id_propinsi
                    , id_kota: id_kota
                }
                , cache: false
                , success: function(respond) {
                    $("#id_kota").html(respond);
                }
            });
        }

        $("#id_propinsi").change(function() {
            loadkota();
        });

        function loadkecamatan() {
            var kota = $("#id_kota").val();
            var id_kota = "";
            if (kota == "") {
                id_kota = "{{ $anggota->id_kota }}";
            } else {
                id_kota = kota
            }
            var id_kecamatan = "{{ $anggota->id_kecamatan }}";
            //alert(id_kota);
            $.ajax({
                type: 'POST'
                , url: '/loaddata/getkecamatan'
                , data: {
                    _token: "{{ csrf_token() }}"
                    , id_kota: id_kota
                    , id_kecamatan: id_kecamatan
                }
                , cache: false
                , success: function(respond) {
                    $("#id_kecamatan").html(respond);
                }
            });
        }

        function loadkelurahan() {
            var kecamatan = $("#id_kecamatan").val();
            var id_kecamatan = "";
            if (kecamatan == "") {
                id_kecamatan = "{{ $anggota->id_kecamatan }}";
            } else {
                id_kecamatan = kecamatan;
            }

            var id_kelurahan = "{{ $anggota->id_kelurahan }}";
            $.ajax({
                type: 'POST'
                , url: '/loaddata/getkelurahan'
                , data: {
                    _token: "{{ csrf_token() }}"
                    , id_kecamatan: id_kecamatan
                    , id_kelurahan: id_kelurahan
                }
                , cache: false
                , success: function(respond) {
                    $("#id_kelurahan").html(respond);
                }
            });
        }

        $("#id_kota").change(function() {
            loadkecamatan();
        });
        loadkota();
        loadkecamatan();
        loadkelurahan();
        $("#id_kecamatan").change(function() {
            loadkelurahan();
        });
    });

</script>
@endpush
