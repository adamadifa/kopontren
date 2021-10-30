@extends('layouts.midone')
@section('titlepage',$title)
@section('titlemain',$title)
@section('content')
<div class="intro-y col-span-12 lg:col-span-6">
    <div class="intro-y box p-5 mt-3">
        <form method="post" action="/tabungan/{{$tabungan->kode_tabungan}}/update"  class="validate-form">
            @csrf
            <div class="mb-3">
                <x-inputtext label="Kode Tabungan" value="{{$tabungan->kode_tabungan}}" field="kode_tabungan" icon="code" lebar="full" inline="false" datepicker="false" />
            </div>
            <div class="mb-3">
                <x-inputtext label="Nama Tabungan" value="{{$tabungan->nama_tabungan}}" field="nama_tabungan" icon="file-text" lebar="full" inline="false" datepicker="false" />
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

