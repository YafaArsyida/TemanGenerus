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
        $query = User::with([
            'ms_akses_pengguna.ms_desa',
            'ms_akses_pengguna.ms_kelompok',
            'ms_akses_pengguna.ms_daerah'
        ])
            ->where(function ($q) {
                $q->where('nama', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('peran', 'like', '%' . $this->search . '%');
            })
            ->get();

        $this->pengguna = $query->map(function ($user) {

            $akses = $user->ms_akses_pengguna->map(function ($akses) {
                switch ($akses->scope_type) {

                    case 'desa':
                        return 'Desa: ' . optional($akses->ms_desa)->nama_desa;

                    case 'kelompok':
                        return 'Kelompok: ' . optional($akses->ms_kelompok)->nama_kelompok;

                    case 'daerah':
                        return 'Daerah: ' . optional($akses->ms_daerah)->nama_daerah;

                    default:
                        return '-';
                }
            })->toArray();

            return [
                'ms_pengguna_id' => $user->ms_pengguna_id,
                'nama' => $user->nama,
                'email' => $user->email,
                'telepon' => $user->telepon,
                'peran' => $user->peran,
                'aksesPengguna' => $akses,
            ];
        })->toArray();
    }

    public function render()
    {
        return view('livewire.sistem.akses-pengguna.index');
    }
}
