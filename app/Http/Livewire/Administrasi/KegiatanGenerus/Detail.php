<?php

namespace App\Http\Livewire\Administrasi\KegiatanGenerus;

use App\Models\Kegiatan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Detail extends Component
{
    public $kegiatan;

    protected $listeners = [
        'KegiatanDetail'
    ];

    public function KegiatanDetail($kegiatanId)
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

        // Siapkan label hari rutin
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

        $this->dispatchBrowserEvent('alertify-success', [
            'message' => 'Detail kegiatan ditampilkan'
        ]);
    }

    public function kegiatanPengumuman($kegiatanId)
    {
        $this->dispatchBrowserEvent('alertify-success', [
            'message' => 'Pengumuman sedang disiapkan...'
        ]);

        $kegiatan = Kegiatan::with(['ms_desa', 'ms_kelompok.ms_desa'])
            ->find($kegiatanId);

        if (!$kegiatan) {
            $this->dispatchBrowserEvent('alertify-error', [
                'message' => 'Data kegiatan tidak ditemukan'
            ]);
            return;
        }

        // ===== TARGET =====
        if ($kegiatan->scope === 'daerah') {
            $target = "Semua Remaja/i se-\nDaerah Solo Selatan";
        } elseif ($kegiatan->scope === 'desa') {
            $target = "Semua Remaja/i se-\nDesa " . ($kegiatan->ms_desa->nama_desa ?? '-');
        } elseif ($kegiatan->scope === 'kelompok') {
            $target = "Semua Remaja/i\nKelompok " . ($kegiatan->ms_kelompok->nama_kelompok ?? '-') .
                "\n(Desa " . ($kegiatan->ms_kelompok->ms_desa->nama_desa ?? '-') . ")";
        } else {
            $target = "Seluruh Remaja/i";
        }

        $tanggal = \App\Http\Controllers\HelperController::formatTanggalIndonesia(
            $kegiatan->tanggal,
            'd F Y'
        );

        // ===== BUILD PESAN =====
        $pesan  = "*🔥UNDANGAN🔥*\n\n";
        $pesan .= "Kepada \n- {$target}\n\n";
        $pesan .= "Assalamualaikum wr wb.\n";
        $pesan .= "Mengharap kehadiran Sdr/Sdri pada :\n\n";

        $pesan .= "📆 _{$tanggal}_\n";
        $pesan .= "🕌 *" . ($kegiatan->lokasi_final['tempat'] ?? '-') . "*\n";
        $pesan .= "⏰ *" . ($kegiatan->waktu ?? 'Waktu belum ditentukan') . "*\n";
        $pesan .= "🗒 *" . $kegiatan->nama_kegiatan . "*\n";

        if (!empty($kegiatan->deskripsi)) {
            $pesan .= "📝 " . $kegiatan->deskripsi . "\n";
        }

        $pesan .= "🖋️ Membawa *Al-Qur'an* dan *K. Adillah*\n";

        if (!empty($kegiatan->lokasi_final['peta'])) {
            $pesan .= $kegiatan->lokasi_final['peta'] . "\n";
        }

        $pesan .= "\nAmal sholih para remaja/i dapat datang tepat waktu dan jangan lupa membawa uang untuk infaq fisabilillah.\n\n";
        $pesan .= "Atas perhatiannya dan kesakdermoannya kami ucapkan.\n\n";
        $pesan .= "Alhamdulillahi Jaza Kumullohu Khoiro.\n\n";
        $pesan .= "Wassalamualaikum Wr. Wb";

        // ===== NOMOR DARI USER LOGIN =====
        $user = Auth::user();

        if (!$user || empty($user->telepon)) {
            $this->dispatchBrowserEvent('alertify-error', [
                'message' => 'Nomor WhatsApp akun Anda belum diatur'
            ]);
            return;
        }

        $telepon = preg_replace('/[^0-9]/', '', $user->telepon);

        if (str_starts_with($telepon, '0')) {
            $telepon = '62' . substr($telepon, 1);
        }

        if (!str_starts_with($telepon, '62')) {
            $this->dispatchBrowserEvent('alertify-error', [
                'message' => 'Format nomor WhatsApp akun tidak valid'
            ]);
            return;
        }

        $url = "https://wa.me/{$telepon}?text=" . urlencode($pesan);

        $this->emit('openNewTab', $url);
    }

    public function render()
    {
        return view('livewire.administrasi.kegiatan-generus.detail');
    }
}
