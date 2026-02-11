<?php

namespace App\Http\Livewire\Laporan\Desa\KegiatanEvent;

use App\Models\Desa;
use App\Models\Generus;
use App\Models\Kegiatan;
use App\Models\PresensiKegiatan;
use Livewire\Component;

class Report extends Component
{
    // ==============================
    // STATE (INPUT / KONTEXT AKTIF)
    // ==============================
    public $kegiatan;
    public $kegiatanId;
    public $ms_desa_id;
    public $nama_desa = '-';

    public $insightDesa = '-';

    protected $listeners = [
        'KegiatanReport' => 'loadReport'
    ];

    // ==============================
    // EVENT HANDLER
    // ==============================
    public function loadReport($kegiatanId, $desaId)
    {
        $this->kegiatanId = $kegiatanId;
        $this->ms_desa_id = $desaId;

        // Ambil data desa
        $desa = Desa::find($desaId);
        $this->nama_desa = $desa?->nama_desa ?? '-';

        // Load kegiatan + relasi
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

        // Broadcast parameter ke child component
        $this->emitTo(
            'laporan.desa.kegiatan-event.report.attendance',
            'setKegiatan',
            $kegiatanId,
            $this->ms_desa_id
        );

        $this->emitTo(
            'laporan.desa.kegiatan-event.report.alfa',
            'setKegiatan',
            $kegiatanId,
            $this->ms_desa_id
        );

        // Generate insight awal
        $this->generateInsightDesa();

        $this->dispatchBrowserEvent('alertify-success', [
            'message' => 'Laporan kehadiran dimuat'
        ]);
    }

    // ==============================
    // SCOPE HELPER (UNTUK VIEW)
    // ==============================
    public function getIsScopeDaerahProperty()
    {
        return $this->kegiatan?->scope === 'daerah';
    }

    public function getIsScopeDesaProperty()
    {
        return $this->kegiatan?->scope === 'desa';
    }

    public function getIsScopeKelompokProperty()
    {
        return $this->kegiatan?->scope === 'kelompok';
    }

    // ==============================
    // STATISTIK DESA (COMPUTED)
    // ==============================

    /**
     * Target peserta khusus desa
     * Mengikuti scope + jenjang dari kegiatan
     */
    public function getTargetDesaProperty()
    {
        if (!$this->kegiatan || !$this->ms_desa_id) return 0;

        return $this->kegiatan
            ->targetPesertaQuery()
            ->whereHas(
                'ms_kelompok',
                fn($q) =>
                $q->where('ms_desa_id', $this->ms_desa_id)
            )
            ->count();
    }

    /**
     * Total hadir dari desa ini
     */
    public function getHadirDesaProperty()
    {
        if (!$this->kegiatanId || !$this->ms_desa_id) return 0;

        return PresensiKegiatan::where('ms_kegiatan_id', $this->kegiatanId)
            ->where('status_hadir', 'hadir')
            ->whereHas(
                'ms_generus.ms_kelompok',
                fn($q) =>
                $q->where('ms_desa_id', $this->ms_desa_id)
            )
            ->count();
    }

    /**
     * Total izin dari desa ini
     */
    public function getIzinDesaProperty()
    {
        if (!$this->kegiatanId || !$this->ms_desa_id) return 0;

        return PresensiKegiatan::where('ms_kegiatan_id', $this->kegiatanId)
            ->where('status_hadir', 'izin')
            ->whereHas(
                'ms_generus.ms_kelompok',
                fn($q) =>
                $q->where('ms_desa_id', $this->ms_desa_id)
            )
            ->count();
    }

    /**
     * Alfa desa = target desa - (hadir + izin + sakit)
     */
    public function getAlfaDesaProperty()
    {
        if (!$this->kegiatanId || !$this->ms_desa_id) return 0;

        $hadirIzin = PresensiKegiatan::where('ms_kegiatan_id', $this->kegiatanId)
            ->whereIn('status_hadir', ['hadir', 'izin', 'sakit'])
            ->whereHas(
                'ms_generus.ms_kelompok',
                fn($q) =>
                $q->where('ms_desa_id', $this->ms_desa_id)
            )
            ->count();

        return max(0, $this->targetDesa - $hadirIzin);
    }

    /**
     * Presentase hadir desa
     */
    public function getPresentaseHadirDesaProperty()
    {
        if ($this->targetDesa == 0) return 0;

        return round(($this->hadirDesa / $this->targetDesa) * 100, 1);
    }

    /**
     * Presentase izin desa
     */
    public function getPresentaseIzinDesaProperty()
    {
        if ($this->targetDesa == 0) return 0;

        return round(($this->izinDesa / $this->targetDesa) * 100, 1);
    }

    /**
     * Presentase alfa desa
     */
    public function getPresentaseAlfaDesaProperty()
    {
        if ($this->targetDesa == 0) return 0;

        return round(($this->alfaDesa / $this->targetDesa) * 100, 1);
    }

    /**
     * Kontribusi desa terhadap total kehadiran global event
     */
    public function getKontribusiDesaProperty()
    {
        $totalHadirGlobal = $this->kegiatan?->totalHadir() ?? 0;

        if ($totalHadirGlobal == 0) return 0;

        return round(($this->hadirDesa / $totalHadirGlobal) * 100, 1);
    }

    /**
     * Total target global event
     */
    public function getTotalTargetProperty()
    {
        return $this->kegiatan?->targetPeserta() ?? 0;
    }

    // ==============================
    // INSIGHT DESA (UX ANALYTICS)
    // ==============================
    private function generateInsightDesa()
    {
        $p = $this->presentaseHadirDesa;

        if ($p >= 85) {
            $this->insightDesa = "🔥 Partisipasi sangat baik. Desa ini responsif & aktif.";
        } elseif ($p >= 65) {
            $this->insightDesa = "👍 Partisipasi cukup baik. Masih bisa ditingkatkan.";
        } elseif ($p >= 40) {
            $this->insightDesa = "⚠️ Partisipasi rendah. Perlu follow-up ke generus alfa.";
        } else {
            $this->insightDesa = "🚨 Partisipasi sangat rendah. Perlu perhatian khusus pengurus desa.";
        }
    }

    public function render()
    {
        return view('livewire.laporan.desa.kegiatan-event.report');
    }
}
