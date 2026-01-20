<?php

namespace App\Http\Livewire\Administrasi\Generus;

use App\Models\Generus;
use App\Models\Kelompok;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Edit extends Component
{
    public $generusId;
    public $selectedDesa = null;

    public $ms_kelompok_id;
    public $nama_generus;
    public $tempat_lahir;
    public $tanggal_lahir;
    public $jenis_kelamin;
    public $alamat;
    public $deskripsi;

    public $listKelompok = [];

    protected $listeners = [
        'GenerusEdit',
        'parameterUpdated'
    ];

    public function parameterUpdated($desaId)
    {
        $this->selectedDesa = $desaId;

        // reload kelompok sesuai desa
        $this->loadKelompok();
    }
    
    public function loadKelompok()
    {
        $this->listKelompok = Kelompok::where('ms_desa_id', $this->selectedDesa)
            ->orderBy('nama_kelompok')
            ->get();
    }

    public function GenerusEdit($id)
    {
        // $this->resetValidation();
        // $this->resetInput();

        $this->generusId = $id;

        $data = Generus::with('ms_kelompok')->find($id);

        if (!$data) {
            $this->dispatchBrowserEvent('alertify-error', [
                'message' => 'Data Generus tidak ditemukan'
            ]);
            return;
        }

        // Isi form
        $this->ms_kelompok_id = $data->ms_kelompok_id;
        $this->nama_generus   = $data->nama_generus;
        $this->tempat_lahir   = $data->tempat_lahir;
        $this->tanggal_lahir  = $data->tanggal_lahir;
        $this->jenis_kelamin  = $data->jenis_kelamin;
        $this->alamat         = $data->alamat;
        $this->deskripsi      = $data->deskripsi;

        // 🔥 lalu reload kelompok berdasarkan desa
        $this->loadKelompok();

        // 🔥 baru set value select nya
        $this->ms_kelompok_id = $data->ms_kelompok_id;

        $this->dispatchBrowserEvent('alertify-success', [
            'message' => 'Form edit berhasil dimuat'
        ]);
    }

    protected $rules = [
        'ms_kelompok_id' => 'required|exists:ms_kelompok,ms_kelompok_id',
        'nama_generus'   => 'required|string|min:3|max:150',
        'tempat_lahir'   => 'nullable|string|max:100',
        'tanggal_lahir'  => 'nullable|date',
        'jenis_kelamin'  => 'required|in:laki-laki,perempuan',
        'alamat'         => 'nullable|string|max:255',
        'deskripsi'      => 'nullable|string|max:500',
    ];

    protected $messages = [
        'ms_kelompok_id.required' => 'Pilih kelompok terlebih dahulu.',
        'ms_kelompok_id.exists'   => 'Kelompok tidak valid.',

        'nama_generus.required' => 'Nama generus wajib diisi.',
        'nama_generus.min'      => 'Nama minimal 3 karakter.',
        'nama_generus.max'      => 'Nama maksimal 150 karakter.',

        'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
        'jenis_kelamin.in'       => 'Jenis kelamin tidak valid.',
    ];

    public function updated($field)
    {
        $this->validateOnly($field);
    }

    public function update()
    {
        $validated = $this->validate();

        DB::beginTransaction();

        try {

            Generus::where('ms_generus_id', $this->generusId)
                ->update($validated);

            DB::commit();

            $this->dispatchBrowserEvent('alertify-success', [
                'message' => 'Berhasil mengubah data generus!'
            ]);

            $this->dispatchBrowserEvent('hide-modal', [
                'modalId' => 'ModalEditGenerus'
            ]);

            $this->emit('GenerusIndex');
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
        $this->ms_kelompok_id = '';
        $this->nama_generus   = '';
        $this->tempat_lahir   = '';
        $this->tanggal_lahir  = '';
        $this->jenis_kelamin  = '';
        $this->alamat         = '';
        $this->deskripsi      = '';
    }

    public function render()
    {
        return view('livewire.administrasi.generus.edit');
    }
}
