<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PresensiKegiatanKartu extends Controller
{
    public function index($token)
    {
        return view('OPERASIONAL.presensi-kegiatan-kartu.v_index', [
            'token' => $token
        ]);
    }
}
