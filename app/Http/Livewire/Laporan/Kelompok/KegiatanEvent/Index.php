<?php

namespace App\Http\Livewire\Laporan\Kelompok\KegiatanEvent;

use App\Models\Kegiatan;
use App\Models\Kelompok;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $ms_desa_id;
    public $ms_kelompok_id;

    public Collection $listKelompok;

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

        $this->listKelompok = collect(); // penting
    }

    public function setParameterDesa($desaId)
    {
        $this->ms_desa_id = $desaId;
        $this->ms_kelompok_id = null;
        $this->loadKelompok();
        $this->resetPage();
    }

    public function loadKelompok()
    {
        if (!$this->ms_desa_id) {
            $this->listKelompok = collect(); 
            $this->ms_kelompok_id = null;
            return;
        }

        $this->listKelompok = Kelompok::where('ms_desa_id', $this->ms_desa_id)
            ->orderBy('nama_kelompok')
            ->get();

        // AUTO PILIH KELOMPOK PERTAMA
        $this->ms_kelompok_id = $this->listKelompok->first()->ms_kelompok_id ?? null;
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

                // EVENT DAERAH → semua kelompok ikut
                $q->where('scope', 'daerah')

                    // EVENT DESA → hanya desa kelompok
                    ->orWhere(function ($qq) {
                        $qq->where('scope', 'desa')
                            ->where('ms_desa_id', $this->ms_desa_id);
                    })

                    // EVENT KELOMPOK → hanya kelompok ini
                    ->orWhere(function ($qqq) {
                        $qqq->where('scope', 'kelompok')
                            ->where('ms_kelompok_id', $this->ms_kelompok_id);
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

            // urutan penting: kelompok > desa > daerah > terbaru
            ->orderByRaw("
                CASE 
                    WHEN scope = 'kelompok' THEN 0
                    WHEN scope = 'desa' THEN 1
                    ELSE 2
                END,
                tanggal DESC
            ");
    }

    public function render()
    {
        return view('livewire.laporan.kelompok.kegiatan-event.index',[
            'data' => $this->query->paginate(50)
        ]);
    }
}
