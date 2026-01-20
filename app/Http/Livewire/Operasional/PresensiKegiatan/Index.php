<?php

namespace App\Http\Livewire\Operasional\PresensiKegiatan;

use App\Models\Generus;
use App\Models\Kegiatan;
use App\Models\Kelompok;
use App\Models\PresensiKegiatan;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;


class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $selectedDesa = null;

    // ================= FILTER GENERUS (KIRI) =================
    public $searchGenerus = '';
    public $kelompokGenerus = '';
    public $genderGenerus = '';

    // ================= FILTER PRESENSI (KANAN) =================
    public $searchPresensi = '';
    public $kelompokPresensi = '';
    public $genderPresensi = '';

    public $jenjangUsia = '';

    // public $jenis_kelamin = '';

    public $token;
    public $kegiatan;

    public $presensiMap = [];   // untuk tombol di tabel generus

    public $listKelompok = [];
    public $listGenerus = [];

    protected $listeners = [
        'parameterUpdated' => 'setParameterDesa'
    ];

    public function setParameterDesa($desaId)
    {
        $this->selectedDesa = $desaId;

        // reset filter lanjutan
        $this->kelompokGenerus = null;
        $this->kelompokPresensi = null;

        $this->loadKelompok();

        $this->loadGenerus();
        $this->loadPresensiMap(); // ⬅️ tambahkan
    }

    public function refreshPresensi()
    {
        $this->loadPresensiMap();
        $this->loadGenerus(); // optional
    }


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

        $this->jenjangUsia = $this->kegiatan->jenjang;

        $this->loadKelompok();

        $this->loadGenerus();
        $this->loadPresensiMap(); // ⬅️ WAJIB di sini
    }

    protected function loadKelompok()
    {
        $query = Kelompok::query();

        // SCOPE DAERAH → pakai parameter desa
        if ($this->kegiatan->scope === 'daerah' && $this->selectedDesa) {
            $query->where('ms_desa_id', $this->selectedDesa);
        }

        // SCOPE DESA
        if ($this->kegiatan->scope === 'desa') {
            $query->where('ms_desa_id', $this->kegiatan->ms_desa_id);
        }

        // SCOPE KELOMPOK
        if ($this->kegiatan->scope === 'kelompok') {
            $query->where('ms_kelompok_id', $this->kegiatan->ms_kelompok_id);
        }

        $this->listKelompok = $query
            ->orderBy('nama_kelompok')
            ->get();
    }

    public function loadGenerus()
    {
        $this->listGenerus = Generus::with(['ms_kelompok.ms_desa'])

            // SEARCH GENERUS
            ->when(
                $this->searchGenerus,
                fn($q) =>
                $q->where('nama_generus', 'like', "%{$this->searchGenerus}%")
            )

            // FILTER KELOMPOK GENERUS
            ->when(
                $this->kelompokGenerus,
                fn($q) =>
                $q->where('ms_kelompok_id', $this->kelompokGenerus)
            )

            // FILTER GENDER GENERUS
            ->when(
                $this->genderGenerus,
                fn($q) =>
                $q->where('jenis_kelamin', $this->genderGenerus)
            )

            // ===== SCOPE KEGIATAN (tetap sama) =====
            ->when(
                $this->kegiatan->scope === 'daerah' && $this->selectedDesa,
                fn($q) =>
                $q->whereHas(
                    'ms_kelompok',
                    fn($k) =>
                    $k->where('ms_desa_id', $this->selectedDesa)
                )
            )

            ->when(
                $this->kegiatan->scope === 'desa',
                fn($q) =>
                $q->whereHas(
                    'ms_kelompok',
                    fn($k) =>
                    $k->where('ms_desa_id', $this->kegiatan->ms_desa_id)
                )
            )

            ->when(
                $this->kegiatan->scope === 'kelompok',
                fn($q) =>
                $q->where('ms_kelompok_id', $this->kegiatan->ms_kelompok_id)
            )

            // ===== JENJANG =====
            ->when($this->kegiatan->jenjang, function ($q) {
                $jenjang = $this->kegiatan->jenjang;

                if (!isset(Generus::jenjangUsiaMap()[$jenjang])) {
                    return;
                }

                [$min, $max] = Generus::jenjangUsiaMap()[$jenjang];

                $q->whereRaw(
                    "TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN ? AND ?",
                    [$min, $max]
                );
            })

            ->orderBy('nama_generus')
            ->get();
    }

    protected function loadPresensiMap()
    {
        $existing = PresensiKegiatan::where('ms_kegiatan_id', $this->kegiatan->ms_kegiatan_id)
            ->get()
            ->keyBy('ms_generus_id');

        $this->presensiMap = $existing
            ->map(fn($p) => $p->status_hadir)
            ->toArray();
    }

    public function updated($property)
    {
        // filter generus kiri
        if (in_array($property, ['searchGenerus', 'kelompokGenerus', 'genderGenerus'])) {
            $this->loadGenerus();
            $this->loadPresensiMap();
        }

        // filter presensi kanan
        if (in_array($property, ['searchPresensi', 'kelompokPresensi', 'genderPresensi'])) {
            $this->resetPage(); // pagination kanan
        }
    }

    public function getRiwayatAbsensiProperty()
    {
        return PresensiKegiatan::with('ms_generus.ms_kelompok')

            ->where('ms_kegiatan_id', $this->kegiatan->ms_kegiatan_id)

            // SEARCH PRESENSI
            ->when(
                $this->searchPresensi,
                fn($q) =>
                $q->whereHas(
                    'ms_generus',
                    fn($g) =>
                    $g->where('nama_generus', 'like', "%{$this->searchPresensi}%")
                )
            )

            // FILTER KELOMPOK PRESENSI
            ->when(
                $this->kelompokPresensi,
                fn($q) =>
                $q->whereHas(
                    'ms_generus',
                    fn($g) =>
                    $g->where('ms_kelompok_id', $this->kelompokPresensi)
                )
            )

            // FILTER GENDER PRESENSI
            ->when(
                $this->genderPresensi,
                fn($q) =>
                $q->whereHas(
                    'ms_generus',
                    fn($g) =>
                    $g->where('jenis_kelamin', $this->genderPresensi)
                )
            )

            ->orderByDesc('waktu_hadir')
            ->get();
            // ->paginate(20);
    }

    public function hadir($generusId)
    {
        $presensi = PresensiKegiatan::firstOrCreate(
            [
                'ms_kegiatan_id' => $this->kegiatan->ms_kegiatan_id,
                'ms_generus_id'  => $generusId,
            ],
            [
                'waktu_hadir'  => now(),
                'status_hadir' => 'hadir',
                'verifikasi'   => 'manual',
                'deskripsi'    => null,
            ]
        );

        $this->loadPresensiMap();

        // alertify
        if ($presensi->wasRecentlyCreated) {
            $this->dispatchBrowserEvent('alertify-success', [
                'message' => 'Generus hadir berhasil dicatat'
            ]);
        } else {
            $this->dispatchBrowserEvent('alertify-error', [
                'message' => 'Presensi sudah ada, tidak diubah'
            ]);
        }
    }

    public function izin($generusId)
    {
        $presensi = PresensiKegiatan::firstOrCreate(
            [
                'ms_kegiatan_id' => $this->kegiatan->ms_kegiatan_id,
                'ms_generus_id'  => $generusId,
            ],
            [
                'waktu_hadir'  => null,
                'status_hadir' => 'izin',
                'verifikasi'   => 'manual',
                'deskripsi'    => 'Izin',
            ]
        );

        $this->loadPresensiMap();

        if ($presensi->wasRecentlyCreated) {
            $this->dispatchBrowserEvent('alertify-success', [
                'message' => 'Generus izin berhasil dicatat'
            ]);
        } else {
            $this->dispatchBrowserEvent('alertify-error', [
                'message' => 'Presensi izin sudah ada, tidak diubah'
            ]);
        }
    }

    public function batalPresensi($generusId)
    {
        PresensiKegiatan::where('ms_kegiatan_id', $this->kegiatan->ms_kegiatan_id)
            ->where('ms_generus_id', $generusId)
            ->delete();

        $this->loadPresensiMap();

        $this->dispatchBrowserEvent('alertify-success', [
            'message' => 'Presensi berhasil dibatalkan'
        ]);
    }

    public function render()
    {
        return view('livewire.operasional.presensi-kegiatan.index');
    }
}
