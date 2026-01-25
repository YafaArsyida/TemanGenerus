<?php

namespace App\Http\Livewire\Sistem\AksesPengguna;

use App\Models\User;
use Livewire\Component;

class Index extends Component
{
    public $search = '';
    public $pengguna = [];

    protected $listeners = ['refreshPengguna' => 'loadPengguna']; // Gunakan Livewire refresh untuk memuat ulang data

    public function mount()
    {
        $this->loadPengguna();
    }

    public function updatedSearch()
    {
        $this->loadPengguna();
    }

    public function loadPengguna()
    {
        $query = User::with('ms_desa')
            ->where('nama', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->orWhere('peran', 'like', '%' . $this->search . '%')
            ->get();

        $this->pengguna = $query->map(function ($user) {
            return [
                'ms_pengguna_id' => $user->ms_pengguna_id,
                'nama' => $user->nama,
                'email' => $user->email,
                'telepon' => $user->telepon,
                'peran' => $user->peran,
                'aksesPengguna' => $user->ms_desa->pluck('nama_desa')->toArray(),
            ];
        })->toArray();
    }

    public function render()
    {
        return view('livewire.sistem.akses-pengguna.index');
    }
}
