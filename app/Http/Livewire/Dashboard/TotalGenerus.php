<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Generus;
use Livewire\Component;

class TotalGenerus extends Component
{
    public $selectedDesa = null;
    public $totalGenerus = 0;

    protected $listeners = [
        'parameterUpdated',
        'GenerusIndex' => '$refresh',
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
        $query = Generus::query()
            ->whereHas('ms_kelompok', function ($q) {
                if ($this->selectedDesa) {
                    $q->where('ms_desa_id', $this->selectedDesa);
                }
            });

        $this->totalGenerus = $query->count();
    }

    public function render()
    {
        return view('livewire.dashboard.total-generus');
    }
}
