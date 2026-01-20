<div wire:ignore.self class="modal fade" id="ModalDesaCreate" tabindex="-1" aria-labelledby="ModalDesaCreateLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-light p-3">
                <h5 class="modal-title fw-bold">
                    <i class="ri-add-circle-line me-1 text-success"></i> Tambah Data Desa
                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form wire:submit.prevent="save">
                <div class="modal-body">

                    <div class="row g-3">

                        <!-- Nama Desa -->
                        <div class="col-lg-6">
                            <label class="form-label">Nama Desa</label>
                            <input type="text" wire:model.defer="nama_desa" class="form-control"
                                placeholder="Masukkan nama desa...">
                            @error('nama_desa')
                            <footer class="text-danger mt-0">{{ $message }}</footer>
                            @enderror
                        </div>

                        <!-- Nama Masjid -->
                        <div class="col-lg-6">
                            <label class="form-label">Nama Masjid</label>
                            <input type="text" wire:model.defer="nama_masjid" class="form-control"
                                placeholder="Masukkan nama masjid...">
                            @error('nama_masjid')
                            <footer class="text-danger mt-0">{{ $message }}</footer>
                            @enderror
                        </div>

                        <!-- Alamat -->
                        <div class="col-lg-12">
                            <label class="form-label">Alamat</label>
                            <input type="text" wire:model.defer="alamat" class="form-control"
                                placeholder="Alamat lengkap...">
                            @error('alamat')
                            <footer class="text-danger mt-0">{{ $message }}</footer>
                            @enderror
                        </div>
                        
                        <!-- Tautan Google Maps -->
                        <div class="col-lg-12">
                            <label class="form-label">Tautan Google Maps</label>
                            <input type="text" wire:model.defer="peta" class="form-control" placeholder="https://maps.google.com/....">
                            @error('peta')
                            <footer class="text-danger mt-0">{{ $message }}</footer>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="col-lg-12">
                            <label class="form-label">Deskripsi</label>
                            <textarea wire:model.defer="deskripsi" class="form-control" rows="2"
                                placeholder="Keterangan tambahan (opsional)..."></textarea>
                            @error('deskripsi')
                            <footer class="text-danger mt-0">{{ $message }}</footer>
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
                        <i class="ri-save-3-line me-1"></i> Simpan
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>