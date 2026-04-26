<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Kelompok;
use Livewire\Component;

class TotalKelompok extends Component
{
    public $selectedDesa = null;
    public $totalKelompok = 0;

    protected $listeners = [
        'parameterUpdated',
        'KelompokIndex' => '$refresh',
    ];

    public function mount()
    {
        $this->loadData();
    }

    public function parameterUpdated($desaId)
    {
        $this->selectedDesa = $desaId;
        $this->loadData();
    }

    public function loadData()
    {
        $query = Kelompok::query();

        if ($this->selectedDesa) {
            $query->where('ms_desa_id', $this->selectedDesa);
        }

        $this->totalKelompok = $query->count();
    }

    public function render()
    {
        return view('livewire.dashboard.total-kelompok');
    }
}
