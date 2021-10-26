@extends('layouts.midone')
@section('titlepage',$title)
@section('titlemain',$title)
@section('content')
<div class="intro-y col-span-12 flex flex-wrap sm:flex-no-wrap items-center mt-2">
    <a href="/anggota/create" class="button text-white bg-theme-3 shadow-md mr-2">Tambah Anggota</a>
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

<div class="intro-y col-span-12">
    @include('layouts.notification')
</div>
<div class="intro-y col-span-12 overflow-auto lg:overflow-visible">

    <table class="table table-report -mt-2">
        <thead>
            <tr>
                <th class="text-center whitespace-no-wrap">NO</th>
                <th class="whitespace-no-wrap">NO REKENING</th>
                <th class="whitespace-no-wrap">NIK</th>
                <th class="whitespace-no-wrap">FOTO</th>
                <th class="whitespace-no-wrap">NAMA LENGKAP</th>
                <th class="whitespace-no-wrap">TTL</th>
                <th class="whitespace-no-wrap">No. HP</th>
                <th class="text-center whitespace-no-wrap">ACTIONS</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($anggota as $d)
            <tr class="intro-x">
                <td class="text-center">{{$loop->iteration + $anggota->firstItem() - 1 }}</td>
                <td class="">{{$d->no_rek_anggota}}</td>
                <td class="">{{$d->nik}}</td>
                <td class="w-40">
                    <div class="flex">
                        <div class="w-10 h-10 image-fit zoom-in">
                            <img alt="Midone Tailwind HTML Admin Template" class="tooltip rounded-full" src="dist/images/preview-4.jpg" title="Uploaded at 17 July 2021">
                        </div>
                    </div>
                </td>
                <td>
                    <a href="" class="font-medium whitespace-no-wrap">{{$d->nama_lengkap}}</a>
                </td>
                <td>{{$d->tempat_lahir}}, {{$d->tanggal_lahir}}</td>
                <td class="w-40">
                    {{$d->no_hp}}
                </td>
                <td class="table-report__action w-56">
                    <div class="flex justify-center items-center">
                        <a class="flex items-center mr-3" href="/anggota/{{\Crypt::encrypt($d->no_rek_anggota)}}/edit"> <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
                        <a class="flex items-center text-theme-6" href="javascript:;" data-toggle="modal" data-target="#delete-confirmation-modal"> <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{$anggota->links()}}
</div>
<!-- END: Data List -->
@endsection
