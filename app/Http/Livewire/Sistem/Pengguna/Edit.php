<?php

namespace App\Http\Livewire\Sistem\Pengguna;

use App\Models\Desa;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Edit extends Component
{
    public $ms_pengguna_id;
    public $nama, $telepon, $email, $peran, $password;
    public $ms_desa_id = []; // Menyimpan jenjang yang dipilih
    public $selectedDesa = []; // Menyimpan jenjang yang sudah dipilih oleh pengguna (untuk checkbox yang tercentang)

    protected $listeners = ['editPengguna'];

    public function editPengguna($ms_pengguna_id)
    {
        // Ambil data pengguna berdasarkan ID
        $pengguna = User::findOrFail($ms_pengguna_id);

        // Set properti dengan data pengguna
        $this->ms_pengguna_id = $pengguna->ms_pengguna_id;
        $this->nama = $pengguna->nama;
        $this->telepon = $pengguna->telepon;
        $this->email = $pengguna->email;
        $this->peran = $pengguna->peran;

        // Pastikan aksesJenjang ada dan ambil data jenjang yang sudah dipilih
        if ($pengguna->ms_akses_pengguna) {
            $this->selectedDesa = $pengguna->ms_akses_pengguna->pluck('ms_desa_id')->toArray();
        } else {
            $this->selectedDesa = []; // Jika tidak ada akses jenjang, set ke array kosong
        }

        // Set ms_desa_id untuk checkbox
        $this->ms_desa_id = $this->selectedDesa;
    }

    public function updatePengguna()
    {
        $this->validate([
            'nama' => 'required|string|max:100',
            'telepon'   => 'nullable|string|max:20',
            'email' => 'required|max:25',
            'peran' => 'required|string|max:50',
            'password' => 'nullable|min:6', // Validasi password baru (opsional)
            'ms_desa_id' => 'required|array|min:1', // Validasi jenjang yang dipilih
        ]);

        // Cari pengguna berdasarkan ID
        $pengguna = User::findOrFail($this->ms_pengguna_id);

        // Update data pengguna
        $pengguna->update([
            'nama' => $this->nama,
            'telepon' => $this->telepon,
            'email' => $this->email,
            'peran' => $this->peran,
        ]);

        // Jika password diisi, update password
        if (!empty($this->password)) {
            $pengguna->password = Hash::make($this->password);
            $pengguna->save();
        }

        // Hapus akses jenjang lama
        DB::table('ms_akses_pengguna')
            ->where('ms_pengguna_id', $pengguna->ms_pengguna_id)
            ->delete();

        // Masukkan akses jenjang yang baru
        foreach ($this->ms_desa_id as $ms_desa_id) {
            DB::table('ms_akses_pengguna')->insert([
                'ms_pengguna_id' => $pengguna->ms_pengguna_id,
                'ms_desa_id' => $ms_desa_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Emit event untuk memberikan feedback pada pengguna
        $this->emit('refreshPengguna');
        $this->dispatchBrowserEvent('alertify-success', ['message' => 'Data pengguna berhasil diperbarui']);
        $this->dispatchBrowserEvent('hide-modal', ['modalId' => 'ModalEditPengguna']);

        // Reset field input untuk modal edit
        $this->resetInputFields();
    }

    private function resetInputFields()
    {
        $this->ms_pengguna_id = null;
        $this->nama = '';
        $this->telepon = '';
        $this->email = '';
        $this->peran = '';
        $this->password = ''; // Reset password
        $this->ms_desa_id = []; // Reset jenjang yang dipilih
    }

    public function render()
    {
        return view('livewire.sistem.pengguna.edit',[
            'select_desa' => Desa::get(),
        ]);
    }
}
