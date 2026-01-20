<?php

namespace App\Http\Livewire\Administrasi\Generus;

use App\Imports\ImportGenerus;
use App\Models\Generus;
use App\Models\Kelompok;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class Import extends Component
{
    use WithFileUploads;

    public $selectedDesa = null;

    public $ms_kelompok_id = null;
    public $file_import = null;

    public $select_kelompok = [];
    public $newGenerusList = [];

    protected $listeners = [
        'showImportGenerus' => 'updateParameters'
    ];

    public function updateParameters($desaId)
    {
        $this->selectedDesa = $desaId;

        $this->reset([
            'ms_kelompok_id',
            'file_import',
            'newGenerusList',
        ]);

        $this->loadKelompok();
    }

    protected function loadKelompok()
    {
        if ($this->selectedDesa) {
            $this->select_kelompok = Kelompok::where('ms_desa_id', $this->selectedDesa)
                ->orderBy('nama_kelompok')
                ->get();
        } else {
            $this->select_kelompok = [];
        }
    }

    public function updatedFileImport()
    {
        $this->validate([
            'file_import' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            $import = new ImportGenerus();

            Excel::import($import, $this->file_import);

            $this->newGenerusList = $import->getCollection()->toArray();

            $this->dispatchBrowserEvent('alertify-success', [
                'message' => 'File generus berhasil dibaca!',
            ]);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('alertify-error', [
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ]);
        }
    }

    protected function rules()
    {
        return [
            'file_import'   => 'required|mimes:xlsx,xls,csv',
            'ms_kelompok_id' => 'required|exists:ms_kelompok,ms_kelompok_id',
        ];
    }

    protected $messages = [
        'file_import.required' => 'File Excel wajib diunggah.',
        'file_import.mimes'    => 'Format file harus xlsx, xls, atau csv.',

        'ms_kelompok_id.required' => 'Harap pilih kelompok.',
        'ms_kelompok_id.exists'   => 'Kelompok tidak valid.',
    ];

    public function updated($fields)
    {
        $this->validateOnly($fields);
    }

    public function importGenerus()
    {
        $this->validate();

        foreach ($this->newGenerusList as $row) {

            Generus::create([
                'ms_kelompok_id' => $this->ms_kelompok_id,

                'nama_generus'   => $row['nama_generus'],
                'nomor_telepon' => $row['nomor_telepon'] ?? null,
                'tempat_lahir'  => $row['tempat_lahir'] ?? null,
                'tanggal_lahir' => $row['tanggal_lahir'] ?? null,
                'jenis_kelamin' => $row['jenis_kelamin'] ?? null,

                // optional default
                'nomor_kartu' => null,
                'alamat'      => null,
                'deskripsi'   => 'Import',
            ]);
        }

        $this->dispatchBrowserEvent('alertify-success', [
            'message' => 'Data generus berhasil diimport!',
        ]);
        $this->dispatchBrowserEvent('hide-modal', [
            'modalId' => 'ModalImportGenerus'
        ]);

        $this->emit('GenerusIndex');

        $this->reset([
            'file_import',
            'newGenerusList',
            'ms_kelompok_id',
        ]);
    }
    public function render()
    {
        return view('livewire.administrasi.generus.import');
    }
}
