<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\PresensiKegiatan;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class RankingKehadiranGenerus extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $selectedDesa = null;
    public $periode = '1bulan'; // default

    protected $listeners = [
        'parameterUpdated' => 'setDesa'
    ];

    public function setDesa($desaId)
    {
        $this->selectedDesa = $desaId;
        $this->resetPage();
    }

    public function updatingPeriode()
    {
        $this->resetPage();
    }

    private function getRangeTanggal()
    {
        return match ($this->periode) {
            '1bulan' => [now()->subMonth(), now()],
            '3bulan' => [now()->subMonths(3), now()],
            '1tahun' => [now()->subYear(), now()],
            default  => [now()->subMonth(), now()],
        };
    }

    public function getDataProperty()
    {
        [$start, $end] = $this->getRangeTanggal();

        return PresensiKegiatan::query()
            ->select(
                'ms_generus_id',
                DB::raw('COUNT(*) as total_hadir')
            )
            ->with(['ms_generus.ms_kelompok'])
            ->whereBetween('tanggal_presensi', [$start, $end])
            ->where('status_hadir', 'hadir')
            ->whereHas('ms_generus.ms_kelompok', function ($q) {
                if ($this->selectedDesa) {
                    $q->where('ms_desa_id', $this->selectedDesa);
                }
            })
            ->groupBy('ms_generus_id')
            ->orderByDesc('total_hadir')
            ->paginate(20);
    }

    public function render()
    {
        return view('livewire.dashboard.ranking-kehadiran-generus',[
            'data' => $this->data
        ]);
    }
}
