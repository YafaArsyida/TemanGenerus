<?php

namespace App\Http\Livewire\Sistem\Pengguna;

use App\Models\Desa;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Create extends Component
{
    public $nama, $email, $password, $peran;
    public $telepon;
    public $ms_desa_id = [];

    protected function rules()
    {
        return [
            'nama' => 'required|string|max:255',
            'telepon'   => 'nullable|string|max:20',
            'email' => 'required|unique:ms_pengguna,email',
            'password' => 'required|string|min:6',
            'peran' => 'required|string|max:50',
            'ms_desa_id' => 'required|array|min:1', // Validasi bahwa ms_desa_id dipilih
            'ms_desa_id.*' => 'exists:ms_desa,ms_desa_id',
        ];
    }

    protected $messages = [
        'nama.required' => 'Nama petugas tidak boleh kosong',
        'email.required' => 'Email tidak boleh kosong',
        // 'email.email' => 'Format email tidak valid',
        'email.unique' => 'Email ini sudah digunakan',
        'password.required' => 'Password tidak boleh kosong',
        'password.min' => 'Password harus minimal 6 karakter',
        'peran.required' => 'Peran tidak boleh kosong',
    ];

    public function updated($field)
    {
        $this->validateOnly($field);
    }

    public function save()
    {
        $validatedData = $this->validate();
        $validatedData['password'] = Hash::make($validatedData['password']);

        // Menyimpan pengguna baru
        $user = User::create($validatedData);

        // Loop untuk setiap jenjang yang dipilih dan masukkan ke tabel ms_akses_pengguna
        foreach ($this->ms_desa_id as $ms_desa_id) {
            DB::table('ms_akses_pengguna')->insert([
                'ms_pengguna_id' => $user->ms_pengguna_id, // ID pengguna yang baru dibuat
                'ms_desa_id' => $ms_desa_id, // ID jenjang yang dipilih
                'created_at' => now(), // Tanggal dibuat
                'updated_at' => now(), // Tanggal diupdate
            ]);
        }

        $this->dispatchBrowserEvent('alertify-success', ['message' => 'Berhasil menambah petugas!']);
        $this->resetInput();
        $this->dispatchBrowserEvent('hide-modal', ['modalId' => 'ModalAddPengguna']);
        $this->emit('refreshPengguna');
    }

    public function resetInput()
    {
        $this->nama = '';
        $this->telepon = '';
        $this->email = '';
        $this->password = '';
        $this->peran = '';
        $this->ms_desa_id = [];
    }
    public function render()
    {
        return view('livewire.sistem.pengguna.create',[
            'select_desa' => Desa::get(),
        ]);
    }
}
