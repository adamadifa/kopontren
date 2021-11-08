@extends('layouts.midone')
@section('titlepage','Data Anggota')
@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Data Anggota</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/anggota">Anggota</a>
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
                <div class="d-flex justify-content-between">
                    <div>
                        <a href="/anggota/create" class="btn btn-primary"><i
                                class="feather icon-user-plus mr-2"></i>Tambah
                            Anggota</a>
                    </div>
                    <div>
                        <form action="/anggota">
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
                                <th>KODE SIMPANAN</th>
                                <th>NAMA SIMPANAN</th>
                                <th>NAMA LENGKAP</th>
                                <th>TTL</th>
                                <th>No. HP</th>
                                <th>ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($anggota as $d)
                            <tr>
                                <td class="text-center">{{$loop->iteration + $anggota->firstItem() - 1 }}</td>
                                <td class="">{{$d->no_anggota}}</td>
                                <td class="">{{$d->nik}}</td>
                                <td>
                                    <a href="">{{$d->nama_lengkap}}</a>
                                </td>
                                <td>{{$d->tempat_lahir}}, {{$d->tanggal_lahir}}</td>
                                <td>
                                    {{$d->no_hp}}
                                </td>
                                <td class="table-report__action w-56">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a class="ml-1" href="/anggota/{{\Crypt::encrypt($d->no_anggota)}}/edit"><i
                                                class="feather icon-edit"></i></a>
                                        <a class="ml-1" href="/anggota/{{\Crypt::encrypt($d->no_anggota)}}/show"><i
                                                class="feather icon-user info"></i></a>
                                        <form method="POST" class="deleteform"
                                            action="/anggota/{{Crypt::encrypt($d->no_anggota)}}/delete">
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
                {{ $anggota->links('vendor.pagination.vuexy') }}
                <!-- DataTable ends -->
            </div>
        </div>
        <!-- Data list view end -->
    </div>
</div>
@endsection
@push('myscript')
<script>
    $(function(){
        $('.delete-confirm').on('click', function (event) {
            event.preventDefault();
            const url = $(this).attr('href');
            swal({
                title: 'Anda Yakin?',
                text: 'Data ini akan didelete secara permanen!',
                icon: 'warning',
                buttons: ["Cancel", "Yes!"],
            }).then(function(value) {
                if (value) {
                   $(".deleteform").submit();
                }
            });
        });
      });
</script>
@endpush
