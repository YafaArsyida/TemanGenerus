{{-- Success is as dangerous as failure. --}}
<div>
    <div wire:ignore.self class="modal fade" id="ModalAddPengguna" tabindex="-1" aria-labelledby="ModalAddPengguna"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
            
                <div class="modal-header bg-light p-3">
                    <h5 class="modal-title fw-bold">
                        <i class="ri-user-add-line me-1 text-success"></i> Petugas Baru
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                </div>
            
                <form wire:submit.prevent="save">
                    <div class="modal-body">
                        <div class="row g-3">
            
                            {{-- Nama --}}
                            <div class="col-lg-6">
                                <label for="nama" class="form-label">
                                    Nama <span class="text-danger">*</span>
                                </label>
                                <input type="text" wire:model.defer="nama" id="nama" class="form-control"
                                    placeholder="Nama lengkap petugas">
                                @error('nama')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
            
                            {{-- Telepon --}}
                            <div class="col-lg-6">
                                <label for="telepon" class="form-label">
                                    Nomor Telepon <span class="text-danger">*</span>
                                </label>
                                <input type="text" wire:model.defer="telepon" id="telepon" class="form-control"
                                    placeholder="Contoh: 08xxxxxxxxxx">
                                @error('telepon')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
            
                            {{-- Peran --}}
                            <div class="col-lg-6">
                                <label for="peran" class="form-label">
                                    Peran <span class="text-danger">*</span>
                                </label>
                                <select id="peran" wire:model.defer="peran" class="form-select">
                                    <option value="">Pilih Peran</option>
                                    <option value="superadmin">Super Admin</option>
                                    <option value="administrasi">Administrasi</option>
                                </select>
                                @error('peran')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
            
                            {{-- Email --}}
                            <div class="col-lg-6">
                                <label for="email" class="form-label">
                                    Email / Username <span class="text-danger">*</span>
                                </label>
                                <input type="text" wire:model.defer="email" id="email" class="form-control"
                                    placeholder="user@example.com / username">
                                @error('email')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
            
                            {{-- Password --}}
                            <div class="col-lg-6">
                                <label for="password" class="form-label">
                                    Password <span class="text-danger">*</span>
                                </label>
                                <input type="password" wire:model.defer="password" id="password" class="form-control"
                                    placeholder="Minimal 6 karakter">
                                @error('password')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
            
                            {{-- Akses Desa --}}
                            <div class="col-lg-12">
                                <label for="ms_desa_id" class="form-label">
                                    Akses Desa <span class="text-danger">*</span>
                                </label>
                                <div class="form-check">
                                    @foreach ($select_desa as $item)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="ms_desa_id_{{ $item->ms_desa_id }}"
                                            wire:model="ms_desa_id" value="{{ $item->ms_desa_id }}">
                                        <label class="form-check-label" for="ms_desa_id_{{ $item->ms_desa_id }}">
                                            {{ $item->nama_desa }}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                                @error('ms_desa_id')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
            
                        </div>
                    </div>
            
                    <div class="modal-footer">
                        <a href="javascript:void(0);" class="btn btn-link link-success shadow-none fw-medium"
                            data-bs-dismiss="modal">
                            <i class="ri-close-line me-1 align-middle"></i> Tutup
                        </a>
            
                        <button type="submit" class="btn btn-primary">
                            <i class="ri-save-3-line me-1"></i> Simpan
                        </button>
                    </div>
            
                </form>
            
            </div>
        </div>
    </div>
</div>