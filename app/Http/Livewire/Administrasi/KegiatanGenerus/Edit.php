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
        $this->tanggal        = $kegiatan->tanggal;
        $this->waktu          = $kegiatan->waktu;
        $this->deskripsi      = $kegiatan->deskripsi;

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

    /* =========================
     * RULES
     * ========================= */
    protected function rules()
    {
        return [
            'scope'          => 'required|in:daerah,desa,kelompok',
            'ms_kelompok_id' => 'nullable|exists:ms_kelompok,ms_kelompok_id',
            'nama_kegiatan'  => 'required|string|min:3|max:150',
            'jenjang'        => 'nullable|in:semua,caberawit,remaja,gp,pra_remaja,mandiri',
            'tempat'         => 'nullable|string|max:150',
            'alamat'         => 'nullable|string|max:255',
            'peta'           => 'nullable|url',
            'tanggal'        => 'required|date',
            'waktu'          => 'required|date_format:H:i:s',
            'deskripsi'      => 'nullable|string|max:500',
        ];
    }

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

                'tanggal' => $this->tanggal,
                'waktu' => $this->waktu,
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
