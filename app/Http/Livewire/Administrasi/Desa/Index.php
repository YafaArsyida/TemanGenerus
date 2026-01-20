<?php

namespace App\Http\Livewire\Administrasi\Desa;

use App\Models\Desa;
use Livewire\Component;

class Index extends Component
{
    public $search = '';
    public $namaJenjang = '';

    protected $listeners = [
        'DesaIndex' => '$refresh',
    ];

    public function render()
    {
        $data = Desa::query();
        // filter pencarian
        if ($this->search) {
            $data->where('nama_desa', 'like', '%' . $this->search . '%');
        }

        return view('livewire.administrasi.desa.index',[
            'data' => $data->get()
        ]);
    }
}
