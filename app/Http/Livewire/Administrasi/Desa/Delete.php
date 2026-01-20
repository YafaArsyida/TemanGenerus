<?php

namespace App\Http\Livewire\Administrasi\Desa;

use App\Models\Desa;
use App\Models\Kelompok;
use Livewire\Component;

class Delete extends Component
{
    public $desaId;

    protected $listeners = [
        'DesaDelete' => 'loadData'
    ];

    public function loadData($id)
    {
        $this->desaId = $id;
    }

    public function deleteDesa()
    {
        if (!$this->desaId) return;

        // Cek apakah desa dipakai kelompok
        $used = Kelompok::where('ms_desa_id', $this->desaId)->exists();

        if ($used) {
            // Jika digunakan, jangan hapus
            $this->dispatchBrowserEvent('alertify-error', [
                'message' => 'Gagal, Sudah digunakan kelompok!'
            ]);
            return;
        }

        // Aman → hapus
        Desa::where('ms_desa_id', $this->desaId)->delete();

        $this->dispatchBrowserEvent('hide-modal', ['modalId' => 'ModalDeleteDesa']);
        $this->emit('DesaIndex');
        $this->emit('KelompokIndex');
        $this->dispatchBrowserEvent('alertify-success', [
            'message' => 'Desa berhasil dihapus!'
        ]);
    }

    public function render()
    {
        return view('livewire.administrasi.desa.delete');
    }
}
