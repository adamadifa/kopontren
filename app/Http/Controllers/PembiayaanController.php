<?php

namespace App\Http\Controllers;

use App\Models\Pembiayaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembiayaanController extends Controller
{
    public function index(Request $request)
    {

        $query = Pembiayaan::query();
        $pembiayaan = $query->paginate(10);
        $pembiayaan->appends($request->all());
        return view('pembiayaan.index', compact('pembiayaan'));
    }

    public function create()
    {
        $propinsi = DB::table('provinces')->orderBy('prov_name', 'asc')->get();
        return view('pembiayaan.create', compact('propinsi'));
    }
}
