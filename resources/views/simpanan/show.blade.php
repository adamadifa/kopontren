@extends('layouts.midone')
@section('titlepage',$title)
@section('titlemain',$title)
@section('content')
<div class="intro-y col-span-12 lg:col-span-12">
    <div class="intro-y box px-5 pt-5 mt-5">
        <div class="flex flex-col lg:flex-row border-b border-gray-200 pb-5 -mx-5">
            <div class="flex flex-1 px-5 items-center justify-center lg:justify-start">
                <div class="w-20 h-20 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">
                    <img alt="Midone Tailwind HTML Admin Template" class="rounded-full"
                        src="{{asset('dist/images/profile-14.jpg')}}">
                    <div class="absolute mb-1 mr-1 flex items-center justify-center bottom-0 right-0  rounded-full p-2"
                        style="background-color:#054c2e"> <i class="w-4 h-4 text-white" data-feather="camera"></i>
                    </div>
                </div>
                <div class="ml-5">
                    <div class="w-24 sm:w-40 truncate sm:whitespace-normal font-medium text-lg">
                        {{$anggota->nama_lengkap}}</div>
                    <div class="text-gray-600">{{$anggota->no_anggota}}</div>
                </div>
            </div>
            <div
                class="flex mt-6 lg:mt-0 items-center lg:items-start flex-1 flex-col justify-center text-gray-600 px-5 border-l border-r border-gray-200 border-t lg:border-t-0 pt-5 lg:pt-0">
                <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i data-feather="credit-card"
                        class="w-4 h-4 mr-2"></i> {{$anggota->nik}} </div>
                <div class="truncate sm:whitespace-normal flex items-center"> <i data-feather="mail"
                        class="w-4 h-4 mr-2"></i> russellcrowe@left4code.com </div>
                <div class="truncate sm:whitespace-normal flex items-center"> <i data-feather="calendar"
                        class="w-4 h-4 mr-2"></i> {{$anggota->tempat_lahir}}, {{$anggota->tanggal_lahir}} </div>
                <div class="truncate sm:whitespace-normal flex items-center"> <i data-feather="map"
                        class="w-4 h-4 mr-2"></i> {{$anggota->alamat}} </div>
                <div class="truncate sm:whitespace-normal flex items-center"> <i data-feather="phone"
                        class="w-4 h-4 mr-2"></i> {{$anggota->no_hp}} </div>
            </div>
            <div class="mt-6 lg:mt-0 flex-1 px-5 border-t lg:border-0 border-gray-200 pt-5 lg:pt-0">


            </div>
        </div>
        <div class="nav-tabs flex flex-col sm:flex-row justify-center lg:justify-start">
            <a data-toggle="tab" data-target="#historitransaksi" href="javascript:;"
                class="py-4 sm:mr-8 flex items-center justify-center  active"> <i data-feather="folder"
                    class="mr-3"></i> Histori Transaksi</a>
        </div>
    </div>
    <div class="tab-content mt-5">
        <div class="tab-content__pane active" id="historitransaksi">
            <div class="intro-y  col-span-12 lg:col-span-12">
                <div class="flex items-center px-5">
                    <a href="#" id="inputsetoran"
                        class="button text-white bg-theme-3  shadow-md mr-2 flex items-center justify-center">
                        <i data-feather="corner-down-right" class="mr-2"></i>
                        Setoran
                    </a>
                    <a href="#" class="button text-white bg-theme-12  shadow-md mr-2 flex items-center justify-center">
                        <i data-feather="corner-down-left" class="mr-2"></i>
                        Penarikan
                    </a>
                </div>
                <div class="intro-y py-5 col-span-12 lg:col-span-12">
                    <table class="table table-report -mt-2">
                        <thead>
                            <tr>
                                <th class="text-center whitespace-no-wrap">NO TRANSAKSI</th>
                                <th class="whitespace-no-wrap">TANGGAL</th>
                                <th class="whitespace-no-wrap">JENIS SIMPANAN</th>
                                <th class="whitespace-no-wrap">DEBET</th>
                                <th class="whitespace-no-wrap">KREDIT</th>
                                <th class="whitespace-no-wrap">SALDO</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="header-footer-modal-preview">
    <div class="modal__content">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200">
            <h2 class="font-medium text-base mr-auto">Broadcast Message</h2> <button
                class="button border items-center text-gray-700 hidden sm:flex"> <i data-feather="file"
                    class="w-4 h-4 mr-2"></i> Download Docs </button>
            <div class="dropdown relative sm:hidden"> <a class="dropdown-toggle w-5 h-5 block" href="javascript:;"> <i
                        data-feather="more-horizontal" class="w-5 h-5 text-gray-700"></i> </a>
                <div class="dropdown-box mt-5 absolute w-40 top-0 right-0 z-20">
                    <div class="dropdown-box__content box p-2"> <a href="javascript:;"
                            class="flex items-center p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md">
                            <i data-feather="file" class="w-4 h-4 mr-2"></i> Download Docs </a> </div>
                </div>
            </div>
        </div>
        <div class="p-5 grid grid-cols-12 gap-4 row-gap-3">
            <div class="col-span-12 sm:col-span-6"> <label>From</label> <input type="text"
                    class="input w-full border mt-2 flex-1" placeholder="example@gmail.com"> </div>
            <div class="col-span-12 sm:col-span-6"> <label>To</label> <input type="text"
                    class="input w-full border mt-2 flex-1" placeholder="example@gmail.com"> </div>
            <div class="col-span-12 sm:col-span-6"> <label>Subject</label> <input type="text"
                    class="input w-full border mt-2 flex-1" placeholder="Important Meeting"> </div>
            <div class="col-span-12 sm:col-span-6"> <label>Has the Words</label> <input type="text"
                    class="input w-full border mt-2 flex-1" placeholder="Job, Work, Documentation"> </div>
            <div class="col-span-12 sm:col-span-6"> <label>Doesn't Have</label> <input type="text"
                    class="input w-full border mt-2 flex-1" placeholder="Job, Work, Documentation"> </div>
            <div class="col-span-12 sm:col-span-6"> <label>Size</label> <select class="input w-full border mt-2 flex-1">
                    <option>10</option>
                    <option>25</option>
                    <option>35</option>
                    <option>50</option>
                </select> </div>
        </div>
        <div class="px-5 py-3 text-right border-t border-gray-200"> <button type="button"
                class="button w-20 border text-gray-700 mr-1">Cancel</button> <button type="button"
                class="button w-20 bg-theme-1 text-white">Send</button> </div>
    </div>
