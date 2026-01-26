<?php

namespace App\Http\Livewire\Administrasi\KegiatanGenerus;

use App\Models\Kegiatan;
use App\Models\Kelompok;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Parameter Desa dari komponen parameter.desa
    public $ms_desa_id = null;

    // Filter
    public $search;
    public $status;
    public $scope;
    public $tipeKegiatan = ''; // rutin | sekali

    public $ms_kelompok_id;
    public $jenjangUsia = '';

    public $startDate = null;
    public $endDate = null;

    public $listKelompok = [];

    protected $listeners = [
        'KegiatanIndex' => '$refresh',
        'parameterUpdated' => 'setParameterDesa'
    ];

    public function mount()
    {
        // Default ke hari ini
        // $this->startDate = now()->format('Y-m-d');
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate   = now()->endOfMonth()->format('Y-m-d');
    }


    public function updatedStartDate()
    {
        $this->dispatchBrowserEvent('alertify-success', [
            'message' => 'Periode mulai diperbarui'
        ]);
    }

    public function updatedEndDate()
    {
        $this->dispatchBrowserEvent('alertify-success', [
            'message' => 'Periode selesai diperbarui'
        ]);
    }


    public function updating($property)
    {
        if (!in_array($property, ['page'])) {
            $this->resetPage();
        }
    }

    public function setParameterDesa($desaId)
    {
        $this->ms_desa_id = $desaId;
        $this->ms_kelompok_id = null;
        $this->loadKelompok();
    }

    public function loadKelompok()
    {
        if (!$this->ms_desa_id) {
            $this->listKelompok = [];
            return;
        }

        $this->listKelompok = Kelompok::where('ms_desa_id', $this->ms_desa_id)
            ->orderBy('nama_kelompok')
            ->get();
    }

    public function resetTanggal()
    {
        // $this->startDate = now()->format('Y-m-d');
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate   = now()->endOfMonth()->format('Y-m-d');

        $this->loadKelompok();
        $this->dispatchBrowserEvent('alertify-success', ['message' => 'Memperbarui...']);
    }

    public function getQueryProperty()
    {
        $query = Kegiatan::query()
            ->with(['ms_desa', 'ms_kelompok.ms_desa']); // eager load

        // VISIBILITY RULE
        $query->where(function ($q) {
            $q->where('scope', 'daerah'); // selalu tampil
            if ($this->ms_desa_id) {
                $q->orWhere(
                    fn($qq) => $qq
                        ->where('scope', 'desa')
                        ->where('ms_desa_id', $this->ms_desa_id)
                );
            }

            $q->orWhere(function ($qq) {
                $qq->where('scope', 'kelompok');
                if ($this->ms_kelompok_id) {
                    $qq->where('ms_kelompok_id', $this->ms_kelompok_id);
                } elseif ($this->ms_desa_id) {
                    $qq->whereIn('ms_kelompok_id', function ($sub) {
                        $sub->select('ms_kelompok_id')
                            ->from('ms_kelompok')
                            ->where('ms_desa_id', $this->ms_desa_id);
                    });
                }
            });
        });

        // FILTER TAMBAHAN
        if ($this->search) {
            $query->where('nama_kegiatan', 'like', "%{$this->search}%");
        }

        if ($this->tipeKegiatan) {
            $query->where('tipe_kegiatan', $this->tipeKegiatan);
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        if ($this->scope) {
            $query->where('scope', $this->scope);
        }

        // Filter Jenjang
        if ($this->jenjangUsia) {
            $query->where('jenjang', $this->jenjangUsia);
        }

        // FILTER PERIODE
        if ($this->startDate && $this->endDate) {
            $query->where(function ($q) {
                $q->where('tipe_kegiatan', 'rutin') // selalu tampil
                    ->orWhereBetween('tanggal', [$this->startDate, $this->endDate]);
            });
        }

        return $query->orderByRaw("
            CASE 
                WHEN tipe_kegiatan = 'rutin' THEN 0 
                ELSE 1 
            END,
            tanggal ASC
        ");
    }

    public function render()
    {
        return view('livewire.administrasi.kegiatan-generus.index',[
            'listKegiatan' => $this->query->paginate(100)
        ]);
    }
}
