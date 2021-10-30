@extends('layouts.midone')
@section('titlepage',$title)
@section('titlemain',$title)
@section('content')
<div class="intro-y col-span-12 lg:col-span-6">
    <div class="intro-y box p-5 mt-3">
        <form method="post" action="/jenissimpanan/{{$jenissimpanan->kode_simpanan}}/update"  class="validate-form">
            @csrf
            <div class="mb-3">
                <x-inputtext label="Kode Simpanan" value="{{$jenissimpanan->kode_simpanan}}" field="kode_simpanan" icon="code" lebar="full" inline="false" datepicker="false" />
            </div>
            <div class="mb-3">
                <x-inputtext label="Nama Simpanan" value="{{$jenissimpanan->nama_simpanan}}" field="nama_simpanan" icon="file-text" lebar="full" inline="false" datepicker="false" />
            </div>
            <button type="submit" class="button bg-theme-1 w-full text-white">Simpan</button>
        </form>
        <div id="show"></div>
    </div>
</div>
@endsection
@push('myscript')
<script>

</script>
@endpush

