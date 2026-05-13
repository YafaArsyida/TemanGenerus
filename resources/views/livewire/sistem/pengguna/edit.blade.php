<div>
    <div wire:ignore.self class="modal fade" id="ModalEditPengguna" tabindex="-1"
        aria-labelledby="ModalEditPenggunaLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content border-0 overflow-hidden rounded-4">
                {{-- HEADER --}}
                <div class="modal-header bg-light border-bottom px-4 py-3">
                    <div>
                        <h5 class="modal-title fw-bold mb-1">
                            <i class="ri-user-settings-line text-warning me-1">
                            </i>
                            Edit Data Petugas
                        </h5>
                        <small class="text-muted">
                            Perbarui informasi pengguna, role, dan hak akses sistem
                        </small>
                    </div>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal">
                    </button>
                </div>
                {{-- FORM --}}
                <form wire:submit.prevent="updatePengguna">
                    <div class="modal-body bg-light-subtle">
                        <div class="row g-4">
                            {{-- ===================================== --}} {{-- LEFT SIDE --}} {{--
                            ===================================== --}}
                            <div class="col-xl-4">
                                <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                                    {{-- HEADER --}}
                                    <div class="bg-warning bg-gradient p-4 text-center">
                                        <div class="avatar-lg mx-auto mb-3">
                                            <div
                                                class="avatar-title rounded-circle bg-white text-warning fs-2 fw-bold shadow">
                                                {{ strtoupper(substr($nama,0,1)) }}
                                            </div>
                                        </div>
                                        <h5 class="text-white fw-bold mb-1">
                                            {{ $nama ?: 'Nama Pengguna' }}
                                        </h5>
                                        <small class="text-white-75">
                                            {{ $email ?: 'email@example.com' }}
                                        </small>
                                    </div>
                                    {{-- BODY --}}
                                    <div class="card-body">
                                        {{-- NAMA --}}
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">
                                                Nama Pengguna
                                                <span class="text-danger">
                                                    *
                                                </span>
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-0">
                                                    <i class="ri-user-line">
                                                    </i>
                                                </span>
                                                <input type="text" wire:model.defer="nama"
                                                    class="form-control border-0 bg-light"
                                                    placeholder="Masukkan nama pengguna">
                                            </div>
                                            @error('nama')
                                            <small class="text-danger">
                                                {{ $message }}
                                            </small>
                                            @enderror
                                        </div>
                                        {{-- TELEPON --}}
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">
                                                Telepon
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-0">
                                                    <i class="ri-phone-line">
                                                    </i>
                                                </span>
                                                <input type="text" wire:model.defer="telepon"
                                                    class="form-control border-0 bg-light" placeholder="08xxxxxxxxxx">
                                            </div>
                                            @error('telepon')
                                            <small class="text-danger">
                                                {{ $message }}
                                            </small>
                                            @enderror
                                        </div>
                                        {{-- EMAIL --}}
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">
                                                Email
                                                <span class="text-danger">
                                                    *
                                                </span>
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-0">
                                                    <i class="ri-mail-line">
                                                    </i>
                                                </span>
                                                <input type="email" wire:model.defer="email"
                                                    class="form-control border-0 bg-light" placeholder="nama@email.com">
                                            </div>
                                            @error('email')
                                            <small class="text-danger">
                                                {{ $message }}
                                            </small>
                                            @enderror
                                        </div>
                                        {{-- PASSWORD --}}
                                        <div>
                                            <label class="form-label fw-semibold">
                                                Password Baru
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-0">
                                                    <i class="ri-lock-password-line">
                                                    </i>
                                                </span>
                                                <input type="password" wire:model.defer="password"
                                                    class="form-control border-0 bg-light"
                                                    placeholder="Kosongkan jika tidak diubah">
                                            </div>
                                            <small class="text-muted">
                                                Password lama tetap digunakan jika dikosongkan
                                            </small>
                                            @error('password')
                                            <div>
                                                <small class="text-danger">
                                                    {{ $message }}
                                                </small>
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- ===================================== --}} {{-- RIGHT SIDE --}} {{--
                            ===================================== --}}
                            <div class="col-xl-8">
                                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                                    {{-- HEADER --}}
                                    <div class="card-header bg-white border-bottom px-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <h6 class="fw-bold mb-1">
                                                    Pengaturan Role & Hak Akses
                                                </h6>
                                                <small class="text-muted">
                                                    Atur wilayah dan level akses pengguna
                                                </small>
                                            </div>
                                            <div>
                                                <span class="badge bg-warning-subtle text-warning px-3 py-2">
                                                    EDIT MODE
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- BODY --}}
                                    <div class="card-body">
                                        <div class="row g-4">
                                            {{-- ROLE --}}
                                            <div class="col-lg-6">
                                                <label class="form-label fw-semibold">
                                                    Peran
                                                    <span class="text-danger">
                                                        *
                                                    </span>
                                                </label>
                                                <select wire:model.defer="peran"
                                                    class="form-select shadow-sm border-light rounded-3">
                                                    <option value="">
                                                        Pilih Peran
                                                    </option>
                                                    <option value="superadmin">
                                                        Super Admin
                                                    </option>
                                                    <option value="administrasi">
                                                        Administrasi
                                                    </option>
                                                </select>
                                                @error('peran')
                                                <small class="text-danger">
                                                    {{ $message }}
                                                </small>
                                                @enderror
                                            </div>
                                            {{-- SCOPE --}}
                                            <div class="col-lg-6">
                                                <label class="form-label fw-semibold">
                                                    Scope Akses
                                                    <span class="text-danger">
                                                        *
                                                    </span>
                                                </label>
                                                <select wire:model="scope_type"
                                                    class="form-select shadow-sm border-light rounded-3">
                                                    <option value="">
                                                        Pilih Scope
                                                    </option>
                                                    <option value="daerah">
                                                        Daerah
                                                    </option>
                                                    <option value="desa">
                                                        Per Desa
                                                    </option>
                                                    <option value="kelompok">
                                                        Per Kelompok
                                                    </option>
                                                </select>
                                                @error('scope_type')
                                                <small class="text-danger">
                                                    {{ $message }}
                                                </small>
                                                @enderror
                                            </div>
                                            {{-- ================= DYNAMIC ACCESS ================= --}}
                                            @if($scope_type)
                                            <div class="col-12">
                                                <div class="border rounded-4 p-4 bg-light-subtle">
                                                    {{-- HEADER --}}
                                                    <div class="mb-3">
                                                        <h6 class="fw-bold mb-1">
                                                            Pengaturan Hak Akses
                                                        </h6>
                                                        <small class="text-muted">
                                                            Pilih wilayah yang dapat diakses pengguna
                                                        </small>
                                                    </div>
                                                    {{-- DAERAH --}} @if($scope_type == 'daerah')
                                                    <div
                                                        class="alert alert-success border-0 rounded-4 mb-0 d-flex align-items-start">
                                                        <div class="me-3 fs-3">
                                                            <i class="ri-earth-line">
                                                            </i>
                                                        </div>
                                                        <div>
                                                            <div class="fw-bold">
                                                                Akses Penuh Daerah
                                                            </div>
                                                            <small>
                                                                Pengguna dapat mengakses seluruh desa, kelompok,
                                                                laporan, dan administrasi
                                                                sistem.
                                                            </small>
                                                        </div>
                                                    </div>
                                                    @endif {{-- DESA --}} @if($scope_type == 'desa')
                                                    <div>
                                                        <label class="fw-semibold mb-3">
                                                            Pilih Desa
                                                        </label>
                                                        <div class="row g-3">
                                                            @foreach ($select_desa as $item)
                                                            <div class="col-lg-4 col-md-6">
                                                                <label
                                                                    class="border rounded-4 p-3 w-100 bg-white shadow-sm cursor-pointer">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            wire:model="scope_id"
                                                                            value="{{ $item->ms_desa_id }}">
                                                                        <span class="fw-semibold ms-1">
                                                                            {{ $item->nama_desa }}
                                                                        </span>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    @endif {{-- KELOMPOK --}} @if($scope_type == 'kelompok') {{-- STEP 1
                                                    --}}
                                                    <div class="mb-4">
                                                        <label class="fw-semibold mb-2">
                                                            1. Pilih Desa
                                                        </label>
                                                        <select wire:model="selected_desa_id"
                                                            class="form-select rounded-3 shadow-sm border-light">
                                                            <option value="">
                                                                Pilih Desa
                                                            </option>
                                                            @foreach ($select_desa as $item)
                                                            <option value="{{ $item->ms_desa_id }}">
                                                                {{ $item->nama_desa }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    {{-- STEP 2 --}} @if($selected_desa_id)
                                                    <div>
                                                        <label class="fw-semibold mb-3">
                                                            2. Pilih Kelompok
                                                        </label>
                                                        <div class="row g-3">
                                                            @foreach ($this->kelompokByDesa as $item)
                                                            <div class="col-lg-4 col-md-6">
                                                                <label
                                                                    class="border rounded-4 p-3 w-100 bg-white shadow-sm cursor-pointer">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            wire:model="scope_id"
                                                                            value="{{ $item->ms_kelompok_id }}">
                                                                        <span class="fw-semibold ms-1">
                                                                            {{ $item->nama_kelompok }}
                                                                        </span>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    @endif @endif
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- FOOTER --}}
                    <div class="modal-footer bg-white border-top px-4 py-3">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">
                            <i class="ri-close-line me-1">
                            </i>
                            Tutup
                        </button>
                        <button type="submit" class="btn btn-warning rounded-pill px-4 text-white">
                            <i class="ri-save-3-line me-1">
                            </i>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>