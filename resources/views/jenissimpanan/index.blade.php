@extends('layouts.midone')
@section('titlepage',$title)
@section('titlemain',$title)
@section('content')
<div class="intro-y col-span-12 flex justify-between flex-wrap sm:flex-no-wrap items-center mt-2">
    <div class="flex flex-wrap">
        <a href="/jenissimpanan/create" class="button text-white bg-theme-3 shadow-md mr-2">Tambah Jenis Simpanan</a>
        <div class="dropdown relative">
            <button class="dropdown-toggle button px-2 box text-gray-700">
                <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-feather="plus"></i> </span>
            </button>
            <div class="dropdown-box mt-10 absolute w-40 top-0 left-0 z-20">
                <div class="dropdown-box__content box p-2">
                    <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> <i data-feather="printer" class="w-4 h-4 mr-2"></i> Print </a>
                    <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Export to Excel </a>
                    <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> <i data-feather="file-text" class="w-4 h-4 mr-2"></i> Export to PDF </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="intro-y col-span-12">
    @include('layouts.notification')
</div>
<div class="intro-y col-span-6 overflow-auto lg:overflow-visible">
    <table class="table table-report -mt-2">
        <thead>
            <tr>
                <th class="text-center whitespace-no-wrap">NO</th>
                <th class="whitespace-no-wrap">KODE SIMPANAN</th>
                <th class="whitespace-no-wrap">NAMA SIMPANAN</th>
                <th class="text-center whitespace-no-wrap">AKSI</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jenissimpanan as $d)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$d->kode_simpanan}}</td>
                    <td>{{$d->nama_simpanan}}</td>
                    <td>
                        <div class="flex justify-center items-center">
                            <a class="flex items-center text-theme-1" href="/jenissimpanan/{{\Crypt::encrypt($d->kode_simpanan)}}/edit"> <i data-feather="edit" class="w-4 h-4 mr-1"></i></a>
                            <form class="flex items-center text-theme-6" method="POST" id="deleteform" action="/jenissimpanan/{{Crypt::encrypt($d->kode_simpanan)}}/delete">
                                @csrf
                                @method('DELETE')
                                <button class="delete-confirm"><i data-feather="trash-2" class="w-4 h-4 mr-1"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
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
                   $("#deleteform").submit();
                }
            });
        });
      });
</script>
@endpush
