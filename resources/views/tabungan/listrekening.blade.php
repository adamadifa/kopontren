@extends('layouts.midone')
@section('titlepage',$title)
@section('titlemain',$title)
@section('content')
<div class="intro-y col-span-12 flex justify-between flex-wrap sm:flex-no-wrap items-center mt-2">
    <div class="flex flex-wrap">
        <a href="#" class="button text-white bg-theme-3 shadow-md mr-2" id="buatrekening">Buat Rekening</a>
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
    <div class="mt-3 sm:mt-0">
        <div class="w-full sm:w-56 relative text-gray-700">
            <form action="/rekening" method="GET">
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
                <th class="text-center whitespace-no-wrap">NO REKENING</th>
                <th class="text-center whitespace-no-wrap">NO ANGGOTA</th>
                <th class="whitespace-no-wrap">NAMA ANGGOTA </th>
                <th class="whitespace-no-wrap">JENIS TABUNGAN</th>
                <th class="whitespace-no-wrap">SALDO</th>
                <th class="text-center whitespace-no-wrap">ACTIONS</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>

</div>
<!-- END: Data List -->

<div class="modal" id="modalrekening">
    <div class="modal__content">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200">
            <h2 class="font-medium text-base mr-auto">Buat Rekening</h2>
        </div>
        <div class="grid grid-cols-1 p-5">
            <form method="post" id="frmRekening" action="/rekening/store"  class="validate-form">
                @csrf

                <div class="mb-3">
                    <x-inputtext label="No. Rekening (Auto)"  field="no_rekening" icon="credit-card" lebar="full" inline="false" datepicker="false" readonly="true" />
                </div>
                <div class="mb-3">
                    <x-inputtext label="Kode Anggota"  field="kode_anggota" icon="credit-card" lebar="full" inline="false" datepicker="false" readonly="true" />
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
<script>
  $(function(){
        $("#buatrekening").click(function(e){
            e.preventDefault();
            $("#modalrekening").modal("show");
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
