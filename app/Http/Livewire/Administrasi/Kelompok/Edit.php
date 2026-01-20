<?php

namespace App\Http\Livewire\Administrasi\Kelompok;

use App\Models\Desa;
use App\Models\Kelompok;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Edit extends Component
{
    public $kelompokId;
    public $ms_desa_id;
    public $nama_kelompok;
    public $nama_masjid;
    public $alamat;
    public $peta;
    public $deskripsi;

    protected $listeners = [
        'KelompokEdit' => 'loadData'
    ];

    public function loadData($id)
    {
        $this->resetValidation();
        $this->resetInput();
        
        $this->kelompokId = $id;

        $kelompok = Kelompok::findOrFail($id);

        if (!$kelompok) {
            $this->dispatchBrowserEvent('alertify-error', [
                'message' => 'Data Kelompok tidak ditemukan'
            ]);
            return;
        }

        $this->ms_desa_id    = $kelompok->ms_desa_id;
        $this->nama_kelompok = $kelompok->nama_kelompok;
        $this->nama_masjid   = $kelompok->nama_masjid;
        $this->alamat        = $kelompok->alamat;
        $this->peta          = $kelompok->peta;
        $this->deskripsi     = $kelompok->deskripsi;

        $this->dispatchBrowserEvent('alertify-success', [
            'message' => 'Form edit berhasil dimuat'
        ]);
    }

    protected $rules = [
        'ms_desa_id'     => 'required|exists:ms_desa,ms_desa_id',
        'nama_kelompok'  => 'required|string|min:3|max:150',
        'nama_masjid'    => 'nullable|string|max:150',
        'alamat'         => 'required|string|min:5|max:255',
        'peta'           => 'nullable|url',
        'deskripsi'      => 'nullable|string|max:500',
    ];

    protected $messages = [
        'ms_desa_id.required' => 'Pilih desa terlebih dahulu.',
        'ms_desa_id.exists'   => 'Desa tidak valid.',
        'nama_kelompok.required' => 'Nama kelompok wajib diisi.',
        'nama_kelompok.min'      => 'Nama kelompok minimal 3 karakter.',
        'nama_kelompok.max'      => 'Nama kelompok maksimal 150 karakter.',
        'nama_masjid.max'     => 'Nama masjid maksimal 150 karakter.',
        'alamat.required'     => 'Alamat wajib diisi.',
        'alamat.min'          => 'Alamat terlalu pendek.',
        'alamat.max'          => 'Alamat terlalu panjang.',
        'peta.url'            => 'Format tautan peta tidak valid. Harus berupa URL.',
        'deskripsi.max'       => 'Deskripsi maksimal 500 karakter.',
    ];

    public function updated($fields)
    {
        $this->validateOnly($fields);
    }

    public function update()
    {
        $validatedData = $this->validate();

        DB::beginTransaction();

        try {
            $kelompok = Kelompok::findOrFail($this->kelompokId);

            $kelompok->update([
                'ms_desa_id'    => $this->ms_desa_id,
                'nama_kelompok' => $this->nama_kelompok,
                'nama_masjid'   => $this->nama_masjid,
                'alamat'        => $this->alamat,
                'peta'          => $this->peta,
                'deskripsi'     => $this->deskripsi,
            ]);

            DB::commit();

            $this->dispatchBrowserEvent('alertify-success', [
                'message' => 'Data Kelompok berhasil diperbarui!'
            ]);

            $this->dispatchBrowserEvent('hide-modal', ['modalId' => 'ModalEditKelompok']);
            $this->emit('KelompokIndex');
            $this->emit('DesaIndex');

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
        $this->kelompokId = null;
        $this->ms_desa_id = '';
        $this->nama_kelompok = '';
        $this->nama_masjid = '';
        $this->alamat = '';
        $this->peta = '';
        $this->deskripsi = '';
    }

    public function render()
    {
        return view('livewire.administrasi.kelompok.edit',[
            'listDesa' => Desa::orderBy('nama_desa')->get()
        ]);
    }
}
