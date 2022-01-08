@extends('layouts.midone')
@section('titlepage', 'Data Jenis Pembiayaan')
@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Jenis Pembiayaan</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/jenispembiayaan">Jenis Pembiayaan</a>
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
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <a href="/jenispembiayaan/create" class="btn btn-primary"><i class="feather icon-file-plus mr-1"></i>Tambah</a>

                        <div class="table-responsive mt-2">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>KODE</th>
                                        <th>JENIS PEMBIAYAAN</th>
                                        <th>PERSENTASE</th>
                                        <th>AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jenispembiayaan as $d)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="">{{ $d->kode_pembiayaan }}</td>
                                        <td class="">{{ $d->nama_pembiayaan }}</td>
                                        <td class="">{{ $d->persentase }}%</td>
                                        <td class="table-report__action w-56">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <a class="ml-1" href="/jenispembiayaan/{{ \Crypt::encrypt($d->kode_pembiayaan) }}/edit"><i class="feather icon-edit"></i></a>
                                                <form method="POST" class="deleteform" action="/jenispembiayaan/{{ \Crypt::encrypt($d->kode_pembiayaan) }}/delete">
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

                        </div>

                        <!-- DataTable ends -->
                    </div>
                </div>
                <!-- Data list view end -->
            </div>
        </div>
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
