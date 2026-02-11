<?php

namespace App\Http\Livewire\Laporan\Daerah\KegiatanEvent\Report;

use App\Models\Desa;
use App\Models\Kelompok;
use App\Models\PresensiKegiatan;
use Livewire\Component;
use Livewire\WithPagination;

class Attendance extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $ms_kegiatan_id;

    public $search = '';
    public $gender = '';

    public $ms_desa_id = null;
    public $ms_kelompok_id = null;

    public $listDesa = [];
    public $listKelompok = [];

    protected $listeners = [
        'setKegiatan' => 'setKegiatan',
    ];

    public function mount($kegiatanId = null)
    {
        $this->ms_kegiatan_id = $kegiatanId;
        $this->listDesa = Desa::orderBy('nama_desa')->get();
    }

    public function setKegiatan($kegiatanId)
    {
        $this->ms_kegiatan_id = $kegiatanId;
        // $this->listDesa = Desa::orderBy('nama_desa')->get();

        $this->resetPage();
    }

    public function updatedKegiatanId($value)
    {
        $this->ms_kegiatan_id = $value;
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedMsDesaId($value)
    {
        $this->ms_kelompok_id = null; // reset kelompok
        $this->resetPage();

        if ($value) {
            $this->listKelompok = Kelompok::where('ms_desa_id', $value)
                ->orderBy('nama_kelompok')
                ->get();
        } else {
            $this->listKelompok = [];
        }
    }

    public function updatingMsKelompokId()
    {
        $this->resetPage();
    }

    public function updatingGender()
    {
        $this->resetPage();
    }

    public function getPresensiProperty()
    {
        return PresensiKegiatan::with([
            'ms_generus.ms_kelompok.ms_desa'
        ])
            ->where('ms_kegiatan_id', $this->ms_kegiatan_id)

            ->when($this->search, function ($q) {
                $q->whereHas('ms_generus', function ($qq) {
                    $qq->where('nama_generus', 'like', '%' . $this->search . '%');
                });
            })

            ->when($this->gender, function ($q) {
                $q->whereHas('ms_generus', function ($qq) {
                    $qq->where('jenis_kelamin', $this->gender);
                });
            })

            ->when($this->ms_desa_id, function ($q) {
                $q->whereHas('ms_generus.ms_kelompok', function ($qq) {
                    $qq->where('ms_desa_id', $this->ms_desa_id);
                });
            })

            ->when($this->ms_kelompok_id, function ($q) {
                $q->whereHas('ms_generus', function ($qq) {
                    $qq->where('ms_kelompok_id', $this->ms_kelompok_id);
                });
            })

            ->orderBy('waktu_hadir', 'desc')
            ->paginate(50);
    }

    public function render()
    {
        return view('livewire.laporan.daerah.kegiatan-event.report.attendance',[
            'presensi' => $this->presensi,
            'listDesa' => $this->listDesa,
            'listKelompok' => $this->listKelompok,
        ]);
    }
}
