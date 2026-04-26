<?php

namespace App\Http\Livewire\Sistem\Pengguna;

use App\Models\Desa;
use App\Models\Kelompok;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Edit extends Component
{
    public $ms_pengguna_id;
    public $nama, $telepon, $email, $peran, $password;

    public $scope_type;
    public $scope_id = [];
    public $selected_desa_id;

    public $select_desa = [];

    protected $listeners = ['editPengguna' => 'initEdit'];

    public function initEdit($id)
    {
        $this->resetInput();

        $user = User::with('ms_akses_pengguna')->findOrFail($id);

        // basic data
        $this->ms_pengguna_id = $user->ms_pengguna_id;
        $this->nama = $user->nama;
        $this->telepon = $user->telepon;
        $this->email = $user->email;
        $this->peran = $user->peran;

        // load desa
        $this->select_desa = Desa::orderBy('nama_desa')->get();

        // 🔥 mapping akses
        $akses = $user->ms_akses_pengguna;

        if ($akses->isNotEmpty()) {

            $this->scope_type = $akses->first()->scope_type;

            $this->scope_id = $akses->pluck('scope_id')->toArray();

            // khusus kelompok → set desa parent
            if ($this->scope_type == 'kelompok') {
                $kelompok = Kelompok::whereIn('ms_kelompok_id', $this->scope_id)->first();
                $this->selected_desa_id = $kelompok?->ms_desa_id;
            }
        }
    }

    protected function rules()
    {
        return [
            'nama' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:20',

            // 🔥 penting: ignore diri sendiri
            'email' => 'required|unique:ms_pengguna,email,' . $this->ms_pengguna_id . ',ms_pengguna_id',

            // 🔥 edit: password tidak wajib
            'password' => 'nullable|string|min:6',

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
        'email.unique' => 'Email sudah digunakan oleh pengguna lain',

        'password.min' => 'Password minimal 6 karakter',

        'peran.required' => 'Peran wajib dipilih',

        'scope_type.required' => 'Scope akses wajib dipilih',
        'scope_type.in' => 'Scope akses tidak valid',

        'scope_id.required_if' => 'Silakan pilih minimal 1 akses',
        'scope_id.array' => 'Format akses tidak valid',
        'scope_id.min' => 'Pilih minimal 1 akses',
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

    public function updatePengguna()
    {
        $validatedData = $this->validate();

        DB::beginTransaction();

        try {

            $user = User::findOrFail($this->ms_pengguna_id);

            // update basic
            $user->update([
                'nama' => $this->nama,
                'telepon' => $this->telepon,
                'email' => $this->email,
                'peran' => $this->peran,
            ]);

            // password opsional
            if ($this->password) {
                $user->update([
                    'password' => Hash::make($this->password)
                ]);
            }

            // 🔥 hapus akses lama
            DB::table('ms_akses_pengguna')
                ->where('ms_pengguna_id', $this->ms_pengguna_id)
                ->delete();

            // 🔥 insert ulang akses baru
            if ($this->scope_type == 'daerah') {

                DB::table('ms_akses_pengguna')->insert([
                    'ms_pengguna_id' => $this->ms_pengguna_id,
                    'scope_type' => 'daerah',
                    'scope_id' => auth()->user()->ms_daerah_id ?? 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {

                foreach ($this->scope_id as $id) {
                    DB::table('ms_akses_pengguna')->insert([
                        'ms_pengguna_id' => $this->ms_pengguna_id,
                        'scope_type' => $this->scope_type,
                        'scope_id' => $id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            DB::commit();

            $this->dispatchBrowserEvent('alertify-success', ['message' => 'Berhasil update petugas!']);
            $this->dispatchBrowserEvent('hide-modal', ['modalId' => 'ModalEditPengguna']);
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
        return view('livewire.sistem.pengguna.edit');
    }
}
