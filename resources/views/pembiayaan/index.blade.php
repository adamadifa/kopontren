@extends('layouts.midone')
@section('titlepage', 'Data Pembiayaan Anggota')
@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Data Pembiayaan</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/pembiayaan">Pembiayaan</a>
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
                        <a href="/pembiayaan/create" id="tambahpembiayaan" class="btn btn-primary"><i class="feather icon-file-text mr-2"></i>Tambah Pembiayaan</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <form action="/pembiayaan" method="GET">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class=" form-label-group position-relative has-icon-left">
                                        <input type="text" value="{{ Request('dari') }}" id="dari" name="dari" class="form-control pickadate-months-year picker__input" placeholder="Dari">
                                        <div class="form-control-position">
                                            <i class="feather icon-calendar"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class=" form-label-group position-relative has-icon-left">
                                        <input type="text" value="{{ Request('sampai') }}" id="sampai" name="sampai" class="form-control pickadate-months-year picker__input" placeholder="Sampai" datepicker="true">
                                        <div class="form-control-position">
                                            <i class="feather icon-calendar"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class=" form-label-group position-relative has-icon-left">
                                        <input type="text" value="{{ Request('nama') }}" id="nama" name="nama" class="form-control" placeholder="Nama Anggota">
                                        <div class="form-control-position">
                                            <i class="feather icon-user"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-block"><i class="feather icon-search mr-1"></i>Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <a href="/cetakrekappembiayaan" class="btn btn-info mb-2" target="_blank"><i class="feather icon-printer mr-1"></i> Cetak</a>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>NO AKAD</th>
                                <th>TANGGAL</th>
                                <th class="text-center">NO ANGGOTA</th>
                                <th>NAMA LENGKAP</th>
                                <th>JENIS PEMBIAYAAN</th>
                                <th>POKOK</th>
                                <th>JUMLAH PEMBIAYAAN</th>

                                <th>ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pembiayaan as $d)
                            <tr>
                                <td>{{$loop->iteration + $pembiayaan->firstItem() - 1 }}</td>
                                <td>{{ $d->no_akad }}</td>
                                <td>{{ date('d-m-Y',strtotime($d->tgl_permohonan)) }}</td>
                                <td class="text-center">{{ $d->no_anggota }}</td>
                                <td>{{ $d->nama_lengkap }}</td>
                                <td>{{ $d->kode_pembiayaan }} - {{ $d->nama_pembiayaan }}</td>
                                <td align="right">{{ number_format($d->jumlah,'0','','.') }}</td>
                                <td align="right">{{ number_format($d->jumlah + ($d->jumlah * ($d->persentase /100)),'0','','.') }}</td>

                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <a href="/pembiayaan/{{ Crypt::encrypt($d->no_akad) }}/show" class="primary"><i class="feather icon-book"></i></a>
                                            <form method="POST" class="deleteform" action="/pembiayaan/{{ Crypt::encrypt($d->no_akad) }}/delete">
                                                @csrf
                                                @method('DELETE')
                                                <a class="delete-confirm ml-1">
                                                    <i class="feather icon-trash danger"></i>
                                                </a>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $pembiayaan->links('vendor.pagination.vuexy') }}
                </div>

                <!-- DataTable ends -->
            </div>
        </div>
        <!-- Data list view end -->
    </div>
</div>
@endsection
@push('myscript')

<script>
    $(function() {
        $('.delete-confirm').click(function(event) {
            var form = $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                    title: `Are you sure you want to delete this record?`
                    , text: "If you delete this, it will be gone forever."
                    , icon: "warning"
                    , buttons: true
                    , dangerMode: true
                , })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    }
                });
        });
    });

</script>

@endpush