</div>
<div class="modal" id="modalsetoran">
    <div class="modal__content">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200">
            <h2 class="font-medium text-base mr-auto">Broadcast Message</h2> <button
                class="button border items-center text-gray-700 hidden sm:flex"> <i data-feather="file"
                    class="w-4 h-4 mr-2"></i> Download Docs </button>
            <div class="dropdown relative sm:hidden"> <a class="dropdown-toggle w-5 h-5 block" href="javascript:;"> <i
                        data-feather="more-horizontal" class="w-5 h-5 text-gray-700"></i> </a>
                <div class="dropdown-box mt-5 absolute w-40 top-0 right-0 z-20">
                    <div class="dropdown-box__content box p-2"> <a href="javascript:;"
                            class="flex items-center p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md">
                            <i data-feather="file" class="w-4 h-4 mr-2"></i> Download Docs </a> </div>
                </div>
            </div>
        </div>
        <div class="p-5 grid grid-cols-12 gap-4 row-gap-3">
            <div class="col-span-12 sm:col-span-6"> <label>From</label> <input type="text"
                    class="input w-full border mt-2 flex-1" placeholder="example@gmail.com"> </div>
            <div class="col-span-12 sm:col-span-6"> <label>To</label> <input type="text"
                    class="input w-full border mt-2 flex-1" placeholder="example@gmail.com"> </div>
            <div class="col-span-12 sm:col-span-6"> <label>Subject</label> <input type="text"
                    class="input w-full border mt-2 flex-1" placeholder="Important Meeting"> </div>
            <div class="col-span-12 sm:col-span-6"> <label>Has the Words</label> <input type="text"
                    class="input w-full border mt-2 flex-1" placeholder="Job, Work, Documentation"> </div>
            <div class="col-span-12 sm:col-span-6"> <label>Doesn't Have</label> <input type="text"
                    class="input w-full border mt-2 flex-1" placeholder="Job, Work, Documentation"> </div>
            <div class="col-span-12 sm:col-span-6"> <label>Size</label> <select class="input w-full border mt-2 flex-1">
                    <option>10</option>
                    <option>25</option>
                    <option>35</option>
                    <option>50</option>
                </select> </div>
        </div>
        <div class="px-5 py-3 text-right border-t border-gray-200"> <button type="button"
                class="button w-20 border text-gray-700 mr-1">Cancel</button> <button type="button"
                class="button w-20 bg-theme-1 text-white">Send</button> </div>
    </div>
</div>
@endsection
@push('myscript')
<script>
    $(function(){
        $("#inputsetoran").click(function(){
            $("#modalsetoran").modal("show");
        });
    });
</script>
@endpush
