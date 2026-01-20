<?php

namespace App\Http\Livewire\Sistem\Pengguna;

use App\Models\User;
use Livewire\Component;

class Detail extends Component
{
    public $penggunaDetail;

    public $nama, $email, $peran, $telepon, $alamat, $created_at;
    public $aksesPengguna = [];

    protected $listeners = ['detailPengguna'];

    public function detailPengguna($ms_pengguna_id)
    {
        // Temukan pengguna berdasarkan ID
        $pengguna = User::findOrFail($ms_pengguna_id);

        // Simpan detail pengguna dalam variabel
        $this->penggunaDetail = $pengguna;

        // Isi properti dengan data pengguna
        $this->nama = $pengguna->nama;
        $this->email = $pengguna->email;
        $this->peran = $pengguna->peran;
        $this->created_at = $pengguna->created_at->format('d F Y H:i');
        // Ambil jenjang yang dapat diakses pengguna
        $this->aksesPengguna = $pengguna->ms_desa->pluck('nama_desa')->toArray();
    }

    public function render()
    {
        return view('livewire.sistem.pengguna.detail');
    }
}
