<?php

namespace App\Http\Livewire\Administrasi\Generus;

use App\Models\Generus;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Delete extends Component
{
    public $generusId;

    protected $listeners = ['GenerusDelete'];

    /**
     * Terima ID Generus dari tombol
     */
    public function GenerusDelete($generusId)
    {
        $this->generusId = $generusId;
    }

    /**
     * Hapus Data Generus
     */
    public function deleteGenerus()
    {
        if (!$this->generusId) return;

        $generus = Generus::find($this->generusId);

        if (!$generus) {
            $this->dispatchBrowserEvent('alertify-error', [
                'message' => 'Data Generus tidak ditemukan'
            ]);
            return;
        }

        DB::beginTransaction();
        try {
            $generus->delete(); // support soft delete jika pakai SoftDeletes
            DB::commit();

            // Tutup modal
            $this->dispatchBrowserEvent('hide-modal', [
                'modalId' => 'ModalDeleteGenerus'
            ]);

            // Refresh Index
            $this->emit('GenerusIndex');

            $this->dispatchBrowserEvent('alertify-success', [
                'message' => 'Generus berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            $this->dispatchBrowserEvent('alertify-error', [
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.administrasi.generus.delete');
    }
}
