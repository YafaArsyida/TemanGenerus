<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KegiatanGenerus extends Controller
{
    public function index()
    {
        return view('ADMINISTRASI.kegiatan-generus.v_index');
    }
}
