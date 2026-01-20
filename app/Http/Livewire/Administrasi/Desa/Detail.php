<?php

namespace App\Http\Livewire\Administrasi\Desa;

use App\Models\Desa;
use Livewire\Component;

class Detail extends Component
{
    public $desa;

    protected $listeners = [
        'detailDesa'
    ];

    public function detailDesa($desaId)
    {
        $this->desa = Desa::withCount('ms_kelompok')->find($desaId);

        if (!$this->desa) {
            $this->dispatchBrowserEvent('alertify-error', ['message' => 'Data desa tidak ditemukan']);
            return;
        }

        $this->dispatchBrowserEvent('alertify-success', ['message' => 'Data Desa ditampilkan']);
    }

    public function render()
    {
        return view('livewire.administrasi.desa.detail');
    }
}
