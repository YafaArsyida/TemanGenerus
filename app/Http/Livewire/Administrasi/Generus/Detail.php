<?php

namespace App\Http\Livewire\Administrasi\Generus;

use App\Models\Generus;
use Livewire\Component;

class Detail extends Component
{
    public $generus;

    protected $listeners = [
        'GenerusDetail'
    ];

    public function GenerusDetail($generusId)
    {
        $this->generus = Generus::with('ms_kelompok.ms_desa')
            ->find($generusId);

        if (!$this->generus) {
            $this->dispatchBrowserEvent('alertify-error', [
                'message' => 'Data Generus tidak ditemukan'
            ]);
            return;
        }

        $this->dispatchBrowserEvent('alertify-success', [
            'message' => 'Data Generus ditampilkan'
        ]);
    }

    public function render()
    {
        return view('livewire.administrasi.generus.detail');
    }
}
