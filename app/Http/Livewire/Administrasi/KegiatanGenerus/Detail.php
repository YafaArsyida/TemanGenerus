<?php

namespace App\Http\Livewire\Administrasi\KegiatanGenerus;

use App\Models\Kegiatan;
use Livewire\Component;

class Detail extends Component
{
    public $kegiatan;

    protected $listeners = [
        'KegiatanDetail'
    ];

    public function KegiatanDetail($kegiatanId)
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

        $this->dispatchBrowserEvent('alertify-success', [
            'message' => 'Detail kegiatan ditampilkan'
        ]);
    }

    public function render()
    {
        return view('livewire.administrasi.kegiatan-generus.detail');
    }
}
