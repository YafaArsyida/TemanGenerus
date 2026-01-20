<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AksesPengguna extends Controller
{
    public function index()
    {
        return view('SISTEM.akses-pengguna.v_index');
    }
}
