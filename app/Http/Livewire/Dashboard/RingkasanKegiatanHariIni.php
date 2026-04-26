<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Kegiatan;
use App\Models\PresensiKegiatan;
use Carbon\Carbon;
use Livewire\Component;

class RingkasanKegiatanHariIni extends Component
{
    public $selectedDesa = null;
    public $selectedKegiatan = null;

    public $listKegiatan = [];

    public $hadir = 0;
    public $izin = 0;
    public $alfa = 0;

    protected $listeners = [
        'parameterUpdated'
    ];

    public function mount()
    {
        $this->loadKegiatan();
    }

    public function parameterUpdated($desaId)
    {
        $this->resetSummary();
        $this->selectedDesa = $desaId;
        $this->selectedKegiatan = null;

        $this->loadKegiatan();
    }

    public function updatedSelectedKegiatan()
    {
        $this->loadSummary();
    }

    private function loadKegiatan()
    {
        if (!$this->selectedDesa) {
            $this->listKegiatan = [];
            return;
        }

        $this->listKegiatan = Kegiatan::query()
            ->where('ms_desa_id', $this->selectedDesa)
            // ->whereDate('tanggal', Carbon::today())
            ->whereBetween('tanggal', [
                now()->startOfMonth(),
                now()->endOfMonth()
            ])
            ->orderBy('waktu')
            ->get();
    }

    private function loadSummary()
    {
        if (!$this->selectedKegiatan) {
            $this->resetSummary();
            return;
        }

        $query = PresensiKegiatan::where('ms_kegiatan_id', $this->selectedKegiatan);

        $this->hadir = (clone $query)->where('status_hadir', 'hadir')->count();
        $this->izin = (clone $query)->where('status_hadir', 'izin')->count();
        $this->alfa = (clone $query)->whereNull('waktu_hadir')->count();
    }

    private function resetSummary()
    {
        $this->hadir = 0;
        $this->izin = 0;
        $this->alfa = 0;
    }
    public function render()
    {
        return view('livewire.dashboard.ringkasan-kegiatan-hari-ini');
    }
}
