@extends('layouts.midone')
@section('titlepage',$title)
@section('titlemain',$title)
@section('content')
<div class="intro-y col-span-12 flex justify-between flex-wrap sm:flex-no-wrap items-center mt-2">
    <div class="flex flex-wrap">
    </div>
    <div class="mt-3 sm:mt-0">
        <div class="w-full sm:w-56 relative text-gray-700">
            <form action="/simpanan" method="GET">
                <input type="text" value="{{Request::get('cari')}}" name="cari" class="input w-full sm:w-56 box pr-20 sm:pr-10 placeholder-theme-13" placeholder="Search...">
                <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-feather="search"></i>
            </form>
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
                <th class="whitespace-no-wrap">NO ANGGOTA</th>
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
                <td class="">{{$d->no_anggota}}</td>
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
                        <a class="flex items-center text-theme-1" href="/simpanan/{{\Crypt::encrypt($d->no_anggota)}}/show"> <i data-feather="book" class="w-4 h-4 mr-1"></i></a>
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

