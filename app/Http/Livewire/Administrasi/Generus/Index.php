<?php

namespace App\Http\Livewire\Administrasi\Generus;

use App\Models\Generus;
use App\Models\Kelompok;
use Livewire\Component;

class Index extends Component
{
    public $namaDesa = '';
    public $selectedDesa = null;
    
    public $search = '';
    public $gender = '';
    public $jenjangUsia = '';

    public $activeTab = 'semua';
    
    protected $listeners = [
        'parameterUpdated',
        'GenerusIndex' => '$refresh',
    ];

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    /**
     * Terima parameter dari @livewire('parameter.desa')
     */
    public function parameterUpdated($desaId)
    {
        $this->selectedDesa = $desaId;
        $this->activeTab = 'semua';
    }

    public function getKelompokProperty()
    {
        if (!$this->selectedDesa) {
            return collect();
        }

        return Kelompok::where('ms_desa_id', $this->selectedDesa)
            ->orderBy('nama_kelompok')
            ->get();
    }

    public function getAllGenerusProperty()
    {
        $query = Generus::with(['ms_kelompok.ms_desa']);

        // Filter by desa
        if ($this->selectedDesa) {
            $query->whereHas('ms_kelompok', function ($q) {
                $q->where('ms_desa_id', $this->selectedDesa);
            });
        }

        // Search
        if ($this->search) {
            $query->where('nama_generus', 'like', "%{$this->search}%");
        }

        // Filter Jenis Kelamin
        if ($this->gender) {
            $query->where('jenis_kelamin', $this->gender);
        }

        // Filter Jenjang Usia
        if ($this->jenjangUsia) {
            [$min, $max] = Generus::jenjangUsiaMap()[$this->jenjangUsia];

            $query->whereRaw("
                TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE())
                BETWEEN ? AND ?
            ", [$min, $max]);
        }
        return $query->orderBy('nama_generus')->get();
    }

    public function render()
    {
        $kelompok = $this->kelompok;
        $allGenerus = $this->allGenerus;

        return view('livewire.administrasi.generus.index',[
            'kelompok' => $kelompok,
            'allGenerus' => $allGenerus
        ]);
    }
}
