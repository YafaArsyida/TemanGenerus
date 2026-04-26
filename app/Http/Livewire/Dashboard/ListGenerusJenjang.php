<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Generus;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class ListGenerusJenjang extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $selectedDesa = null;
    public $jenjangUsia = null;
    public $search = null;

    protected $listeners = [
        'parameterUpdated' => 'setDesa'
    ];

    public function setDesa($desaId)
    {
        $this->selectedDesa = $desaId;
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingJenjangUsia()
    {
        $this->resetPage();
    }

    public function getGenerusProperty()
    {
        $query = Generus::with('ms_kelompok.ms_desa');

        // Filter desa
        if ($this->selectedDesa) {
            $query->whereHas('ms_kelompok', function ($q) {
                $q->where('ms_desa_id', $this->selectedDesa);
            });
        }

        // Search
        if ($this->search) {
            $query->where('nama_generus', 'like', "%{$this->search}%");
        }

        // Filter Jenjang Usia
        if ($this->jenjangUsia) {
            [$min, $max] = Generus::jenjangUsiaMap()[$this->jenjangUsia];

            $startDate = now()->subYears($max)->startOfDay();
            $endDate   = now()->subYears($min)->endOfDay();

            $query->whereBetween('tanggal_lahir', [$startDate, $endDate]);
        }

        return $query->orderBy('nama_generus')->paginate(20);
    }

    public function render()
    {
        return view('livewire.dashboard.list-generus-jenjang',[
            'data' => $this->generus
        ]);
    }
}
