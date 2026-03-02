<?php

namespace App\Http\Livewire\Laporan\Kelompok\KegiatanRutin;

use App\Models\Kegiatan;
use App\Models\Kelompok;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Collection;


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

    public $hari = '';

    protected $listeners = [
        'parameterUpdated' => 'setParameterDesa'
    ];

    public function mount()
    {
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
            ->where('tipe_kegiatan', 'rutin')
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
                $this->hari,
                fn($q) =>
                $q->whereJsonContains('hari_rutin', $this->hari)
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
        return view('livewire.laporan.kelompok.kegiatan-rutin.index',[
            'data' => $this->query->paginate(50)
        ]);
    }
}
