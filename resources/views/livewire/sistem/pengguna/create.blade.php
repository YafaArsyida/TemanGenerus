<div>
    <div wire:ignore.self class="modal fade zoomIn" id="ModalAddPengguna" tabindex="-1"
        aria-labelledby="ModalAddPenggunaLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                {{-- HEADER --}}
                <div class="modal-header bg-primary bg-gradient border-0 px-4 py-3">
                    <div>
                        <h4 class="modal-title fw-bold text-white mb-1" id="ModalAddPenggunaLabel">
                            <i class="ri-user-add-line me-2">
                            </i>
                            Tambah Petugas Baru
                        </h4>
                        <p class="text-white text-opacity-75 mb-0 fs-13">
                            Tambahkan akun petugas administrasi dan atur hak akses sistem.
                        </p>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                {{-- FORM --}}
                <form wire:submit.prevent="save">
                    <div class="modal-body bg-light-subtle p-4">
                        <div class="row g-4">
                            {{-- ================= LEFT SIDE ================= --}}
                            <div class="col-xl-4">
                                <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                                    {{-- CARD HEADER --}}
                                    <div class="card-header bg-soft-primary border-0 py-3">
                                        <h5 class="mb-1 fw-bold text-primary">
                                            <i class="ri-user-line me-1">
                                            </i>
                                            Informasi Pengguna
                                        </h5>
                                        <small class="text-muted">
                                            Data akun dasar petugas administrasi
                                        </small>
                                    </div>
                                    {{-- CARD BODY --}}
                                    <div class="card-body p-4">
                                        {{-- NAMA --}}
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">
                                                Nama Lengkap
                                                <span class="text-danger">
                                                    *
                                                </span>
                                            </label>
                                            <input type="text" wire:model.defer="nama"
                                                class="form-control rounded-3 @error('nama') is-invalid @enderror"
                                                placeholder="Masukkan nama lengkap">
                                            @error('nama')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        {{-- TELEPON --}}
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">
                                                Nomor Telepon
                                            </label>
                                            <input type="text" wire:model.defer="telepon"
                                                class="form-control rounded-3 @error('telepon') is-invalid @enderror"
                                                placeholder="08xxxxxxxxxx">
                                            @error('telepon')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        {{-- EMAIL --}}
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">
                                                Email / Username
                                                <span class="text-danger">
                                                    *
                                                </span>
                                            </label>
                                            <input type="text" wire:model.defer="email"
                                                class="form-control rounded-3 @error('email') is-invalid @enderror"
                                                placeholder="contoh@email.com">
                                            @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        {{-- PASSWORD --}}
                                        <div class="mb-0">
                                            <label class="form-label fw-semibold">
                                                Password
                                                <span class="text-danger">
                                                    *
                                                </span>
                                            </label>
                                            <input type="password" wire:model.defer="password"
                                                class="form-control rounded-3 @error('password') is-invalid @enderror"
                                                placeholder="Minimal 8 karakter">
                                            @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- ================= RIGHT SIDE ================= --}}
                            <div class="col-xl-8">
                                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                                    {{-- HEADER --}}
                                    <div class="card-header bg-white border-bottom py-3">
                                        <h5 class="mb-1 fw-bold">
                                            <i class="ri-shield-user-line text-success me-1">
                                            </i>
                                            Role & Hak Akses
                                        </h5>
                                        <small class="text-muted">
                                            Tentukan level akses dan wilayah petugas
                                        </small>
                                    </div>
                                    {{-- BODY --}}
                                    <div class="card-body p-4">
                                        <div class="row g-4">
                                            {{-- PERAN --}}
                                            <div class="col-lg-6">
                                                <label class="form-label fw-semibold">
                                                    Peran Pengguna
                                                    <span class="text-danger">
                                                        *
                                                    </span>
                                                </label>
                                                <select wire:model.defer="peran"
                                                    class="form-select rounded-3 @error('peran') is-invalid @enderror">
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
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
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
                                                    class="form-select rounded-3 @error('scope_type') is-invalid @enderror">
                                                    <option value="">
                                                        Pilih Scope
                                                    </option>
                                                    <option value="daerah">
                                                        Akses Daerah
                                                    </option>
                                                    <option value="desa">
                                                        Per Desa
                                                    </option>
                                                    <option value="kelompok">
                                                        Per Kelompok
                                                    </option>
                                                </select>
                                                @error('scope_type')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                            {{-- DYNAMIC ACCESS --}} @if($scope_type)
                                            <div class="col-12">
                                                <div class="border rounded-4 bg-light-subtle p-4">
                                                    {{-- DAERAH --}} @if($scope_type == 'daerah')
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="avatar-sm">
                                                            <div
                                                                class="avatar-title rounded-circle bg-soft-success text-success">
                                                                <i class="ri-global-line fs-18">
                                                                </i>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-1 fw-semibold">
                                                                Akses Seluruh Daerah
                                                            </h6>
                                                            <p class="text-muted mb-0">
                                                                Petugas memiliki akses penuh ke seluruh desa dan
                                                                kelompok.
                                                            </p>
                                                        </div>
                                                    </div>
                                                    @endif {{-- DESA --}} @if($scope_type == 'desa')
                                                    <div>
                                                        <div class="mb-3">
                                                            <h6 class="fw-bold mb-1">
                                                                Pilih Desa
                                                            </h6>
                                                            <p class="text-muted mb-0 fs-13">
                                                                Petugas hanya dapat mengakses desa yang dipilih.
                                                            </p>
                                                        </div>
                                                        <div class="row g-3">
                                                            @foreach ($select_desa as $item)
                                                            <div class="col-lg-4 col-md-6">
                                                                <label
                                                                    class="card border rounded-3 shadow-sm h-100 cursor-pointer">
                                                                    <div class="card-body py-3 px-3">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input"
                                                                                type="checkbox" wire:model="scope_id"
                                                                                value="{{ $item->ms_desa_id }}">
                                                                            <span class="fw-semibold">
                                                                                {{ $item->nama_desa }}
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    @endif {{-- KELOMPOK --}} @if($scope_type == 'kelompok')
                                                    <div class="mb-4">
                                                        <label class="form-label fw-bold">
                                                            1. Pilih Desa
                                                        </label>
                                                        <select wire:model="selected_desa_id"
                                                            class="form-select rounded-3">
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
                                                    @if($selected_desa_id)
                                                    <div>
                                                        <div class="mb-3">
                                                            <h6 class="fw-bold mb-1">
                                                                2. Pilih Kelompok
                                                            </h6>
                                                            <p class="text-muted mb-0 fs-13">
                                                                Tentukan kelompok yang dapat diakses petugas.
                                                            </p>
                                                        </div>
                                                        <div class="row g-3">
                                                            @foreach ($this->kelompokByDesa as $item)
                                                            <div class="col-lg-4 col-md-6">
                                                                <label
                                                                    class="card border rounded-3 shadow-sm h-100 cursor-pointer">
                                                                    <div class="card-body py-3 px-3">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input"
                                                                                type="checkbox" wire:model="scope_id"
                                                                                value="{{ $item->ms_kelompok_id }}">
                                                                            <span class="fw-semibold">
                                                                                {{ $item->nama_kelompok }}
                                                                            </span>
                                                                        </div>
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
                    <div class="modal-footer border-0 bg-white px-4 py-3">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">
                            <i class="ri-close-line me-1">
                            </i>
                            Tutup
                        </button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">
                            <i class="ri-save-3-line me-1">
                            </i>
                            Simpan Pengguna
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>