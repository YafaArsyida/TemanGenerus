<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    <div wire:ignore.self class="modal fade" id="ModalEditPengguna" tabindex="-1" aria-labelledby="ModalAddSiswa"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
            
                <div class="modal-header bg-light p-3">
                    <h5 class="modal-title fw-bold">
                        <i class="ri-user-edit-line me-1 text-warning"></i> Edit Data Petugas
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                </div>
            
                <form wire:submit.prevent="updatePengguna">
                    <div class="modal-body">
                        <div class="row g-3">
                        
                            {{-- ================= LEFT: DATA PENGGUNA ================= --}}
                            <div class="col-xl-4">
                        
                                <div class="card shadow-sm border-0 h-100">
                        
                                    <div class="card-header bg-warning text-white">
                                        <h6 class="mb-0">Edit Pengguna</h6>
                                        <small>Perbarui data petugas</small>
                                    </div>
                        
                                    <div class="card-body">
                        
                                        {{-- Nama --}}
                                        <div class="mb-3">
                                            <label class="form-label">Nama <span class="text-danger">*</span></label>
                                            <input type="text" wire:model.defer="nama" class="form-control">
                                            @error('nama') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                        
                                        {{-- Telepon --}}
                                        <div class="mb-3">
                                            <label class="form-label">Telepon</label>
                                            <input type="text" wire:model.defer="telepon" class="form-control">
                                            @error('telepon') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                        
                                        {{-- Email --}}
                                        <div class="mb-3">
                                            <label class="form-label">Email <span class="text-danger">*</span></label>
                                            <input type="text" wire:model.defer="email" class="form-control">
                                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                        
                                        {{-- Password --}}
                                        <div class="mb-0">
                                            <label class="form-label">Password Baru</label>
                                            <input type="password" wire:model.defer="password" class="form-control"
                                                placeholder="Kosongkan jika tidak diubah">
                                            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                        
                                    </div>
                                </div>
                            </div>
                        
                            {{-- ================= RIGHT: ROLE & AKSES ================= --}}
                            <div class="col-xl-8">
                        
                                <div class="card shadow-sm border-0">
                        
                                    <div class="card-header bg-white border-bottom">
                                        <h6 class="mb-0">Role & Akses</h6>
                                        <small class="text-muted">Perbarui hak akses pengguna</small>
                                    </div>
                        
                                    <div class="card-body">
                        
                                        <div class="row g-3">
                        
                                            {{-- Peran --}}
                                            <div class="col-lg-6">
                                                <label class="form-label">Peran <span class="text-danger">*</span></label>
                                                <select wire:model.defer="peran" class="form-select">
                                                    <option value="">Pilih Peran</option>
                                                    <option value="superadmin">Super Admin</option>
                                                    <option value="administrasi">Administrasi</option>
                                                </select>
                                                @error('peran') <small class="text-danger">{{ $message }}</small> @enderror
                                            </div>
                        
                                            {{-- Scope --}}
                                            <div class="col-lg-6">
                                                <label class="form-label">Scope Akses <span class="text-danger">*</span></label>
                                                <select wire:model="scope_type" class="form-select">
                                                    <option value="">Pilih Scope</option>
                                                    <option value="daerah">Daerah</option>
                                                    <option value="desa">Per Desa</option>
                                                    <option value="kelompok">Per Kelompok</option>
                                                </select>
                                                @error('scope_type') <small class="text-danger">{{ $message }}</small> @enderror
                                            </div>
                        
                                            {{-- ================= AKSES DINAMIS ================= --}}
                                            @if($scope_type)
                        
                                            <div class="col-12">
                                                <div class="border rounded p-3 bg-light">
                        
                                                    {{-- DAERAH --}}
                                                    @if($scope_type == 'daerah')
                                                    <div class="text-muted">
                                                        Akses penuh ke seluruh desa & kelompok
                                                    </div>
                                                    @endif
                        
                                                    {{-- DESA --}}
                                                    @if($scope_type == 'desa')
                                                    <label class="fw-semibold mb-2">Pilih Desa</label>
                        
                                                    <div class="row">
                                                        @foreach ($select_desa as $item)
                                                        <div class="col-md-4">
                                                            <div class="form-check">
                                                                <input type="checkbox" wire:model="scope_id" value="{{ $item->ms_desa_id }}">
                                                                <label>{{ $item->nama_desa }}</label>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                    @endif
                        
                                                    {{-- KELOMPOK --}}
                                                    @if($scope_type == 'kelompok')
                        
                                                    {{-- Step 1 --}}
                                                    <div class="mb-3">
                                                        <label class="fw-semibold">1. Pilih Desa</label>
                                                        <select wire:model="selected_desa_id" class="form-select">
                                                            <option value="">Pilih Desa</option>
                                                            @foreach ($select_desa as $item)
                                                            <option value="{{ $item->ms_desa_id }}">
                                                                {{ $item->nama_desa }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                        
                                                    {{-- Step 2 --}}
                                                    @if($selected_desa_id)
                                                    <div>
                                                        <label class="fw-semibold">2. Pilih Kelompok</label>
                        
                                                        <div class="row mt-2">
                                                            @foreach ($this->kelompokByDesa as $item)
                                                            <div class="col-md-4">
                                                                <div class="form-check">
                                                                    <input type="checkbox" wire:model="scope_id"
                                                                        value="{{ $item->ms_kelompok_id }}">
                                                                    <label>{{ $item->nama_kelompok }}</label>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    @endif
                        
                                                    @endif
                        
                                                </div>
                                            </div>
                        
                                            @endif
                        
                                        </div>
                        
                                    </div>
                                </div>
                            </div>
                        
                        </div>
                    </div>
            
                    <div class="modal-footer">
                        <a href="javascript:void(0);" class="btn btn-link link-success shadow-none fw-medium"
                            data-bs-dismiss="modal">
                            <i class="ri-close-line me-1 align-middle"></i> Tutup
                        </a>
            
                        <button type="submit" class="btn btn-primary">
                            <i class="ri-save-3-line me-1"></i> Simpan Perubahan
                        </button>
                    </div>
            
                </form>
            </div>
        </div>
    </div>
</div>