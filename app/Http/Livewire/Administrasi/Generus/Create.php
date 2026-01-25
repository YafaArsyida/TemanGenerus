<?php

namespace App\Http\Livewire\Administrasi\Generus;

use App\Models\Generus;
use App\Models\Kelompok;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Create extends Component
{
    public $ms_kelompok_id;
    public $nama_generus;
    public $nomor_telepon;
    public $tempat_lahir;
    public $tanggal_lahir;
    public $jenis_kelamin;
    public $alamat;
    public $deskripsi;

    public $selectedDesa = null; // optional untuk filter kelompok kalau mau

    protected $listeners = ['GenerusCreate', 'parameterUpdated'];

    public function GenerusCreate()
    {
        $this->resetInput();
        $this->emitSelf('render');
    }

    public function parameterUpdated($desaId)
    {
        $this->selectedDesa = $desaId;
    }

    protected $rules = [
        'ms_kelompok_id' => 'required|exists:ms_kelompok,ms_kelompok_id',
        'nama_generus'   => 'required|string|min:3|max:150',
        'nomor_telepon'   => 'nullable|string|max:20',
        'tempat_lahir'   => 'nullable|string|max:120',
        'tanggal_lahir'  => 'nullable|date',
        'jenis_kelamin'  => 'required|in:laki-laki,perempuan',
        'alamat'         => 'nullable|string|max:255',
        'deskripsi'      => 'nullable|string|max:500',
    ];

    protected $messages = [
        'ms_kelompok_id.required' => 'Pilih kelompok terlebih dahulu.',
        'ms_kelompok_id.exists'   => 'Kelompok tidak valid.',

        'nama_generus.required' => 'Nama generus wajib diisi.',
        'nama_generus.min'      => 'Nama terlalu pendek.',
        'nama_generus.max'      => 'Nama terlalu panjang.',

        'jenis_kelamin.required' => 'Pilih jenis kelamin.',
        'jenis_kelamin.in'       => 'Jenis kelamin tidak valid.',
    ];

    public function updated($fields)
    {
        $this->validateOnly($fields);
    }

    public function save()
    {
        $validated = $this->validate();

        DB::beginTransaction();
        try {

            Generus::create([
                'ms_kelompok_id' => $this->ms_kelompok_id,
                'nama_generus'   => $this->nama_generus,
                'nomor_telepon'   => $this->nomor_telepon,
                'tempat_lahir'   => $this->tempat_lahir,
                'tanggal_lahir'  => $this->tanggal_lahir,
                'jenis_kelamin'  => $this->jenis_kelamin,
                'alamat'         => $this->alamat,
                'deskripsi'      => $this->deskripsi,
            ]);

            DB::commit();

            $this->dispatchBrowserEvent('alertify-success', [
                'message' => 'Berhasil menambah data generus!'
            ]);

            $this->dispatchBrowserEvent('hide-modal', [
                'modalId' => 'ModalGenerusCreate'
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
        $this->nama_generus = '';
        $this->nomor_telepon = '';
        $this->tempat_lahir = '';
        $this->tanggal_lahir = '';
        $this->jenis_kelamin = '';
        $this->alamat = '';
        $this->deskripsi = '';
    }

    public function render()
    {
        $kelompokQuery = Kelompok::orderBy('nama_kelompok');

        if ($this->selectedDesa) {
            $kelompokQuery->where('ms_desa_id', $this->selectedDesa);
        }

        return view('livewire.administrasi.generus.create', [
            'listKelompok' => $kelompokQuery->get()
        ]);
    }
}
