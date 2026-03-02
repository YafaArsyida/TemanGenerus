<?php

namespace App\Http\Livewire\Laporan\Kelompok\KegiatanRutin;

use App\Models\Kegiatan;
use App\Models\Kelompok;
use Livewire\Component;

class Report extends Component
{
    // ==============================
    // STATE (INPUT / KONTEXT AKTIF)
    // ==============================
    public $kegiatan;
    public $kegiatanId;

    public $ms_kelompok_id;
    public $ms_desa_id;

    public $nama_kelompok = '-';
    public $nama_desa = '-';


    protected $listeners = [
        'KegiatanReport' => 'loadReport'
    ];

    // ==============================
    // EVENT HANDLER
    // ==============================
    public function loadReport($kegiatanId, $kelompokId)
    {
        $this->kegiatanId = $kegiatanId;
        $this->ms_kelompok_id = $kelompokId;

        // Ambil kelompok + desa
        $kelompok = Kelompok::with('ms_desa')->find($kelompokId);

        $this->nama_kelompok = $kelompok?->nama_kelompok ?? '-';
        $this->nama_desa     = $kelompok?->ms_desa?->nama_desa ?? '-';
        $this->ms_desa_id     = $kelompok?->ms_desa?->ms_desa_id ?? '-';

        // Load kegiatan
        $this->kegiatan = Kegiatan::with([
            'ms_desa',
            'ms_kelompok.ms_desa'
        ])->find($kegiatanId);

        if (!$this->kegiatan) {
            $this->dispatchBrowserEvent('alertify-error', [
                'message' => 'Data kegiatan tidak ditemukan'
            ]);
            return;
        }

        // Broadcast ke child (matrix)
        $this->emitTo(
            'laporan.kelompok.kegiatan-rutin.report.attendance-matrix',
            'setParameter',
            $kegiatanId,
            $this->ms_kelompok_id
        );


        $this->dispatchBrowserEvent('alertify-success', [
            'message' => 'Laporan kelompok dimuat'
        ]);
    }

    public function render()
    {
        return view('livewire.laporan.kelompok.kegiatan-rutin.report');
    }
}
