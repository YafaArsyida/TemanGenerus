<?php

namespace App\Http\Livewire\Sistem\Pengguna;

use App\Models\Desa;
use App\Models\Kelompok;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Create extends Component
{
    public $nama, $email, $password, $peran;
    public $telepon;
    public $scope_type;
    public $scope_id = []; // bisa multi (desa / kelompok)
    public $selected_desa_id; // khusus untuk filter kelompok

    public $select_desa = [];

    protected $listeners = [
        'openCreatePengguna' => 'initCreate'
    ];

    public function initCreate()
    {
        // reset semua input
        $this->resetInput();

        // kalau ada data select (misal desa), reload di sini
        $this->select_desa = Desa::orderBy('nama_desa')->get();

        // optional: set default
        $this->scope_type = null;
    }

    protected function rules()
    {
        return [
            'nama' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'email' => 'required|unique:ms_pengguna,email',
            'password' => 'required|string|min:6',
            'peran' => 'required|string|max:50',
            'scope_type' => 'required|in:daerah,desa,kelompok',

            'scope_id' => 'required_if:scope_type,desa,kelompok|array|min:1',
        ];
    }

    protected $messages = [
        'nama.required' => 'Nama petugas tidak boleh kosong',
        'nama.max' => 'Nama maksimal 255 karakter',

        'telepon.max' => 'Nomor telepon maksimal 20 karakter',

        'email.required' => 'Email tidak boleh kosong',
        'email.unique' => 'Email ini sudah digunakan',

        'password.required' => 'Password tidak boleh kosong',
        'password.min' => 'Password minimal 6 karakter',

        'peran.required' => 'Peran wajib dipilih',

        'scope_type.required' => 'Scope akses wajib dipilih',
        'scope_type.in' => 'Scope akses tidak valid',

        'scope_id.required_if' => 'Silakan pilih minimal 1 data sesuai scope',
        'scope_id.array' => 'Format pilihan akses tidak valid',
        'scope_id.min' => 'Pilih minimal 1 data akses',
    ];

    public function updated($field)
    {
        $this->validateOnly($field);
    }

    public function updatedScopeType()
    {
        $this->scope_id = [];
        $this->selected_desa_id = null;
    }

    public function updatedSelectedDesaId()
    {
        $this->scope_id = []; // reset kelompok saat desa berubah
    }

    public function getKelompokByDesaProperty()
    {
        if (!$this->selected_desa_id) return collect();

        return Kelompok::where('ms_desa_id', $this->selected_desa_id)->get();
    }

    public function save()
    {
        $validatedData = $this->validate();
        $validatedData['password'] = Hash::make($validatedData['password']);

        DB::beginTransaction();

        try {

            $user = User::create($validatedData);

            // 🔥 INSERT AKSES BERDASARKAN SCOPE
            if ($this->scope_type == 'daerah') {

                DB::table('ms_akses_pengguna')->insert([
                    'ms_pengguna_id' => $user->ms_pengguna_id,
                    'scope_type' => 'daerah',
                    'scope_id' => auth()->user()->ms_daerah_id ?? 1, // sesuaikan
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                foreach ($this->scope_id as $id) {
                    DB::table('ms_akses_pengguna')->insert([
                        'ms_pengguna_id' => $user->ms_pengguna_id,
                        'scope_type' => $this->scope_type,
                        'scope_id' => $id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            DB::commit();

            $this->dispatchBrowserEvent('alertify-success', ['message' => 'Berhasil menambah petugas!']);
            $this->dispatchBrowserEvent('hide-modal', ['modalId' => 'ModalAddPengguna']);
            $this->emit('refreshPengguna');
            $this->resetInput();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
    }

    public function resetInput()
    {
        $this->nama = '';
        $this->telepon = '';
        $this->email = '';
        $this->password = '';
        $this->peran = '';

        // 🔥 reset scope
        $this->scope_type = null;
        $this->scope_id = [];
        $this->selected_desa_id = null;

        // opsional: bersihkan error & validation state Livewire
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.sistem.pengguna.create');
    }
}
