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
                                            <x-inputtext label="No. Akad (Auto)" field="no_akad" icon="fa fa-barcode" readonly="true" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <x-inputtext label="Tanggal Permohonan" field="tgl_permohonan" icon="fa fa-calendar" datepicker="true" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <x-inputgroup label="No. Anggota" field="no_anggota" icon="fa fa-barcode" readonly="true" />
                                        </div>
                                    </div>
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
                                            <div class="form-group jenis_kelamin @error('jenis_kelamin') error @enderror">
                                                <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
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
                    <div class="row">
                        <div class="col-12">
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

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Pengajuan Pembiayaan</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="form-group @error('kode_pembiayaan') error @enderror">
                                                    <select name="kode_pembiayaan" id="kode_pembiayaan" class="form-control">
                                                        <option value="">Jenis Pembiayaan</option>
                                                        @foreach ($jenispembiayaan as $d)
                                                        <option value="{{$d->kode_pembiayaan}}" persentase="{{ $d->persentase }}">{{ $d->nama_pembiayaan }}</option>
                                                        @endforeach
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
                                            <div class="col-4">
                                                <x-inputtext label="Persentase (%)" field="persentase" icon="feather icon-tag" />
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group @error('jangka_waktu') error @enderror">
                                                    <select name="jangka_waktu" id="jangka_waktu" class="form-control">
                                                        <option value="">Jangka Waktu</option>
                                                        <option value="10">10 Bulan</option>
                                                        <option value="12">12 Bulan</option>
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
                                            <div class="col-12">
                                                <x-inputtext label="Jumlah Pembiayaan" field="jumlah" icon="feather icon-book" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <x-inputtext label="Keperluan" field="keperluan" icon="feather icon-file" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <x-inputtext label="Jaminan" field="jaminan" icon="feather icon-file" />
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
            </div>
        </div>
    </form>
</div>
<!-- Modal Data Anggota -->
<div class="modal fade text-left" id="modalanggota" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel17">Data Anggota</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table dataanggota" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width:5%">No</th>
                            <th style="width:20%">No Anggota</th>
                            <th style="width:65%">Nama Lengkap</th>
                            <th style="width:10%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@push('myscript')
<script>
    $(function() {
        $("#search").click(function(e) {
            e.preventDefault();
            $("#modalanggota").modal({
                backdrop: 'static'
                , keyboard: false
            });
        });
        $("#kode_pembiayaan").change(function() {
            var persentase = $('option:selected', this).attr('persentase');
            $("#persentase").val(persentase);
        });
        var table = $('.dataanggota').DataTable({
            processing: true
            , serverSide: true
            , autoWidth: false,

            ajax: "{{ route('dataanggota') }}"
            , columns: [{
                    data: 'DT_RowIndex'
                    , name: 'DT_RowIndex'
                }
                , {
                    data: 'no_anggota'
                    , name: 'no_anggota'
                }
                , {
                    data: 'nama_lengkap'
                    , name: 'nama_lengkap'
                }
                , {
                    data: 'action'
                    , name: 'action'
                    , orderable: true
                    , searchable: true
                }
            , ]
        });

        $('.dataanggota tbody').on('click', 'a', function() {
            var no_anggota = $(this).attr("no-anggota");
            var nama_lengkap = $(this).attr("nama");
            var nik = $(this).attr("nik");
            var tempat_lahir = $(this).attr("tempat_lahir");
            var tanggal_lahir = $(this).attr("tanggal_lahir");
            var jenis_kelamin = $(this).attr("jenis_kelamin");
            var pendidikan_terakhir = $(this).attr("pendidikan_terakhir");
            var status_pernikahan = $(this).attr("status_pernikahan");
            var jml_tanggungan = $(this).attr("jml_tanggungan");
            var nama_ibu = $(this).attr("nama_ibu");
            var nama_saudara = $(this).attr("nama_saudara");
            var nama_pasangan = $(this).attr("nama_pasangan");
            var pekerjaan_pasangan = $(this).attr("pekerjaan_pasangan");
            var no_hp = $(this).attr("no_hp");
            var alamat = $(this).attr("alamat");
            var id_propinsi = $(this).attr("id_propinsi");
            var id_kota = $(this).attr("id_kota");
            var id_kecamatan = $(this).attr("id_kecamatan");
            var id_kelurahan = $(this).attr("id_kelurahan");
            var kode_pos = $(this).attr("kode_pos");
            var status_tinggal = $(this).attr("status_tinggal");
            $("#no_anggota").val(no_anggota);
            $("#nama_lengkap").val(nama_lengkap);
            $("#nik").val(nik);
            $("#tempat_lahir").val(tempat_lahir);
            $("#tanggal_lahir").val(tanggal_lahir);
            $("#jenis_kelamin").val(jenis_kelamin);
            $("#pendidikan_terakhir").val(pendidikan_terakhir);
            $("#status_pernikahan").val(status_pernikahan);
            $("#jml_tanggungan").val(jml_tanggungan);
            $("#nama_pasangan").val(nama_pasangan);
            $("#pekerjaan_pasangan").val(pekerjaan_pasangan);
            $("#nama_ibu").val(nama_ibu);
            $("#nama_saudara").val(nama_saudara);
            $("#no_hp").val(no_hp);
            $("#alamat").val(alamat);
            $("#id_propinsi").val(id_propinsi);
            $("#id_kecamatan").val(id_kecamatan);
            $("#id_kelurahan").val(id_kelurahan);
            $("#kode_pos").val(kode_pos);
            $("#status_tinggal").val(status_tinggal);
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
            $("#modalanggota .close").click();
        });

    });

</script>
@endpush
