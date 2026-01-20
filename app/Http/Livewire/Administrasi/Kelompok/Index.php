<?php

namespace App\Http\Livewire\Administrasi\Kelompok;

use App\Models\Desa;
use App\Models\Kelompok;
use Livewire\Component;

class Index extends Component
{
    public $search = '';
    public $namaDesa = '';
    public $selectedDesa = null;

    public $activeTab = 'semua'; // default tab

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    protected $listeners = [
        'KelompokIndex' => '$refresh',
        'filterDesa' => 'setDesa',
    ];

    public function setDesa($ms_desa_id)
    {
        $this->selectedDesa = $ms_desa_id;
    }

    public function render()
    {
        $query = Kelompok::with('ms_desa')->orderBy('nama_kelompok');

        if ($this->selectedDesa) {
            $query->where('ms_desa_id', $this->selectedDesa);
        }

        if ($this->search) {
            $query->where('nama_kelompok', 'like', '%' . $this->search . '%');
        }

        $allKelompok = $query->get();

        // ini untuk tab (kategori = desa)
        $desa = Desa::orderBy('nama_desa')->get();

        return view('livewire.administrasi.kelompok.index', [
            'allKelompok' => $allKelompok,
            'desa' => $desa,
        ]);
    }
}
