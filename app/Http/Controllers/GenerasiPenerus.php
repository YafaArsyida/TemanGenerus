<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GenerasiPenerus extends Controller
{
    public function index()
    {
        return view('ADMINISTRASI.generasi-penerus.v_index');
    }
}
