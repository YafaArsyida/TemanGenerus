<?php

namespace App\Http\Livewire\Administrasi\Kelompok;

use App\Models\Kelompok;
use Livewire\Component;

class Detail extends Component
{
    public $kelompok;

    protected $listeners = [
        'KelompokDetail',
    ];

    public function KelompokDetail($kelompokId)
    {
        // Load data kelompok beserta nama desanya
        $this->kelompok = Kelompok::with('ms_desa')->find($kelompokId);

        if (!$this->kelompok) {
            $this->dispatchBrowserEvent('alertify-error', [
                'message' => 'Data Kelompok tidak ditemukan'
            ]);
            return;
        }

        $this->dispatchBrowserEvent('alertify-success', [
            'message' => 'Data Kelompok ditampilkan'
        ]);
    }


    public function render()
    {
        return view('livewire.administrasi.kelompok.detail');
    }
}
