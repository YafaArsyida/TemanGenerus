<?php

namespace App\Http\Livewire\Sistem\Pengguna;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Delete extends Component
{
    public $deleteId = null; // ID pengguna yang mau dihapus

    protected $listeners = ['deletePengguna']; // menerima emit dari tombol

    public function deletePengguna($deleteId)
    {
        $this->deleteId = $deleteId;
    }

    public function ConfirmDeletePengguna()
    {
        if ($this->deleteId) {
            // Hapus data
            $user = User::find($this->deleteId);

            if ($user) {
                // Hapus akses desa dulu
                DB::table('ms_akses_pengguna')->where('ms_pengguna_id', $this->deleteId)->delete();

                $user->delete();

                $this->dispatchBrowserEvent('alertify-success', ['message' => 'Pengguna berhasil dihapus!']);
            }

            // Reset deleteId
            $this->deleteId = null;

            // Tutup modal via JS
            $this->dispatchBrowserEvent('hide-modal', ['modalId' => 'ModalDeletePengguna']);

            // Refresh tabel
            $this->emit('refreshPengguna');
        }
    }

    public function render()
    {
        return view('livewire.sistem.pengguna.delete');
    }
}
