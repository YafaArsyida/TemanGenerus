<?php

namespace App\Http\Livewire\Laporan\Kelompok\KegiatanEvent\Report;

use App\Models\Kelompok;
use App\Models\PresensiKegiatan;
use Livewire\Component;
use Livewire\WithPagination;

class Attendance extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // =====================
    // CONTEXT
    // =====================
    public $ms_kegiatan_id;
    public $ms_kelompok_id;

    public $nama_kelompok = '-';
    public $nama_desa = '-';

    // =====================
    // FILTER UX
    // =====================
    public $search = '';
    public $gender = '';

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
        $this->ms_kelompok_id = $kelompokId;

        $kelompok = Kelompok::with('ms_desa')->find($kelompokId);

        $this->nama_kelompok = $kelompok?->nama_kelompok ?? '-';
        $this->nama_desa     = $kelompok?->ms_desa?->nama_desa ?? '-';

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

    public function getPresensiProperty()
    {
        return PresensiKegiatan::with([
            'ms_generus.ms_kelompok.ms_desa'
        ])
            ->where('ms_kegiatan_id', $this->ms_kegiatan_id)

            // 🔒 LOCK KELOMPOK
            ->whereHas('ms_generus', fn($q) =>
                $q->where('ms_kelompok_id', $this->ms_kelompok_id)
            )

            ->when($this->search, fn($q) =>
                $q->whereHas('ms_generus', fn($qq) =>
                    $qq->where('nama_generus', 'like', "%{$this->search}%")
                )
            )

            ->when($this->gender, fn($q) =>
                $q->whereHas(
                    'ms_generus',
                    fn($qq) =>
                    $qq->where('jenis_kelamin', $this->gender)
                )
            )

            ->orderByDesc('waktu_hadir')
            ->paginate(50);
    }

    public function render()
    {
        return view('livewire.laporan.kelompok.kegiatan-event.report.attendance',[
            'presensi' => $this->presensi,
        ]);
    }
}
