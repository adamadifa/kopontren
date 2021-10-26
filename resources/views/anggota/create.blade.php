@extends('layouts.midone')
@section('titlepage',$title)
@section('titlemain',$title)
@section('content')
<div class="intro-y col-span-12 lg:col-span-6">
    <div class="intro-y box p-5 mt-3">
        <form method="post" action="/anggota/store"  class="validate-form">
            @csrf
            <div class="mb-3">
                <x-inputtext label="NIK" field="nik" icon="credit-card" lebar="full" inline="false" datepicker="false" />
            </div>
            <div class="mb-3">
                <x-inputtext label="Nama Lengkap" field="nama_lengkap" icon="user" lebar="full" inline="false" datepicker="false" />
            </div>
            <div class="grid grid-cols-12 gap-2 mb-3">
                <x-inputtext label="Tempat Lahir" field="tempat_lahir" icon="map" lebar="full" inline="col-span-6" datepicker="false" />
                <x-inputtext label="Tanggal Lahir" field="tanggal_lahir" icon="calendar" lebar="full" inline="col-span-6"  datepicker="true"/>
            </div>
            <div class="mb-3">
                <textarea  name="alamat" placeholder="Alamat" class="input w-full border @error('alamat') error @enderror"" id="" cols="30" rows="5" >{{old('alamat')}}</textarea>
                @error('alamat')
                <label id="name-error" class="error" for="name">{{ucwords($message)}}</label>
                @enderror
            </div>
            <div class="mb-3">
                <x-inputtext label="No HP" field="no_hp" icon="phone" lebar="full" inline="false" datepicker="false" />
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

