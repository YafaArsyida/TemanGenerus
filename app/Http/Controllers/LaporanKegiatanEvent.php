<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaporanKegiatanEvent extends Controller
{
    public function index()
    {
        return view('LAPORAN.kegiatan-event.v_index');
    }
}
