<?php

namespace App\Http\Livewire\Parameter;

use App\Models\Desa as ModelsDesa;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Desa extends Component
{
    public $selectedDesa = null;

    public function updatedSelectedDesa()
    {
        $this->checkAndEmitParameters();
    }

    public function mount()
    {
        $firstDesa = ModelsDesa::whereIn('ms_desa_id', function ($query) {
            $query->select('ms_desa_id')
                ->from('ms_akses_pengguna')
                ->where('ms_pengguna_id', Auth::id());
        })->first();

        $this->selectedDesa = $firstDesa->ms_desa_id ?? null;
    }

    private function checkAndEmitParameters()
    {
        if ($this->selectedDesa !== null) {
            $this->emit('parameterUpdated', $this->selectedDesa);
            $this->dispatchBrowserEvent('alertify-success', ['message' => 'Memperbarui...']);
        }
    }

    public function refreshParameters()
    {
        $this->selectedDesa = null;
        $this->emit('parameterUpdated', null);
    }

    public function render()
    {
        if ($this->selectedDesa) {
            $this->emit('parameterUpdated', $this->selectedDesa);
        }

        return view('livewire.parameter.desa', [
            'select_desa' => ModelsDesa::whereIn('ms_desa_id', function ($query) {
                $query->select('ms_desa_id')
                    ->from('ms_akses_pengguna')
                    ->where('ms_pengguna_id', Auth::id());
            })->get() // <-- WAJIB GET()
        ]);
    }
}
