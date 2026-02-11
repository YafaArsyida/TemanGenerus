<?php

namespace App\Http\Livewire\Laporan\Daerah\KegiatanEvent;

use App\Models\Kegiatan;
use App\Models\Kelompok;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Filter
    public $search = '';
    public $jenjangUsia = '';
    public $startDate;
    public $endDate;

    protected $listeners = [
        'KegiatanIndex' => '$refresh',
    ];

    public function mount()
    {
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate   = now()->endOfMonth()->format('Y-m-d');
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
        $query = Kegiatan::query()
            ->with(['ms_desa', 'ms_kelompok.ms_desa'])
            ->where('scope', 'daerah')        // 🔒 khusus daerah
            ->where('tipe_kegiatan', 'sekali'); // 🔒 khusus event

        // Search nama kegiatan
        if ($this->search) {
            $query->where('nama_kegiatan', 'like', "%{$this->search}%");
        }

        // Filter jenjang
        if ($this->jenjangUsia) {
            $query->where('jenjang', $this->jenjangUsia);
        }

        // Filter periode event
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('tanggal', [$this->startDate, $this->endDate]);
        }

        return $query->orderBy('tanggal', 'desc');
    }

    public function render()
    {
        return view('livewire.laporan.daerah.kegiatan-event.index',[
            'data' => $this->query->paginate(100)
        ]);
    }
}
