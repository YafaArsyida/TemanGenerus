<?php

namespace App\Http\Livewire\Laporan\Desa\KegiatanEvent;

use App\Models\Kegiatan;
use App\Models\Kelompok;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $ms_desa_id;

    // Filter
    public $search = '';
    public $jenjangUsia = '';
    public $startDate;
    public $endDate;

    protected $listeners = [
        'parameterUpdated' => 'setParameterDesa'
    ];

    public function mount()
    {
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate   = now()->endOfMonth()->format('Y-m-d');
    }

    public function setParameterDesa($desaId)
    {
        $this->ms_desa_id = $desaId;
        $this->resetPage();
    }

    public function updating($property)
    {
        if ($property !== 'page') {
            $this->resetPage();
        }
    }

    public function resetTanggal()
    {
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate   = now()->endOfMonth()->format('Y-m-d');

        $this->dispatchBrowserEvent('alertify-success', [
            'message' => 'Periode diperbarui'
        ]);
    }

    public function getQueryProperty()
    {
        if (!$this->ms_desa_id) {
            // kalau desa belum dipilih, kosongkan dulu (biar UX jelas)
            return Kegiatan::whereRaw('1 = 0');
        }

        return Kegiatan::with(['ms_desa'])
            ->where('tipe_kegiatan', 'sekali')
            ->where(function ($q) {
                $q->where('scope', 'daerah') // event daerah selalu tampil
                    ->orWhere(function ($qq) {
                        $qq->where('scope', 'desa')
                            ->where('ms_desa_id', $this->ms_desa_id); // event desa terpilih
                    });
            })

            ->when(
                $this->search,
                fn($q) =>
                $q->where('nama_kegiatan', 'like', "%{$this->search}%")
            )

            ->when(
                $this->jenjangUsia,
                fn($q) =>
                $q->where('jenjang', $this->jenjangUsia)
            )

            ->when(
                $this->startDate && $this->endDate,
                fn($q) =>
                $q->whereBetween('tanggal', [$this->startDate, $this->endDate])
            )

            ->orderByRaw("
                CASE 
                    WHEN scope = 'daerah' THEN 0
                    ELSE 1
                END,
                tanggal DESC
            ");
    }

    public function render()
    {
        return view('livewire.laporan.desa.kegiatan-event.index', [
            'data' => $this->query->paginate(50)
        ]);
    }
}
