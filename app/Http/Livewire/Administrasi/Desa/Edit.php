<?php

namespace App\Http\Livewire\Administrasi\Desa;

use App\Models\Desa;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Edit extends Component
{
    public $ms_desa_id;
    public $nama_desa;
    public $nama_masjid;
    public $alamat;
    public $deskripsi;
    public $peta;

    protected $listeners = [
        'loadDataDesa'
    ];

    public function loadDataDesa($id)
    {
        $desa = Desa::find($id);

        if (!$desa) {
            $this->dispatchBrowserEvent('alertify-error', ['message' => 'Data desa tidak ditemukan']);
            return;
        }

        $this->ms_desa_id = $desa->ms_desa_id;
        $this->nama_desa = $desa->nama_desa;
        $this->nama_masjid = $desa->nama_masjid;
        $this->alamat = $desa->alamat;
        $this->deskripsi = $desa->deskripsi;
        $this->peta = $desa->peta;

        $this->dispatchBrowserEvent('show-modal', ['modalId' => 'ModalEditDesa']);
    }

    protected function rules()
    {
        return [
            'nama_desa' => 'required|string|max:50',
            'nama_masjid' => 'required|string|max:50',
            'alamat' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'peta' => 'nullable|string'
        ];
    }

    protected $messages = [
        'nama_desa.required' => 'Nama Desa tidak boleh kosong',
        'nama_masjid.required' => 'Nama Masjid tidak boleh kosong',
        'peta.url' => 'Tautan peta harus berupa URL valid Google Maps',

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

            Desa::where('ms_desa_id', $this->ms_desa_id)->update([
                'nama_desa' => $this->nama_desa,
                'nama_masjid' => $this->nama_masjid,
                'alamat' => $this->alamat,
                'deskripsi' => $this->deskripsi,
                'peta' => $this->peta,
            ]);

            DB::commit();

            $this->dispatchBrowserEvent('alertify-success', ['message' => 'Desa berhasil diperbarui!']);

            $this->dispatchBrowserEvent('hide-modal', ['modalId' => 'ModalEditDesa']);
            $this->emit('DesaIndex');
            $this->emit('KelompokIndex');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatchBrowserEvent('alertify-error', ['message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.administrasi.desa.edit');
    }
}
