<?php

namespace App\Http\Livewire\Laporan\KegiatanEvent\Report;

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
    public $kelompokGenerus = '';

    protected $listeners = [
        'KegiatanReport' => 'loadReport'
    ];

    public function loadReport($kegiatanId)
    {
        $this->ms_kegiatan_id = $kegiatanId;

        // reset filter & pagination biar fresh
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingGender()
    {
        $this->resetPage();
    }

    public function updatingKelompokGenerus()
    {
        $this->resetPage();
    }

    public function getPresensiProperty()
    {
        return PresensiKegiatan::with([
            'ms_generus.ms_kelompok'
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
            ->when($this->kelompokGenerus, function ($q) {
                $q->whereHas('ms_generus', function ($qq) {
                    $qq->where('ms_kelompok_id', $this->kelompokGenerus);
                });
            })
            ->orderBy('waktu_hadir', 'desc')
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.laporan.kegiatan-event.report.attendance',[
            'presensi' => $this->presensi,
            'listKelompok' => Kelompok::orderBy('nama_kelompok')->get(),
        ]);
    }
}
