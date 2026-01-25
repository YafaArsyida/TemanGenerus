<div class="modal fade" id="ModalEditKegiatan" tabindex="-1" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header bg-light p-3">
                <h5 class="modal-title fw-bold">
                    <i class="ri-edit-2-line text-warning me-1"></i> Edit Kegiatan Generus
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form wire:submit.prevent="update">
                <div class="modal-body">
                    <div class="row g-3">

                        {{-- Scope --}}
                        <div class="col-lg-4">
                            <label class="form-label">Tingkat <span class="text-danger">*</span></label>
                            <select class="form-select" wire:model="scope">
                                <option value="">-- Pilih --</option>
                                <option value="daerah">Daerah</option>
                                <option value="desa">Desa</option>
                                <option value="kelompok">Kelompok</option>
                            </select>
                            @error('scope') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        {{-- Kelompok --}}
                        @if($scope === 'kelompok')
                        <div class="col-lg-8">
                            <label class="form-label">Kelompok <span class="text-danger">*</span></label>
                            <select class="form-select" wire:model="ms_kelompok_id">
                                <option value="">-- Pilih Kelompok --</option>
                                @foreach($listKelompok as $k)
                                <option value="{{ $k->ms_kelompok_id }}">
                                    {{ $k->nama_kelompok }}
                                    @if($k->ms_desa) - {{ $k->ms_desa->nama_desa }} @endif
                                </option>
                                @endforeach
                            </select>
                            @error('ms_kelompok_id') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        @endif

                        {{-- Nama Kegiatan --}}
                        <div class="col-lg-9">
                            <label class="form-label">Nama Kegiatan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" wire:model.defer="nama_kegiatan"
                                placeholder="Masukkan nama kegiatan">
                            @error('nama_kegiatan') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        {{-- Jenjang --}}
                        <div class="col-lg-3">
                            <label class="form-label">Jenjang</label>
                            <select class="form-select" wire:model.defer="jenjang">
                                <option value="">Semua Jenjang</option>
                                <option value="caberawit">Caberawit</option>
                                <option value="remaja">Remaja</option>
                                <option value="mandiri">Mandiri</option>
                                <option value="gp">GP</option>
                            </select>
                            @error('jenjang') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        {{-- Tanggal --}}
                        <div class="col-lg-4">
                            <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" wire:model.defer="tanggal">
                            @error('tanggal') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        {{-- Waktu --}}
                        <div class="col-lg-2">
                            <label class="form-label">Waktu <span class="text-danger">*</span></label>
                            <input type="time" step="1" class="form-control" wire:model.defer="waktu">
                            @error('waktu') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        @if($scope && $lokasi_default)
                        <div class="col-lg-12">
                            <div class="border rounded-3 p-3 bg-light">
                                <div class="d-flex align-items-start gap-2">
                                    <i class="ri-map-pin-2-line fs-18 text-success"></i>
                                    <div>
                                        <h6 class="fw-semibold mb-1">Lokasi Kegiatan</h6>
                                        <div class="text-muted fs-13">
                                            <strong>{{ $lokasi_default['tempat'] ?? '-' }}</strong><br>
                                            {{ $lokasi_default['alamat'] ?? '-' }}
                                        </div>

                                        @if(!empty($lokasi_default['peta']))
                                        <div class="mt-1">
                                            <a href="{{ $lokasi_default['peta'] }}" target="_blank"
                                                class="text-primary fs-13">
                                                <i class="ri-map-pin-line"></i> Lihat Peta
                                            </a>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="col-lg-12">
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" wire:model="use_custom_lokasi"
                                    id="useCustomLokasi">

                                <label class="form-check-label fw-medium" for="useCustomLokasi">
                                    Lokasi kegiatan berbeda dengan alamat di atas?
                                </label>

                                <div class="text-muted fs-12">
                                    Centang jika kegiatan tidak dilaksanakan di lokasi masjid / desa / kelompok.
                                </div>
                            </div>
                        </div>
                        @if($use_custom_lokasi)
                        <div class="col-lg-12">
                            <div class="border border-2 border-dashed rounded-3 p-3 bg-light">
                                <div class="d-flex align-items-start gap-2">
                                    <i class="ri-edit-map-line fs-18 text-warning"></i>
                                    <div>
                                        <h6 class="mb-1 fw-semibold">
                                            Lokasi Alternatif Kegiatan
                                        </h6>
                                        <p class="mb-0 text-muted fs-12">
                                            Isi lokasi di bawah ini jika kegiatan dilaksanakan
                                            <strong>di luar lokasi default</strong>.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Tempat / Alamat / Peta --}}
                        <div class="col-lg-6">
                            <label class="form-label">Tempat (opsional)</label>
                            <input type="text" class="form-control" wire:model.defer="tempat" placeholder="Nama tempat">
                            @error('tempat') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-lg-6">
                            <label class="form-label">Peta / URL (opsional)</label>
                            <input type="url" class="form-control" wire:model.defer="peta"
                                placeholder="https://maps.google.com/...">
                            @error('peta') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-lg-12">
                            <label class="form-label">Alamat (opsional)</label>
                            <input type="text" class="form-control" wire:model.defer="alamat"
                                placeholder="Alamat lengkap">
                            @error('alamat') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        @endif

                        {{-- Deskripsi --}}
                        <div class="col-12">
                            <label class="form-label">Deskripsi</label>
                            <textarea class="form-control" rows="3" wire:model.defer="deskripsi"></textarea>
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