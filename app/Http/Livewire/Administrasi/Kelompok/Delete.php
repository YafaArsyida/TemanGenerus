<?php

namespace App\Http\Livewire\Administrasi\Kelompok;

use App\Models\Kelompok;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Delete extends Component
{
    public $kelompokId;

    protected $listeners = ['KelompokDelete'];

    /**
     * Terima ID kelompok dari tombol
     */
    public function KelompokDelete($kelompokId)
    {
        $this->kelompokId = $kelompokId;
    }

    /**
     * Hapus data Kelompok
     */
    public function deleteKelompok()
    {
        if (!$this->kelompokId) return;

        // Cek relasi: misal jika ada anggota, generus, dll (opsional)
        $kelompok = Kelompok::find($this->kelompokId);
        if (!$kelompok) {
            $this->dispatchBrowserEvent('alertify-error', ['message' => 'Data Kelompok tidak ditemukan']);
            return;
        }

        // Contoh cek relasi (hapus jika tidak ada)
        // if ($kelompok->anggota()->count() > 0) {
        //     $this->dispatchBrowserEvent('alertify-error', ['message' => 'Kelompok memiliki anggota, tidak bisa dihapus']);
        //     return;
        // }

        DB::beginTransaction();
        try {
            $kelompok->delete(); // Soft delete jika model menggunakan SoftDeletes
            DB::commit();

            $this->dispatchBrowserEvent('hide-modal', ['modalId' => 'ModalDeleteKelompok']);
            $this->emit('KelompokIndex');
            $this->dispatchBrowserEvent('alertify-success', ['message' => 'Kelompok berhasil dihapus!']);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatchBrowserEvent('alertify-error', ['message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
    public function render()
    {
        return view('livewire.administrasi.kelompok.delete');
    }
}
