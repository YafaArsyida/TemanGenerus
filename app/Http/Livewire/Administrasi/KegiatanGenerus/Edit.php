<?php

namespace App\Http\Livewire\Administrasi\KegiatanGenerus;

use App\Models\Daerah;
use App\Models\Desa;
use App\Models\Kegiatan;
use App\Models\Kelompok;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Edit extends Component
{
    public $kegiatanId;

    public $selectedDesa = null;

    public $ms_desa_id = null;
    public $scope = '';
    public $ms_kelompok_id = null;
    public $nama_kegiatan = '';
    public $jenjang = '';

    public $tanggal = '';
    public $waktu = '';
    public $deskripsi = '';

    public $lokasi_default = [];
    public $use_custom_lokasi = false;

    public $tempat;
    public $alamat;
    public $peta;

    public $tipe_kegiatan = 'sekali'; // default
    public $hari_rutin = []; // array: ['senin','rabu',...]

    public $listHari = [
        'senin'  => 'Senin',
        'selasa' => 'Selasa',
        'rabu'   => 'Rabu',
        'kamis'  => 'Kamis',
        'jumat'  => 'Jumat',
        'sabtu'  => 'Sabtu',
        'minggu' => 'Minggu',
    ];

    protected $listeners = [
        'KegiatanEdit' => 'loadData'
    ];

    /* =========================
     * LOAD DATA
     * ========================= */
    public function loadData($id, $desaId = null)
    {
        $this->selectedDesa = $desaId;
        $kegiatan = Kegiatan::find($id);

        if (!$kegiatan) {
            $this->dispatchBrowserEvent('alertify-error', [
                'message' => 'Data kegiatan tidak ditemukan'
            ]);
            return;
        }

        $this->kegiatanId     = $kegiatan->ms_kegiatan_id;
        $this->scope          = $kegiatan->scope;
        $this->ms_desa_id     = $kegiatan->ms_desa_id;
        $this->ms_kelompok_id = $kegiatan->ms_kelompok_id;

        $this->nama_kegiatan  = $kegiatan->nama_kegiatan;
        $this->jenjang        = $kegiatan->jenjang;

        $this->tipe_kegiatan = $kegiatan->tipe_kegiatan ?? 'sekali';
        $this->tanggal = $kegiatan->tanggal;
        $this->waktu = $kegiatan->waktu;
        $this->deskripsi = $kegiatan->deskripsi;

        $this->hari_rutin = $kegiatan->tipe_kegiatan === 'rutin'
            ? ($kegiatan->hari_rutin ?? [])
            : [];

        // Deteksi lokasi custom
        if ($kegiatan->tempat || $kegiatan->alamat || $kegiatan->peta) {
            $this->use_custom_lokasi = true;
            $this->tempat = $kegiatan->tempat;
            $this->alamat = $kegiatan->alamat;
            $this->peta   = $kegiatan->peta;
        } else {
            $this->use_custom_lokasi = false;
            $this->resetLokasiCustom();
            $this->loadLokasiDefault();
        }
    }

    public function updatedTipeKegiatan($value)
    {
        if ($value === 'rutin') {
            $this->tanggal = null;      // tanggal tidak dipakai
        }

        if ($value === 'sekali') {
            $this->hari_rutin = [];     // hapus hari_rutin
        }
    }


    /* =========================
     * RULES
     * ========================= */
    protected function rules()
    {
        $rules = [
            'scope'          => 'required|in:daerah,desa,kelompok',
            'nama_kegiatan'  => 'required|string|min:3|max:150',
            'tipe_kegiatan'  => 'required|in:rutin,sekali',
            'jenjang'        => 'nullable|in:semua,caberawit,remaja,gp,pra_remaja,mandiri',
            'waktu'          => 'required|date_format:H:i:s',
            'tempat'         => 'nullable|string|max:150',
            'alamat'         => 'nullable|string|max:255',
            'peta'           => 'nullable|url',
            'deskripsi'      => 'nullable|string|max:500',
        ];

        if ($this->scope === 'kelompok') {
            $rules['ms_kelompok_id'] = 'required|exists:ms_kelompok,ms_kelompok_id';
        } else {
            $rules['ms_kelompok_id'] = 'nullable';
        }

        // 🔹 Kegiatan sekali → wajib tanggal
        if ($this->tipe_kegiatan === 'sekali') {
            $rules['tanggal'] = 'required|date';
        } else {
            $rules['tanggal'] = 'nullable';
        }

        // 🔹 Kegiatan rutin → wajib hari_rutin (array)
        if ($this->tipe_kegiatan === 'rutin') {
            $rules['hari_rutin'] = 'required|array|min:1';
            $rules['hari_rutin.*'] = 'in:senin,selasa,rabu,kamis,jumat,sabtu,minggu';
        } else {
            $rules['hari_rutin'] = 'nullable';
        }

        if ($this->use_custom_lokasi) {
            $rules['tempat'] = 'required|string|max:150';
            $rules['alamat'] = 'nullable|string|max:255';
            $rules['peta']   = 'nullable|url';
        } else {
            $rules['tempat'] = 'nullable';
            $rules['alamat'] = 'nullable';
            $rules['peta']   = 'nullable';
        }

        return $rules;
    }

    protected $messages = [
        'scope.required' => 'Pilih tingkat kegiatan terlebih dahulu.',
        'scope.in'       => 'Tingkat kegiatan tidak valid.',

        'ms_kelompok_id.required' => 'Pilih kelompok terlebih dahulu.',
        'ms_kelompok_id.exists'   => 'Kelompok yang dipilih tidak valid.',

        'nama_kegiatan.required'  => 'Nama kegiatan wajib diisi.',
        'nama_kegiatan.min'       => 'Nama kegiatan minimal 3 karakter.',
        'nama_kegiatan.max'       => 'Nama kegiatan maksimal 150 karakter.',

        'tipe_kegiatan.required'  => 'Pilih tipe kegiatan.',
        'tipe_kegiatan.in'        => 'Tipe kegiatan tidak valid.',

        'jenjang.in'              => 'Jenjang tidak valid.',

        'tanggal.required'       => 'Tanggal wajib diisi untuk kegiatan sekali.',
        'tanggal.date'           => 'Format tanggal tidak valid.',

        'hari_rutin.required'    => 'Pilih minimal satu hari untuk kegiatan rutin.',
        'hari_rutin.array'       => 'Format hari rutin tidak valid.',
        'hari_rutin.min'         => 'Pilih minimal satu hari kegiatan.',
        'hari_rutin.*.in'        => 'Hari rutin tidak valid.',

        'waktu.required'         => 'Waktu kegiatan wajib diisi.',
        'waktu.date_format'      => 'Format waktu harus HH:MM:SS.',

        'tempat.required'        => 'Tempat wajib diisi jika lokasi berbeda.',
        'tempat.max'             => 'Nama tempat maksimal 150 karakter.',

        'alamat.max'             => 'Alamat maksimal 255 karakter.',

        'peta.url'               => 'Format URL peta tidak valid.',

        'deskripsi.max'          => 'Deskripsi maksimal 500 karakter.',
    ];

    public function updatedScope($value)
    {
        if ($value !== 'kelompok') {
            $this->ms_kelompok_id = null;
        }

        $this->resetLokasiCustom();
        $this->loadLokasiDefault();
    }

    public function updatedMsKelompokId()
    {
        $this->resetLokasiCustom();
        $this->loadLokasiDefault();
    }

    /* =========================
     * LOKASI
     * ========================= */
    private function loadLokasiDefault()
    {
        $this->lokasi_default = [];

        if ($this->scope === 'kelompok' && $this->ms_kelompok_id) {
            $kelompok = Kelompok::with('ms_desa')->find($this->ms_kelompok_id);
            if ($kelompok) {
                $this->lokasi_default = [
                    'tempat' => $kelompok->nama_masjid,
                    'alamat' => $kelompok->alamat,
                    'peta'   => $kelompok->peta,
                ];
            }
        }

        if ($this->scope === 'desa' && $this->ms_desa_id) {
            $desa = Desa::find($this->ms_desa_id);
            if ($desa) {
                $this->lokasi_default = [
                    'tempat' => $desa->nama_masjid,
                    'alamat' => $desa->alamat,
                    'peta'   => $desa->peta,
                ];
            }
        }

        if ($this->scope === 'daerah') {
            $daerah = Daerah::first();
            if ($daerah) {
                $this->lokasi_default = [
                    'tempat' => $daerah->nama_masjid,
                    'alamat' => $daerah->alamat,
                    'peta'   => $daerah->peta,
                ];
            }
        }
    }

    private function resetLokasiCustom()
    {
        $this->tempat = null;
        $this->alamat = null;
        $this->peta   = null;
    }

    /* =========================
     * UPDATE
     * ========================= */
    public function update()
    {
        $validated = $this->validate();

        if ($validated['scope'] === 'kelompok' && !$this->ms_kelompok_id) {
            $this->addError('ms_kelompok_id', 'Pilih kelompok terlebih dahulu.');
            return;
        }

        DB::beginTransaction();
        try {
            Kegiatan::where('ms_kegiatan_id', $this->kegiatanId)->update([
                'scope' => $this->scope,
                'ms_desa_id' => $this->ms_desa_id,
                'ms_kelompok_id' => $this->ms_kelompok_id,
                'nama_kegiatan' => $this->nama_kegiatan,
                'jenjang' => $this->jenjang,

                'tempat' => $this->use_custom_lokasi ? $this->tempat : null,
                'alamat' => $this->use_custom_lokasi ? $this->alamat : null,
                'peta'   => $this->use_custom_lokasi ? $this->peta : null,

                'tanggal' => $this->tipe_kegiatan === 'sekali' ? $this->tanggal : null,
                'waktu' => $this->waktu,

                'tipe_kegiatan' => $this->tipe_kegiatan,
                'hari_rutin' => $this->tipe_kegiatan === 'rutin'
                    ? json_encode($this->hari_rutin)
                    : null,

                'deskripsi' => $this->deskripsi,
            ]);

            DB::commit();

            $this->dispatchBrowserEvent('alertify-success', [
                'message' => 'Kegiatan berhasil diperbarui'
            ]);

            $this->dispatchBrowserEvent('hide-modal', [
                'modalId' => 'ModalEditKegiatan'
            ]);

            $this->emit('KegiatanIndex');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatchBrowserEvent('alertify-error', [
                'message' => $e->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.administrasi.kegiatan-generus.edit',[
            'listKelompok' => Kelompok::where('ms_desa_id', $this->selectedDesa)
                ->orderBy('nama_kelompok')
                ->get()
        ]);
    }
}
