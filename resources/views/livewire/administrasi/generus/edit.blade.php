<div class="modal fade" id="ModalEditGenerus" tabindex="-1" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header bg-light p-3">
                <h5 class="modal-title fw-bold">
                    <i class="ri-edit-2-line text-warning me-1"></i> Edit Data Generus
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form wire:submit.prevent="update">
                <div class="modal-body">
                    <div class="row g-3">
                
                        {{-- Kelompok --}}
                        <div class="col-lg-2">
                            <label class="form-label">
                                Kelompok <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" wire:model.defer="ms_kelompok_id">
                                <option value="">-- Pilih Kelompok --</option>
                                @foreach($listKelompok as $k)
                                <option value="{{ $k->ms_kelompok_id }}">{{ $k->nama_kelompok }}</option>
                                @endforeach
                            </select>
                            @error('ms_kelompok_id')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                
                        {{-- Nama --}}
                        <div class="col-lg-6">
                            <label class="form-label">
                                Nama Generus <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" wire:model.defer="nama_generus" placeholder="Masukkan nama generus">
                            @error('nama_generus')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                
                        {{-- Nomor Telepon --}}
                        <div class="col-lg-4">
                            <label class="form-label">
                                Nomor Telepon
                            </label>
                            <input type="text" class="form-control" wire:model.defer="nomor_telepon" placeholder="Contoh: 08xxxxxxxxxx">
                            @error('nomor_telepon')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                
                        {{-- Tempat Lahir --}}
                        <div class="col-lg-4">
                            <label class="form-label">
                                Tempat Lahir
                            </label>
                            <input type="text" class="form-control" wire:model.defer="tempat_lahir" placeholder="Tempat lahir">
                            @error('tempat_lahir')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                
                        {{-- Tanggal Lahir --}}
                        <div class="col-lg-4">
                            <label class="form-label">
                                Tanggal Lahir
                            </label>
                            <input type="date" class="form-control" wire:model.defer="tanggal_lahir">
                            @error('tanggal_lahir')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                
                        {{-- Jenis Kelamin --}}
                        <div class="col-lg-4">
                            <label class="form-label">
                                Jenis Kelamin <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" wire:model.defer="jenis_kelamin">
                                <option value="">-- Pilih --</option>
                                <option value="laki-laki">Laki - Laki</option>
                                <option value="perempuan">Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                
                        {{-- Alamat --}}
                        <div class="col-lg-12">
                            <label class="form-label">
                                Alamat
                            </label>
                            <input type="text" class="form-control" wire:model.defer="alamat" placeholder="Alamat lengkap">
                            @error('alamat')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                
                        {{-- Deskripsi --}}
                        <div class="col-lg-12">
                            <label class="form-label">
                                Deskripsi
                            </label>
                            <textarea class="form-control" rows="3" wire:model.defer="deskripsi"
                                placeholder="Tambahkan catatan atau keterangan (opsional)"></textarea>
                            @error('deskripsi')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                
                    </div>
                </div>

                <div class="modal-footer">
                    <a href="javascript:void(0);" class="btn btn-link link-success shadow-none fw-medium"
                        data-bs-dismiss="modal">
                        <i class="ri-close-line me-1"></i> Tutup
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="ri-save-3-line me-1"></i> Perbarui
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>