<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PresensiKegiatan extends Controller
{
    public function index($token)
    {
        return view('OPERASIONAL.presensi-kegiatan.v_index', [
            'token' => $token
        ]);
    }
}
