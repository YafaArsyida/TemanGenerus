<?php

namespace App\Http\Livewire\Operasional\PresensiKegiatanKartu;

use App\Http\Controllers\HelperController;
use App\Models\Generus;
use App\Models\Kegiatan;
use App\Models\PresensiKegiatan;
use Carbon\Carbon;
use Livewire\Component;

class Index extends Component
{
    public $token;
    public $kegiatan;

    public $barcodeInput;
    public $riwayatAbsensi = [];

    public function mount($token)
    {
        $this->token = $token;

        $this->kegiatan = Kegiatan::with([
            'ms_desa',
            'ms_kelompok'
        ])
            ->where('token', $token)
            ->where('status', 'aktif')
            ->first();

        if (!$this->kegiatan) {
            abort(404);
        }

        $this->loadRiwayatAbsensi();
    }

    public function loadRiwayatAbsensi()
    {
        $this->riwayatAbsensi = PresensiKegiatan::with([
            'ms_generus'
        ])
            ->where('ms_kegiatan_id', $this->kegiatan->ms_kegiatan_id)
            ->orderBy('waktu_hadir', 'desc')
            ->limit(20)
            ->get();
    }

    public function scanDariBarcode()
    {
        $kodeKartu = trim($this->barcodeInput);

        if (!$kodeKartu) {
            return;
        }

        // 1️⃣ Cari generus berdasarkan nomor kartu
        $generus = Generus::where('nomor_kartu', $kodeKartu)->first();

        if (!$generus) {
            $this->dispatchBrowserEvent('alertify-error', [
                'message' => 'Kartu tidak valid atau generus tidak terdaftar'
            ]);
            $this->reset('barcodeInput');
            $this->emit('focusBarcode');
            return;
        }

        $today = Carbon::today()->toDateString();
        $now   = Carbon::now();
        $kegiatanTanggal = $this->kegiatan->tanggal;

        // 1️⃣5️⃣ Cek tanggal kegiatan
        if ($today !== $kegiatanTanggal) {
            $this->dispatchBrowserEvent('alertify-error', [
                'message' => 'Presensi hanya bisa dilakukan di tanggal kegiatan: ' .
                    HelperController::formatTanggalIndonesia($kegiatanTanggal, 'd F Y')
            ]);
            $this->reset('barcodeInput');
            $this->emit('focusBarcode');
            return;
        }

        // 2️⃣ Catat presensi sekali menggunakan firstOrCreate
        $presensi = PresensiKegiatan::firstOrCreate(
            [
                'ms_kegiatan_id' => $this->kegiatan->ms_kegiatan_id,
                'ms_generus_id'  => $generus->ms_generus_id,
            ],
            [
                'waktu_hadir'  => $now,
                'status_hadir' => 'hadir',
                'verifikasi'   => 'kartu',
                'deskripsi'    => 'Presensi masuk via kartu',
            ]
        );

        // 3️⃣ Alertify sesuai kondisi
        if ($presensi->wasRecentlyCreated) {
            $this->dispatchBrowserEvent('alertify-success', [
                'message' => 'Presensi berhasil'
            ]);
        } else {
            $this->dispatchBrowserEvent('alertify-error', [
                'message' => 'Presensi hari ini sudah tercatat'
            ]);
        }

        // 4️⃣ Reset input & fokus lagi
        $this->reset('barcodeInput');
        $this->emit('focusBarcode');

        // 5️⃣ Refresh tombol & riwayat presensi
        $this->loadRiwayatAbsensi();
    }

    public function render()
    {
        return view('livewire.operasional.presensi-kegiatan-kartu.index');
    }
}
