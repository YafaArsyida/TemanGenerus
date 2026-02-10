<?php

namespace App\Http\Livewire\Laporan\KegiatanEvent;

use App\Models\Kegiatan;
use Livewire\Component;

class Report extends Component
{
    public $kegiatan;

    protected $listeners = [
        'KegiatanReport' => 'loadReport'
    ];

    public function loadReport($kegiatanId)
    {
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

        // Label hari rutin
        if ($this->kegiatan->tipe_kegiatan === 'rutin' && is_array($this->kegiatan->hari_rutin)) {
            $listHari = [
                'senin'  => 'Senin',
                'selasa' => 'Selasa',
                'rabu'   => 'Rabu',
                'kamis'  => 'Kamis',
                'jumat'  => 'Jumat',
                'sabtu'  => 'Sabtu',
                'minggu' => 'Minggu',
            ];

            $this->kegiatan->hari_rutin_label = collect($this->kegiatan->hari_rutin)
                ->map(fn($h) => $listHari[$h] ?? $h)
                ->implode(', ');
        } else {
            $this->kegiatan->hari_rutin_label = null;
        }

        $this->dispatchBrowserEvent('alertify-success', [
            'message' => 'Laporan kehadiran dimuat'
        ]);
    }
    public function render()
    {
        return view('livewire.laporan.kegiatan-event.report');
    }
}
