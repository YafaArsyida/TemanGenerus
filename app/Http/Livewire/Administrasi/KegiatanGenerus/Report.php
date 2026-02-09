<?php

namespace App\Http\Livewire\Administrasi\KegiatanGenerus;

use App\Models\Kegiatan;
use App\Models\PresensiKegiatan;
use Illuminate\Support\Collection;
use Livewire\Component;

class Report extends Component
{
    protected $listeners = [
        'KegiatanReport' => 'loadReport'
    ];

    public $kegiatan;
    // public $presensi = [];

    public Collection $presensi;

    public int $totalHadir = 0;
    public int $totalIzin = 0;
    
    public $targetPeserta = 0;

    public $persentaseHadir = 0;

    public function mount()
    {
        $this->presensi = collect();
    }

    public function loadReport($kegiatanId)
    {
        $this->kegiatan = Kegiatan::with([
            'ms_desa',
            'ms_kelompok.ms_desa'
        ])->find($kegiatanId);

        if (!$this->kegiatan) {
            $this->dispatchBrowserEvent('alertify-error', [
                'message' => 'Data kegiatan tidak ditemukan'
            ]);
            return;
        }

        // Label hari rutin
        if ($this->kegiatan->tipe_kegiatan === 'rutin' && is_array($this->kegiatan->hari_rutin)) {
            $listHari = [
                'senin'  => 'Senin',
                'selasa' => 'Selasa',
                'rabu'   => 'Rabu',
                'kamis'  => 'Kamis',
                'jumat'  => 'Jumat',
                'sabtu'  => 'Sabtu',
                'minggu' => 'Minggu',
            ];

            $this->kegiatan->hari_rutin_label = collect($this->kegiatan->hari_rutin)
                ->map(fn($h) => $listHari[$h] ?? $h)
                ->implode(', ');
        } else {
            $this->kegiatan->hari_rutin_label = null;
        }

        // Ambil data presensi
        $this->presensi = PresensiKegiatan::with([
            'ms_generus.ms_kelompok'
        ])
            ->where('ms_kegiatan_id', $kegiatanId)
            ->orderBy('waktu_hadir', 'asc')
            ->get();

        $this->totalHadir = $this->presensi->where('status_hadir', 'hadir')->count();
        $this->totalIzin  = $this->presensi->where('status_hadir', 'izin')->count();

        // Target peserta (reuse logic dari komponen detail)
        $this->targetPeserta = app(\App\Http\Livewire\Administrasi\KegiatanGenerus\Detail::class)
            ->hitungTargetPeserta($this->kegiatan);

        $this->persentaseHadir = $this->targetPeserta > 0
            ? round(($this->totalHadir / $this->targetPeserta) * 100, 1)
            : 0;

        $this->dispatchBrowserEvent('alertify-success', [
            'message' => 'Laporan kehadiran dimuat'
        ]);
    }   
    public function render()
    {
        return view('livewire.administrasi.kegiatan-generus.report');
    }
}
