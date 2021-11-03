@extends('layouts.midone')
@section('titlepage',$title)
@section('titlemain',$title)
@section('content')
<div class="intro-y col-span-12 lg:col-span-12">
<div class="intro-y box px-5 pt-5 mt-5">
    <div class="flex flex-col lg:flex-row border-b border-gray-200 pb-5 -mx-5">
        <div class="flex flex-1 px-5 items-center justify-center lg:justify-start">
            <div class="w-20 h-20 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">
                <img alt="Midone Tailwind HTML Admin Template" class="rounded-full" src="{{asset('dist/images/profile-14.jpg')}}">
                <div class="absolute mb-1 mr-1 flex items-center justify-center bottom-0 right-0  rounded-full p-2" style="background-color:#054c2e"> <i class="w-4 h-4 text-white" data-feather="camera"></i> </div>
            </div>
            <div class="ml-5">
                <div class="w-24 sm:w-40 truncate sm:whitespace-normal font-medium text-lg">{{$anggota->nama_lengkap}}</div>
                <div class="text-gray-600">{{$anggota->no_anggota}}</div>
            </div>
        </div>
        <div class="flex mt-6 lg:mt-0 items-center lg:items-start flex-1 flex-col justify-center text-gray-600 px-5 border-l border-r border-gray-200 border-t lg:border-t-0 pt-5 lg:pt-0">
            <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i data-feather="credit-card" class="w-4 h-4 mr-2"></i> {{$anggota->nik}} </div>
            <div class="truncate sm:whitespace-normal flex items-center"> <i data-feather="mail" class="w-4 h-4 mr-2"></i> russellcrowe@left4code.com </div>
            <div class="truncate sm:whitespace-normal flex items-center"> <i data-feather="calendar" class="w-4 h-4 mr-2"></i> {{$anggota->tempat_lahir}}, {{$anggota->tanggal_lahir}} </div>
            <div class="truncate sm:whitespace-normal flex items-center"> <i data-feather="map" class="w-4 h-4 mr-2"></i> {{$anggota->alamat}} </div>
            <div class="truncate sm:whitespace-normal flex items-center"> <i data-feather="phone" class="w-4 h-4 mr-2"></i> {{$anggota->no_hp}} </div>
        </div>
        <div class="mt-6 lg:mt-0 flex-1 px-5 border-t lg:border-0 border-gray-200 pt-5 lg:pt-0">


        </div>
    </div>
    <div class="nav-tabs flex flex-col sm:flex-row justify-center lg:justify-start">
        <a data-toggle="tab" data-target="#dashboard" href="javascript:;" class="py-4 sm:mr-8 flex items-center justify-center  active"> <i data-feather="folder" class="mr-3"></i> Histori Transaksi</a>
</div>
</div>
@endsection
@push('myscript')
<script>

</script>
@endpush

