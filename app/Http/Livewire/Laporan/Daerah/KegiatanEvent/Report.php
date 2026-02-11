<?php

namespace App\Http\Livewire\Laporan\Daerah\KegiatanEvent;

use App\Models\Kegiatan;
use Livewire\Component;

class Report extends Component
{
    public $kegiatan;
    public $kegiatanId;

    protected $listeners = [
        'KegiatanReport' => 'loadReport'
    ];

    public function loadReport($kegiatanId)
    {
        $this->kegiatanId = $kegiatanId;

        // broadcast ke child
        $this->emitTo('laporan.daerah.kegiatan-event.report.attendance', 'setKegiatan', $kegiatanId);
        $this->emitTo('laporan.daerah.kegiatan-event.report.alfa', 'setKegiatan', $kegiatanId);
        
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

        $this->dispatchBrowserEvent('alertify-success', [
            'message' => 'Laporan kehadiran dimuat'
        ]);
    }
    
    public function render()
    {
        return view('livewire.laporan.daerah.kegiatan-event.report');
    }
}
