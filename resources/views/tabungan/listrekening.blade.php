@extends('layouts.midone')
@section('titlepage', 'Data Tabungan Anggota')
@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Data Tabungan</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/rekening">Tabungan</a>
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
                        <a href="#" id="buatrekening" class="btn btn-primary"><i class="feather icon-file-text mr-2"></i>Buat Rekening</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <form action="/rekening">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class=" form-label-group position-relative has-icon-left">
                                        <input type="text" value="{{ Request('nama') }}" id="nama" name="nama" class="form-control" name="fname-floating-icon" placeholder="Nama Anggota">
                                        <div class="form-control-position">
                                            <i class="feather icon-user"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <select class="form-control" name="kodetabungan" id="kodetabungan">
                                        <option value="">Jenis Tabungan</option>
                                        @foreach ($tabungan as $d)
                                        <option @if (Request('kodetabungan')==$d->kode_tabungan)
                                            selected
                                            @endif
                                            value="{{ $d->kode_tabungan }}">{{ $d->kode_tabungan }} -
                                            {{ $d->nama_tabungan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary"><i class="feather icon-search mr-1"></i>Search</button>
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
                                <th>NO REKENING</th>
                                <th class="text-center">KODE ANGGOTA</th>
                                <th>NAMA LENGKAP</th>
                                <th class="text-center">KODE TABUNGAN</th>
                                <th>JENIS TABUNGAN</th>
                                <th>SALDO</th>
                                <th>ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rekening as $d)
                            <tr>
                                <td>{{ $loop->iteration + $rekening->firstItem() - 1 }}</td>
                                <td>{{ $d->no_rekening }}</td>
                                <td class="text-center">{{ $d->no_anggota }}</td>
                                <td>{{ $d->nama_lengkap }}</td>
                                <td class="text-center">{{ $d->kode_tabungan }}</td>
                                <td>{{ $d->nama_tabungan }}</td>
                                <td style="text-align:right">{{ number_format($d->saldo, '0', '', '.') }}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="/rekening/{{ Crypt::encrypt($d->no_rekening) }}/show" class="primary"><i class="feather icon-book"></i></a>
                                        <form method="POST" class="deleteform" action="/rekening/{{ Crypt::encrypt($d->no_rekening) }}/delete">
                                            @csrf
                                            @method('DELETE')
                                            <a class="delete-confirm ml-1">
                                                <i class="feather icon-trash danger"></i>
                                            </a>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $rekening->links('vendor.pagination.vuexy') }}
                </div>

                <!-- DataTable ends -->
            </div>
        </div>
        <!-- Data list view end -->
    </div>
</div>
<div class="modal fade" id="modalbuatrekening" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Buat Rekening</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="frmSimpanan" action="/rekening/store" class="frmRekening">
                    @csrf
                    <div class="col-12">
                        <x-inputtext label="No. Rekening (Auto)" field="no_rekening" icon="feather icon-maximize" readonly="true" />
                    </div>
                    <div class="col-12">
                        <input type="hidden" name="no_anggota" id="no_anggota">
                        <x-inputgroup label="Anggota" field="nama_lengkap" icon="feather icon-user" readonly="true" />
                    </div>
                    <div class="col-12 mb-2">
                        <select class="form-control" name="kode_tabungan" id="kode_tabungan">
                            <option value="">Jenis Tabungan</option>
                            @foreach ($tabungan as $d)
                            <option value="{{ $d->kode_tabungan }}">{{ $d->kode_tabungan }} -
                                {{ $d->nama_tabungan }}</option>
                            @endforeach
                        </select>
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
        $("#no_anggota").autocomplete({
            source: function(request, response) {
                // Fetch data
                $.ajax({
                    url: "/anggota/getautocomplete"
                    , type: 'post'
                    , dataType: "json"
                    , data: {
                        _token: "{{ csrf_token() }}"
                        , search: request.term
                    }
                    , success: function(data) {
                        response(data);
                    }
                });
            }
            , select: function(event, ui) {
                $('#no_anggota').val(ui.item.label);
                var no_anggota = ui.item.val;
                alert(no_anggota);
                return false;
            }
        });

        $("#buatrekening").click(function(e) {
            e.preventDefault();
            $("#modalbuatrekening").modal({
                backdrop: 'static'
                , keyboard: false
            });
        });

        $("#search").click(function(e) {
            e.preventDefault();
            $("#modalanggota").modal({
                backdrop: 'static'
                , keyboard: false
            });
        });

        $("#no_anggota").autocomplete("option", "appendTo", ".frmRekening");


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
            $("#no_anggota").val(no_anggota);
            $("#nama_lengkap").val(nama_lengkap);
            $("#modalanggota .close").click();
        });
    });

</script>
@endpush
