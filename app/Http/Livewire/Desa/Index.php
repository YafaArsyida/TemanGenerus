<?php

namespace App\Http\Livewire\Desa;

use App\Models\Desa;
use Livewire\Component;
use Livewire\WithPagination;


class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap'; // Gunakan tema Bootstrap

    public $search = '';
    public $selectedStatus = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    protected $listeners = ['desas' => '$refresh']; // Gunakan Livewire refresh untuk memuat ulang data

    public function render()
    {
        $query = Desa::query();

        $desas = $query->where(function ($query) {
            $query->where('nama_desa', 'like', '%' . $this->search . '%')
                ->orWhere('deskripsi', 'like', '%' . $this->search . '%');
        })
            ->orderBy('urutan', 'ASC')
            ->paginate(5);
        return view('livewire.desa.index', [
            'desas' => $desas,
        ]);
    }
}
