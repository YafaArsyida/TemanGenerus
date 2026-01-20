<?php

namespace App\Http\Livewire\Administrasi\Desa;

use App\Models\Desa;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Create extends Component
{
    public $nama_desa, $nama_masjid, $alamat, $deskripsi, $peta;

    protected $listeners = [
        'DesaCreate',
    ];

    public function DesaCreate()
    {
        $this->resetInput();
        $this->emitSelf('render');
    }

    protected function rules()
    {
        return [
            'nama_desa'   => 'required|string|max:50',
            'nama_masjid' => 'required|string|max:50',
            'alamat'      => 'nullable|string|max:255',
            'peta'        => 'nullable|url',
            'deskripsi'   => 'nullable|string',
        ];
    }

    protected $messages = [
        'nama_desa.required' => 'Nama Desa tidak boleh kosong',
        'nama_masjid.required' => 'Nama Masjid tidak boleh kosong',
        'peta.url' => 'Tautan peta harus berupa URL valid Google Maps',
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

            Desa::create([
                'nama_desa' => $this->nama_desa,
                'nama_masjid' => $this->nama_masjid,
                'alamat' => $this->alamat,
                'peta' => $this->peta,
                'deskripsi'  => $this->deskripsi,
            ]);

            DB::commit();

            $this->dispatchBrowserEvent('alertify-success', ['message' => 'Berhasil menambah desa!']);
            $this->dispatchBrowserEvent('hide-modal', ['modalId' => 'ModalDesaCreate']);
            $this->emit('DesaIndex');
            $this->emit('KelompokIndex');
            $this->resetInput();
        } catch (\Exception $e) {
            DB::rollBack();

            $this->dispatchBrowserEvent('alertify-error', ['message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function resetInput()
    {
        $this->nama_desa = '';
        $this->nama_masjid = '';
        $this->alamat = '';
        $this->deskripsi = '';
    }

    public function render()
    {
        return view('livewire.administrasi.desa.create');
    }
}
