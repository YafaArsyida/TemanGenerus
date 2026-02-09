<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaporanKegiatanRutin extends Controller
{
    public function index()
    {
        return view('LAPORAN.kegiatan-rutin.v_index');
    }
}
