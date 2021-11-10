@extends('layouts.midone')
@section('titlepage','Data Tabungan Anggota')
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
                        <a href="#" id="buatrekening" class="btn btn-primary"><i
                            class="feather icon-file-text mr-2"></i>Buat Rekening</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <form action="/simpanan">
                            <div class=" form-label-group position-relative has-icon-left">
                                <input type="text" value="{{Request('cari')}}" id="cari" name="cari"
                                    class="form-control" name="fname-floating-icon" placeholder="Search">
                                <div class="form-control-position">
                                    <i class="feather icon-search"></i>
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
                                <th>KODE ANGGOTA</th>
                                <th>NAMA LENGKAP</th>
                                <th>KODE TABUNGAN</th>
                                <th>JENIS TABUNGAN</th>
                                <th>SALDO</th>
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
<div class="modal fade" id="modalbuatrekening" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Buat Rekening</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="frmSimpanan" action="/simpanan/store" class="frmRekening">
                    @csrf
                    <div class="col-12">
                        <x-inputtext label="No. Rekening (Auto)" field="no_rekening" icon="feather icon-maximize" readonly="true" />
                    </div>
                    <div class="col-12">
                        <x-inputtext label="Anggota" field="no_anggota" icon="feather icon-user" />
                    </div>

                    <div class="col-12 mb-2">
                        <select class="form-control" name="kode_tabungan" id="kode_tabungan">
                            <option value="">Jenis Tabungan</option>
                            @foreach ($tabungan as $d)
                            <option value="{{$d->kode_tabungan}}">{{$d->kode_tabungan}} - {{$d->nama_tabungan}}</option>
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
@endsection

@push('myscript')

    <script>
        $(function(){

            $( "#no_anggota" ).autocomplete({
                source: function( request, response ) {
                // Fetch data
                $.ajax({
                    url:"/anggota/getautocomplete",
                    type: 'post',
                    dataType: "json",
                    data: {
                    _token: "{{ csrf_token() }}",
                    search: request.term
                    },
                    success: function( data ) {
                    response( data );
                    }
                });
                },
                select: function (event, ui) {
                $('#no_anggota').val(ui.item.label);
                var no_anggota = ui.item.val;
                alert(no_anggota);
                return false;
                }
            });

            $("#buatrekening").click(function(e){
                e.preventDefault();
                $("#modalbuatrekening").modal("show");
            });

            $( "#no_anggota" ).autocomplete( "option", "appendTo", ".frmRekening" );
        });
    </script>
@endpush

