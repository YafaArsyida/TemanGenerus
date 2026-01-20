<?php

namespace App\Http\Livewire\Administrasi\KegiatanGenerus;

use App\Models\Daerah;
use App\Models\Desa;
use App\Models\Kegiatan;
use App\Models\Kelompok;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Create extends Component
{
    public $ms_desa_id = null;

    public $scope = '';
    public $ms_kelompok_id = null;
    public $nama_kegiatan = '';
    public $jenjang = 'semua';
    
    public $tanggal = '';
    public $waktu = '';
    public $deskripsi = '';

    public $lokasi_default = [];
    public $use_custom_lokasi = false;

    // custom input
    public $tempat;
    public $alamat;
    public $peta;

    protected $listeners = [
        'KegiatanCreate' => 'initCreate'
     ];

    public function initCreate($desaId = null)
    {
        $this->resetInput();
        $this->ms_desa_id = $desaId;
    }

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

    protected $messages = [
        'scope.required' => 'Pilih scope kegiatan terlebih dahulu.',
        'ms_kelompok_id.exists' => 'Kelompok tidak valid.',
        'nama_kegiatan.required' => 'Nama kegiatan wajib diisi.',
        'jenjang.in' => 'Jenjang tidak valid.',
        'peta.url' => 'Format URL peta tidak valid.',
    ];

    public function updated($field)
    {
        $this->validateOnly($field);
    }

    public function updatedScope($value)
    {
        // reset kelompok kalau ganti scope
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

            $this->lokasi_default = [
                'tempat' => $daerah->nama_masjid,
                'alamat' => $daerah->alamat,
                'peta'   => $daerah->peta,
            ];
        }
    }

    private function resetLokasiCustom()
    {
        $this->use_custom_lokasi = false;
        $this->tempat = null;
        $this->alamat = null;
        $this->peta = null;
    }

    public function save()
    {
        $validated = $this->validate();

        // Jika scope kelompok wajib pilih kelompok
        if ($validated['scope'] === 'kelompok' && !$this->ms_kelompok_id) {
            $this->addError('ms_kelompok_id', 'Pilih kelompok terlebih dahulu.');
            return;
        }

        DB::beginTransaction();
        try {
            Kegiatan::create([
                'scope' => $this->scope,
                'ms_kelompok_id' => $this->ms_kelompok_id,
                'ms_desa_id' => $this->ms_desa_id,
                'nama_kegiatan' => $this->nama_kegiatan,
                'jenjang' => $this->jenjang,

                'tempat' => $this->use_custom_lokasi ? $this->tempat : null,
                'alamat' => $this->use_custom_lokasi ? $this->alamat : null,
                'peta'   => $this->use_custom_lokasi ? $this->peta : null,
                
                'tanggal' => $this->tanggal,
                'waktu' => $this->waktu,
                'status' => 'aktif',
                'deskripsi' => $this->deskripsi,
                
            ]);

            DB::commit();

            $this->dispatchBrowserEvent('alertify-success', [
                'message' => 'Berhasil menambahkan kegiatan!'
            ]);

            $this->dispatchBrowserEvent('hide-modal', [
                'modalId' => 'ModalKegiatanCreate'
            ]);

            $this->emit('KegiatanIndex');
            $this->resetInput();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatchBrowserEvent('alertify-error', [
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function resetInput()
    {
        $this->scope = '';
        $this->ms_kelompok_id = null;
        $this->nama_kegiatan = '';
        $this->jenjang = 'semua';
        $this->tempat = '';
        $this->alamat = '';
        $this->peta = '';
        $this->tanggal = '';
        $this->waktu = '';
        $this->deskripsi = '';
    }

    public function render()
    {
        $kelompokQuery = Kelompok::orderBy('nama_kelompok');

        if ($this->ms_desa_id) {
            $kelompokQuery->where('ms_desa_id', $this->ms_desa_id);
        }

        return view('livewire.administrasi.kegiatan-generus.create',[
            'listKelompok' => $kelompokQuery->get()
        ]);
    }
}
