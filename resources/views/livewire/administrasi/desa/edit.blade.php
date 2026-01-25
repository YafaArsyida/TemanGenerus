<div wire:ignore.self class="modal fade" id="ModalEditDesa" tabindex="-1" aria-labelledby="ModalEditDesaLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
    
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title fw-bold" id="ModalEditDesaLabel">
                    <i class="ri-edit-2-line me-1 text-warning"></i> Edit Data Desa
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
    
            <form wire:submit.prevent="update">
                <div class="modal-body">
                    <div class="row g-3">
    
                        {{-- Nama Desa --}}
                        <div class="col-lg-6">
                            <label class="form-label">
                                Nama Desa <span class="text-danger">*</span>
                            </label>
                            <input type="text" wire:model.defer="nama_desa" class="form-control"
                                placeholder="Masukkan nama desa">
                            @error('nama_desa')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
    
                        {{-- Nama Masjid --}}
                        <div class="col-lg-6">
                            <label class="form-label">
                                Nama Masjid <span class="text-danger">*</span>
                            </label>
                            <input type="text" wire:model.defer="nama_masjid" class="form-control"
                                placeholder="Masukkan nama masjid">
                            @error('nama_masjid')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
    
                        {{-- Alamat --}}
                        <div class="col-lg-12">
                            <label class="form-label">
                                Alamat
                            </label>
                            <input type="text" wire:model.defer="alamat" class="form-control"
                                placeholder="Alamat lengkap desa">
                            @error('alamat')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
    
                        {{-- Tautan Google Maps --}}
                        <div class="col-lg-12">
                            <label class="form-label">
                                Tautan Google Maps
                            </label>
                            <input type="text" wire:model.defer="peta" class="form-control"
                                placeholder="https://maps.google.com/...">
                            @error('peta')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
    
                        {{-- Deskripsi --}}
                        <div class="col-lg-12">
                            <label class="form-label">
                                Deskripsi
                            </label>
                            <textarea wire:model.defer="deskripsi" class="form-control" rows="3"
                                placeholder="Catatan tambahan (opsional)"></textarea>
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