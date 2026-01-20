{{-- Success is as dangerous as failure. --}}
<div>
    <div wire:ignore.self class="modal fade" id="ModalAddPengguna" tabindex="-1" aria-labelledby="ModalAddPengguna"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light p-3">
                    <h5 class="modal-title">Pengguna Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="close-modal"></button>
                </div>
                <form wire:submit.prevent="save">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-lg-6">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" wire:model.defer="nama" id="nama" class="form-control"
                                    placeholder="Nama lengkap petugas" />
                                @error('nama')
                                <footer class="text-danger mt-0">{{ $message }}</footer>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <label for="peran" class="form-label">Peran</label>
                                <select id="peran" wire:model="peran" class="form-select">
                                    <option value="">Pilih Peran</option>
                                    <option value="superadmin">Super Admin</option>
                                    <option value="administrasi">Administrasi</option>
                                </select>
                                @error('peran')
                                <footer class="text-danger mt-0">{{ $message }}</footer>
                                @enderror
                            </div>
                            <div class="col-lg-12">
                                <label for="ms_desa_id" class="form-label">Akses Desa</label>
                                <div class="form-check">
                                    @foreach ($select_desa as $item)
                                    <input class="form-check-input" type="checkbox"
                                        id="ms_desa_id_{{ $item->ms_desa_id }}" wire:model="ms_desa_id"
                                        value="{{ $item->ms_desa_id }}">
                                    <label class="form-check-label" for="ms_desa_id_{{ $item->ms_desa_id }}">
                                        {{ $item->nama_desa }}
                                    </label>
                                    <br>
                                    @endforeach
                                </div>
                                @error('ms_desa_id')
                                <footer class="text-danger mt-0">{{ $message }}</footer>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <label for="email" class="form-label">Email/Username</label>
                                <input type="text" wire:model.defer="email" id="email" class="form-control"
                                    placeholder="user@example.com/jajangsukma" />
                                @error('email')
                                <footer class="text-danger mt-0">{{ $message }}</footer>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" wire:model.defer="password" id="password" class="form-control"
                                    placeholder="Minimal 6 karakter" />
                                @error('password')
                                <footer class="text-danger mt-0">{{ $message }}</footer>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="javascript:void(0);" class="btn btn-link link-success shadow-none fw-medium"
                            data-bs-dismiss="modal">
                            <i class="ri-close-line me-1 align-middle"></i> Tutup
                        </a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>