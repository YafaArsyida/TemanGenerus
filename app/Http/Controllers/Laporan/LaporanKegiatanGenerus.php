<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaporanKegiatanGenerus extends Controller
{
    public function rutinDaerah()
    {
        return view('LAPORAN.daerah.kegiatan-rutin.v_index');
    }

    public function eventDaerah()
    {
        return view('LAPORAN.daerah.kegiatan-event.v_index');
    }

    public function rutinDesa()
    {
        return view('LAPORAN.desa.kegiatan-rutin.v_index');
    }

    public function eventDesa()
    {
        return view('LAPORAN.desa.kegiatan-event.v_index');
    }

    public function rutinKelompok()
    {
        return view('LAPORAN.kelompok.kegiatan-rutin.v_index');
    }

    public function eventKelompok()
    {
        return view('LAPORAN.kelompok.kegiatan-event.v_index');
    }
}
