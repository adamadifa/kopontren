<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoaddataController extends Controller
{
    function getkota(Request $request)
    {
        $id_propinsi = $request->id_propinsi;
        if (isset($request->id_kota)) {
            $id_kota = $request->id_kota;
        } else {
            $id_kota = "";
        }
        $kota = DB::table('regencies')->where('province_id', $id_propinsi)->get();
        return view('loaddata.showbyprovinces', compact('kota', 'id_kota'));
    }

    function getkecamatan(Request $request)
    {
        $id_kota = $request->id_kota;
        if (isset($request->id_kecamatan)) {
            $id_kecamatan = $request->id_kecamatan;
        } else {
            $id_kecamatan = "";
        }
        $kecamatan = DB::table('districts')->where('regency_id', $id_kota)->get();
        return view('loaddata.showbyregencies', compact('kecamatan', 'id_kecamatan'));
    }

    function getkelurahan(Request $request)
    {
        $id_kecamatan = $request->id_kecamatan;
        if (isset($request->id_kelurahan)) {
            $id_kelurahan = $request->id_kelurahan;
        } else {
            $id_kelurahan = "";
        }
        $kelurahan = DB::table('villages')->where('district_id', $id_kecamatan)->get();
        return view('loaddata.showbydistrict', compact('kelurahan', 'id_kelurahan'));
    }
}
