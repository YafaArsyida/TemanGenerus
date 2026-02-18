<?php

namespace App\Http\Livewire\Laporan\Kelompok\KegiatanEvent\Report;

use App\Models\Kegiatan;
use App\Models\Kelompok;
use App\Models\PresensiKegiatan;
use Livewire\Component;
use Livewire\WithPagination;

class Alfa extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $ms_kegiatan_id;

    public $search;
    public $gender;
    public $ms_desa_id;
    public $ms_kelompok_id;

    public $nama_kelompok = null;

    protected $listeners = [
        'setKegiatan' => 'setKegiatan',
    ];

    public function mount($kegiatanId = null)
    {
        $this->ms_kegiatan_id = $kegiatanId;
    }

    public function setKegiatan($kegiatanId, $kelompokId)
    {
        $this->ms_kegiatan_id = $kegiatanId;

        // ===== MODE KELOMPOK =====
        if (Kelompok::where('ms_kelompok_id', $kelompokId)->exists()) {

            $kelompok = Kelompok::with('ms_desa')->find($kelompokId);

            $this->ms_kelompok_id = $kelompok->ms_kelompok_id;
            $this->ms_desa_id     = $kelompok->ms_desa_id;
            $this->nama_kelompok  = $kelompok->nama_kelompok;
        }
        // ===== MODE DESA =====
        else {

            $this->ms_desa_id = $kelompokId;
            $this->ms_kelompok_id = null;
            $this->nama_kelompok = null;
        }

        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingMsKelompokId()
    {
        $this->resetPage();
    }

    public function updatingGender()
    {
        $this->resetPage();
    }

    public function getAlfaProperty()
    {
        $kegiatan = Kegiatan::findOrFail($this->ms_kegiatan_id);

        // Ambil target peserta sesuai scope + jenjang
        $targetQuery = $kegiatan->targetPesertaQuery();

        // Ambil generus yang sudah presensi (hadir / izin / sakit)
        $hadirIds = PresensiKegiatan::select('ms_generus_id')
            ->where('ms_kegiatan_id', $this->ms_kegiatan_id);

        // ALFA = target - yang presensi
        $query = $targetQuery->whereNotIn('ms_generus_id', $hadirIds);

        // 🔎 Filter UX tambahan
        if ($this->search) {
            $query->where('nama_generus', 'like', "%{$this->search}%");
        }

        if ($this->gender) {
            $query->where('jenis_kelamin', $this->gender);
        }

        if ($this->ms_kelompok_id && $this->ms_desa_id) {
            $query->where('ms_kelompok_id', $this->ms_kelompok_id);
        }

        return $query->orderBy('nama_generus')->paginate(50);
    }

    public function render()
    {
        return view('livewire.laporan.kelompok.kegiatan-event.report.alfa',[
            'alfa' => $this->alfa,
        ]);
    }
}
