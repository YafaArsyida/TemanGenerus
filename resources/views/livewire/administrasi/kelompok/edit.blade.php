<div class="modal fade" id="ModalEditKelompok" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header bg-light p-3">
                <h5 class="modal-title fw-bold" id="ModalEditDesaLabel">
                    <i class="ri-edit-2-line me-1 text-warning"></i> Edit Data Kelompok
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form wire:submit.prevent="update">
                <div class="modal-body">

                    <div class="row g-3">

                        {{-- Desa --}}
                        <div class="col-lg-6">
                            <label class="form-label">Desa <span class="text-danger">*</span></label>
                            <select class="form-select" wire:model.defer="ms_desa_id">
                                <option value="">-- Pilih Desa --</option>
                                @foreach($listDesa as $desa)
                                <option value="{{ $desa->ms_desa_id }}">{{ $desa->nama_desa }}</option>
                                @endforeach
                            </select>
                            @error('ms_desa_id') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        {{-- Nama Kelompok --}}
                        <div class="col-lg-6">
                            <label class="form-label">Nama Kelompok <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" wire:model.defer="nama_kelompok">
                            @error('nama_kelompok') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        {{-- Nama Masjid --}}
                        <div class="col-lg-6">
                            <label class="form-label">Nama Masjid</label>
                            <input type="text" class="form-control" wire:model.defer="nama_masjid">
                            @error('nama_masjid') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        {{-- Alamat --}}
                        <div class="col-lg-6">
                            <label class="form-label">Alamat <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" wire:model.defer="alamat">
                            @error('alamat') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        {{-- Peta --}}
                        <div class="col-lg-12">
                            <label class="form-label">Tautan Google Maps</label>
                            <input type="text" class="form-control" wire:model.defer="peta">
                            @error('peta') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        {{-- Deskripsi --}}
                        <div class="col-lg-12">
                            <label class="form-label">Deskripsi</label>
                            <textarea class="form-control" rows="3" wire:model.defer="deskripsi"></textarea>
                            @error('deskripsi') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <a href="javascript:void(0);" class="btn btn-link link-success shadow-none fw-medium" data-bs-dismiss="modal">
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