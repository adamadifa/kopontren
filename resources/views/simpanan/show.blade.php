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

            <div
            class="flex mt-6 lg:mt-0 items-center lg:items-start  flex-1 flex-col justify-center text-gray-600 px-5 border-l border-r border-gray-200 border-t lg:border-t-0 pt-5 lg:pt-0">
                <span style="font-weight: bold">Saldo :</span>
                @php
                    $total = 0;
                @endphp
                @foreach ($saldosimpanan as $d)
                    @php
                        $total += $d->jumlah;
                    @endphp
                    @if ($d->kode_simpanan=="001")
                        @php
                            $bg = "text-theme-1";
                        @endphp
                    @elseif($d->kode_simpanan=="002")
                        @php
                            $bg = "text-theme-29";
                        @endphp
                    @elseif($d->kode_simpanan=="003")
                        @php
                            $bg = "text-orange-400";
                        @endphp
                    @endif
                    <div class="truncate sm:whitespace-normal {{$bg}} flex items-center mt-3 " style="font-weight: bold">
                        <i data-feather="credit-card"class="w-4 h-4 mr-2"></i>
                        {{$d->kode_simpanan}} - {{$d->nama_simpanan}} :
                        {{number_format($d->jumlah,'0','','.')}}
                    </div>

                @endforeach

                <div class="truncate sm:whitespace-normal border-t border-gray-200 flex items-center mt-3 " style="font-weight: bold">
                    <span style="font-weight: bold" class="text-xl">Total : {{number_format($total,'0','','.')}}</span>
                </div>
            </div>
        </div>
        <div class="nav-tabs flex flex-col sm:flex-row justify-center lg:justify-start">
            <a data-toggle="tab" data-target="#historitransaksi" href="javascript:;" class="py-4 sm:mr-8 flex items-center justify-center  active">
                <i data-feather="folder" class="mr-3"></i> Histori Transaksi
            </a>
        </div>
    </div>
    <div class="intro-y py-4">
        @include('layouts.notification')
    </div>
    <div class="tab-content mt-5">
        <div class="tab-content__pane active" id="historitransaksi">
            <div class="intro-y  col-span-12 lg:col-span-12">
                <div class="flex items-center px-5">
                    <a href="#" id="inputsetoran"
                        class="button text-white bg-theme-3 w-full md:w-50  shadow-md mr-2 flex items-center justify-center">
                        <i data-feather="corner-down-right" class="mr-2"></i>
                        Setoran
                    </a>
                    <a href="#"  id="inputpenarikan" class="button text-white bg-theme-12 w-full md:w-50  shadow-md mr-2 flex items-center justify-center">
                        <i data-feather="corner-down-left" class="mr-2"></i>
                        Penarikan
                    </a>
                </div>
                <div class="col-span-12 overflow-auto lg:overflow-visible">
                    <table class="table table-report -mt-2">
                        <thead>
                            <tr>
                                <th class="text-center whitespace-no-wrap">NO TRANSAKSI</th>
                                <th class="text-center whitespace-no-wrap">TANGGAL</th>
                                <th class="whitespace-no-wrap">JENIS SIMPANAN</th>
                                <th class="text-center whitespace-no-wrap">SETOR</th>
                                <th class="text-center whitespace-no-wrap">TARIK</th>
                                <th class="text-center whitespace-no-wrap">SALDO</th>
                                <th class="text-center whitespace-no-wrap">BERITA</th>
                                <th class="text-center whitespace-no-wrap">PETUGAS</th>
                                <th></th>

                            </tr>
                        </thead>
                        <tbody>
                            @php

                                $i = 1;
                            @endphp
                            @foreach ($datasimpanan as $d)
                            @if ($d->jenis_transaksi == "S")
                                @php
                                    $setor = $d->jumlah;
                                    $tarik = 0;
                                @endphp
                            @else
                                @php
                                    $setor = 0;
                                    $tarik = $d->jumlah;
                                @endphp
                            @endif

                            @if ($d->kode_simpanan=="001")
                                @php
                                    $bg = "bg-theme-1";
                                @endphp
                            @elseif($d->kode_simpanan=="002")
                                @php
                                    $bg = "bg-theme-29";
                                @endphp
                            @elseif($d->kode_simpanan=="003")
                                @php
                                    $bg = "bg-orange-400";
                                @endphp
                            @endif


                                <tr>
                                    <td class="text-center">{{$d->no_transaksi}}</td>
                                    <td class="text-center">{{date('d-m-Y', strtotime($d->tgl_transaksi));}}</td>
                                    <td> {{$d->kode_simpanan}} -  {{$d->nama_simpanan}}</td>
                                    <td class="text-right">{{ number_format($setor,'0','','.')}}</td>
                                    <td class="text-right">{{ number_format($tarik,'0','','.')}}</td>
                                    <td class="text-right">{{ number_format($d->saldo,'0','','.')}}</td>
                                    <td class="text-center">
                                        @if (!empty($d->berita))
                                        <span class="text-white bg-theme-1 py-1 px-2 rounded-full">{{$d->berita}}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">{{$d->name}}</td>
                                    <td>
                                        @if ($i==$totalrow)
                                        <div class="flex justify-center items-center">
                                        <form class="flex items-center text-theme-6" method="POST" id="deleteform" action="/simpanan/{{Crypt::encrypt($d->no_transaksi)}}/delete">
                                            @csrf
                                            @method('DELETE')
                                            <button class="delete-confirm"><i data-feather="trash-2" class="w-4 h-4 mr-1"></i></button>
                                        </form>
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                                @php
                                    $i = $i+1;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modalsetoran">
    <div class="modal__content">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200">
            <h2 class="font-medium text-base mr-auto">Input Setoran</h2>
        </div>
        <div class="grid grid-cols-1 p-5">
            <form method="post" id="frmSimpanan" action="/simpanan/store"  class="validate-form">
                @csrf
                <input type="hidden" name="no_anggota" id="no_anggota" value="{{ \Crypt::encrypt($anggota->no_anggota)}}">
                <input type="hidden" name="jenis_transaksi" id="jenis_transaksi">
                <div class="mb-3">
                    <x-inputtext label="No. Transaksi (Auto)"  field="no_transaksi" icon="maximize" lebar="full" inline="false" datepicker="false" readonly="true" />
                </div>
                <div class="mb-3">
                    <x-inputtext label="Tanggal Transaksi" field="tgl_transaksi" icon="calendar" lebar="full" inline="false" datepicker="true" />
                </div>
                <div class="mb-3">
                    <select class="input border mr-2 w-full" name="kode_simpanan" id="kode_simpanan">
                        <option value="">Jenis Simpanan</option>
                        @foreach ($simpanan as $d)
                            <option value="{{$d->kode_simpanan}}">{{$d->kode_simpanan}} - {{$d->nama_simpanan}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <x-inputtext label="Jumlah" field="jumlah" icon="inbox" lebar="full"  inline="false" datepicker="false" alignright="true" />
                </div>
                <div class="mb-3">
                    <textarea  name="berita" placeholder="Berita" class="input w-full border" id="" cols="30" rows="5" ></textarea>
                </div>
                <div class="px-5 py-3 text-right border-t border-gray-200">
                    <button type="button" data-dismiss="modal" class="button w-20 border text-gray-700 mr-1">Batalkan</button>
                    <button type="submit" class="button w-20 bg-theme-1 text-white">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('myscript')
<script type="text/javascript">

    var jumlah = document.getElementById('jumlah');
    jumlah.addEventListener('keyup', function(e){
        // tambahkan 'Rp.' pada saat form di ketik
        // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
        jumlah.value = formatRupiah(this.value, '');
    });

    /* Fungsi formatRupiah */
    function formatRupiah(angka, prefix){
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split   		= number_string.split(','),
        sisa     		= split[0].length % 3,
        rupiah     		= split[0].substr(0, sisa),
        ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if(ribuan){
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? rupiah : '');
    }
</script>
<script>
    $(function(){
        $("#inputsetoran").click(function(e){
            e.preventDefault();
            $("#modalsetoran").modal("show");
            $("#jenis_transaksi").val("S");
        });

        $("#inputpenarikan").click(function(e){
            e.preventDefault();
            $("#modalsetoran").modal("show");
            $("#jenis_transaksi").val("T");
        });

        $("#frmSimpanan").submit(function(){
            var kode_simpanan = $("#kode_simpanan").val();
            var jumlah = $("#jumlah").val();

            //alert('test');
            if(kode_simpanan == ""){
                swal("Oops","Kode Simpanan Harus Diisi !","warning");
                return false;
            }else if(jumlah == ""){
                swal("Oops","Jumlah Harus Diisi !","warning");
                return false;
            }
        });

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
