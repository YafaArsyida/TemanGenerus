<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DesaKelompok extends Controller
{
    public function index()
    {
        return view('ADMINISTRASI.desa-kelompok.v_index');
    }
}
