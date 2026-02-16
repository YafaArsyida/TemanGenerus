<?php

namespace App\Http\Livewire\Laporan\Kelompok\KegiatanEvent;

use App\Models\Desa;
use App\Models\Kegiatan;
use App\Models\Kelompok;
use App\Models\PresensiKegiatan;
use Livewire\Component;

class Report extends Component
{
    // ==============================
    // STATE (INPUT / KONTEXT AKTIF)
    // ==============================
    public $kegiatan;
    public $kegiatanId;

    public $ms_kelompok_id;
    public $ms_desa_id;

    public $nama_kelompok = '-';
    public $nama_desa = '-';

    public $insightKelompok = '-';

    protected $listeners = [
        'KegiatanReport' => 'loadReport'
    ];

    // ==============================
    // EVENT HANDLER
    // ==============================
    public function loadReport($kegiatanId, $kelompokId)
    {
        $this->kegiatanId = $kegiatanId;
        $this->ms_kelompok_id = $kelompokId;

        // Ambil kelompok + desa
        $kelompok = Kelompok::with('ms_desa')->find($kelompokId);

        $this->nama_kelompok = $kelompok?->nama_kelompok ?? '-';
        $this->nama_desa     = $kelompok?->ms_desa?->nama_desa ?? '-';
        $this->ms_desa_id     = $kelompok?->ms_desa?->ms_desa_id ?? '-';

        // Load kegiatan
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

        // Broadcast ke child (attendance & alfa)
        $this->emitTo(
            'laporan.kelompok.kegiatan-event.report.attendance',
            'setKegiatan',
            $kegiatanId,
            $this->ms_kelompok_id
        );

        $this->emitTo(
            'laporan.kelompok.kegiatan-event.report.alfa',
            'setKegiatan',
            $kegiatanId,
            $this->ms_kelompok_id
        );

        // Insight
        $this->generateInsightKelompok();

        $this->dispatchBrowserEvent('alertify-success', [
            'message' => 'Laporan kelompok dimuat'
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

    // ==============================
    // STATISTIK KELOMPOK (COMPUTED)
    // ==============================

    /**
     * Target peserta khusus kelompok
     * Mengikuti scope + jenjang dari kegiatan
     */
    public function getTargetKelompokProperty()
    {
        if (!$this->kegiatan || !$this->ms_kelompok_id) return 0;

        return $this->kegiatan
            ->targetPesertaQuery()
            ->where('ms_kelompok_id', $this->ms_kelompok_id)
            ->count();
    }

    /**
     * Total hadir dari kelompok ini
     */
    public function getHadirKelompokProperty()
    {
        if (!$this->kegiatanId || !$this->ms_kelompok_id) return 0;

        return PresensiKegiatan::where('ms_kegiatan_id', $this->kegiatanId)
            ->where('status_hadir', 'hadir')
            ->whereHas(
                'ms_generus',
                fn($q) =>
                $q->where('ms_kelompok_id', $this->ms_kelompok_id)
            )
            ->count();
    }

    /**
     * Total izin dari kelompok ini
     */
    public function getIzinKelompokProperty()
    {
        if (!$this->kegiatanId || !$this->ms_kelompok_id) return 0;

        return PresensiKegiatan::where('ms_kegiatan_id', $this->kegiatanId)
            ->where('status_hadir', 'izin')
            ->whereHas(
                'ms_generus',
                fn($q) =>
                $q->where('ms_kelompok_id', $this->ms_kelompok_id)
            )
            ->count();
    }


    /**
     * Alfa kelompok = target - (hadir + izin + sakit)
     */
    public function getAlfaKelompokProperty()
    {
        if (!$this->kegiatanId || !$this->ms_kelompok_id) return 0;

        $hadirIzin = PresensiKegiatan::where('ms_kegiatan_id', $this->kegiatanId)
            ->whereIn('status_hadir', ['hadir', 'izin', 'sakit'])
            ->whereHas(
                'ms_generus',
                fn($q) =>
                $q->where('ms_kelompok_id', $this->ms_kelompok_id)
            )
            ->count();

        return max(0, $this->targetKelompok - $hadirIzin);
    }

    /**
     * Presentase hadir kelompok
     */
    public function getPresentaseHadirKelompokProperty()
    {
        if ($this->targetKelompok == 0) return 0;

        return round(($this->hadirKelompok / $this->targetKelompok) * 100, 1);
    }

    /**
     * Presentase izin kelompok
     */
    public function getPresentaseIzinKelompokProperty()
    {
        if ($this->targetKelompok == 0) return 0;

        return round(($this->izinKelompok / $this->targetKelompok) * 100, 1);
    }

    /**
     * Presentase alfa kelompok
     */
    public function getPresentaseAlfaKelompokProperty()
    {
        if ($this->targetKelompok == 0) return 0;

        return round(($this->alfaKelompok / $this->targetKelompok) * 100, 1);
    }

    /**
     * Kontribusi kelompok terhadap hadir desa
     */
    public function getKontribusiKelompokProperty()
    {
        $hadirDesa = PresensiKegiatan::where('ms_kegiatan_id', $this->kegiatanId)
            ->where('status_hadir', 'hadir')
            ->whereHas(
                'ms_generus.ms_kelompok',
                fn($q) =>
                $q->where('ms_desa_id', $this->kegiatan->ms_desa_id)
            )
            ->count();

        if ($hadirDesa == 0) return 0;

        return round(($this->hadirKelompok / $hadirDesa) * 100, 1);
    }

    /**
     * Total target global event
     */
    public function getTotalTargetProperty()
    {
        return $this->kegiatan?->targetPeserta() ?? 0;
    }

    // ==============================
    // INSIGHT KELOMPOK (UX ANALYTICS)
    // ==============================
    private function generateInsightKelompok()
    {
        $p = $this->presentaseHadirKelompok;

        if ($p >= 90) {
            $this->insightKelompok = "⭐ Kelompok sangat disiplin. Pembinaan berjalan optimal.";
        } elseif ($p >= 75) {
            $this->insightKelompok = "👍 Kehadiran stabil. Tinggal menekan alfa.";
        } elseif ($p >= 50) {
            $this->insightKelompok = "⚠️ Banyak bolong. Perlu pendekatan personal.";
        } else {
            $this->insightKelompok = "🚨 Pembinaan bermasalah. Mayoritas anggota tidak hadir.";
        }
    }


    public function render()
    {
        return view('livewire.laporan.kelompok.kegiatan-event.report');
    }
}
