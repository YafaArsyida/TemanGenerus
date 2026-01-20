<?php

namespace App\Http\Livewire\Administrasi\Kelompok;

use App\Models\Desa;
use App\Models\Kelompok;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Create extends Component
{
    public $ms_desa_id;
    public $nama_kelompok;
    public $nama_masjid;
    public $alamat;
    public $peta;
    public $deskripsi;

    protected $listeners = ['KelompokCreate'];

    public function KelompokCreate()
    {
        $this->resetInput();
        $this->emitSelf('render');
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

    public function save()
    {
        $validatedData = $this->validate();

        DB::beginTransaction();

        try {

            // Simpan data Kelompok
            Kelompok::create([
                'ms_desa_id'    => $this->ms_desa_id,
                'nama_kelompok' => $this->nama_kelompok,
                'nama_masjid'   => $this->nama_masjid,
                'alamat'        => $this->alamat,
                'peta'          => $this->peta,
                'deskripsi'     => $this->deskripsi,
            ]);

            DB::commit();

            // Notifikasi sukses
            $this->dispatchBrowserEvent('alertify-success', [
                'message' => 'Berhasil menambah kelompok!'
            ]);

            // Tutup modal
            $this->dispatchBrowserEvent('hide-modal', ['modalId' => 'ModalKelompokCreate']);

            // Refresh list
            $this->emit('KelompokIndex');
            $this->emit('DesaIndex');

            // Reset input
            $this->resetInput();
        } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatchBrowserEvent('alertify-error', [
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Reset input form setelah simpan
     */
    public function resetInput()
    {
        $this->ms_desa_id = '';
        $this->nama_kelompok = '';
        $this->nama_masjid = '';
        $this->alamat = '';
        $this->peta = '';
        $this->deskripsi = '';
    }

    public function render()
    {
        return view('livewire.administrasi.kelompok.create',[
            'listDesa' => Desa::orderBy('nama_desa')->get()
        ]);
    }
}
