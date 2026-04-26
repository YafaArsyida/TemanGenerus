<?php

namespace App\Http\Livewire\Sistem\Pengguna;

use App\Models\Desa;
use App\Models\Kelompok;
use App\Models\User;
use Livewire\Component;

class Detail extends Component
{
    public $penggunaDetail;

    public $nama, $email, $telepon, $peran, $alamat, $created_at;
    public $aksesPengguna = [];

    public $scope_type;

    protected $listeners = ['detailPengguna'];

    public function detailPengguna($ms_pengguna_id)
    {
        $pengguna = User::with('ms_akses_pengguna')->findOrFail($ms_pengguna_id);

        $this->penggunaDetail = $pengguna;

        $this->nama = $pengguna->nama;
        $this->email = $pengguna->email;
        $this->telepon = $pengguna->telepon;
        $this->peran = $pengguna->peran;
        $this->created_at = $pengguna->created_at->format('d M Y H:i');

        // 🔥 ambil akses
        $akses = $pengguna->ms_akses_pengguna;

        if ($akses->isEmpty()) {
            $this->aksesPengguna = ['Tidak ada akses'];
            return;
        }

        $scope = $akses->first()->scope_type;

        if ($scope == 'daerah') {
            $this->aksesPengguna = ['Semua Desa & Kelompok'];
        }

        if ($scope == 'desa') {
            $desaIds = $akses->pluck('scope_id');
            $this->aksesPengguna = Desa::whereIn('ms_desa_id', $desaIds)
                ->pluck('nama_desa')
                ->toArray();
        }

        if ($scope == 'kelompok') {
            $kelompokIds = $akses->pluck('scope_id');
            $this->aksesPengguna = Kelompok::whereIn('ms_kelompok_id', $kelompokIds)
                ->pluck('nama_kelompok')
                ->toArray();
        }

        $this->scope_type = $scope;
    }

    public function render()
    {
        return view('livewire.sistem.pengguna.detail');
    }
}
