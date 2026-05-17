<div class="modal fade" id="ModalKegiatanCreate" tabindex="-1" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            {{-- HEADER --}}
            <div class="modal-header border-0 bg-light-subtle px-4 py-3">
                <div>
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <div class="avatar-xs">
                            <div class="avatar-title bg-success-subtle text-success rounded-circle">
                                <i class="ri-calendar-event-line"></i>
                            </div>
                        </div>
                        <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                            Administrasi Kegiatan
                        </span>
                    </div>
                    <h4 class="modal-title fw-bold mb-0">
                        Tambah Kegiatan Generus
                    </h4>
                    <p class="text-muted mb-0 fs-13 mt-1">
                        Tambahkan agenda kegiatan generasi penerus dengan pengaturan tingkat, jadwal, dan lokasi.
                    </p>
                </div>
                <button type="button" class="btn btn-light btn-icon rounded-circle shadow-sm" data-bs-dismiss="modal">
                    <i class="ri-close-line fs-18"></i>
                </button>
            </div>
            <form wire:submit.prevent="save">
                <div class="modal-body p-4">
                    <div class="row g-4">
                        {{-- ================= INFORMASI KEGIATAN ================= --}}
                        <div class="col-12">
                            <div class="border rounded-4 p-4 bg-light-subtle">
                                <div class="d-flex align-items-center gap-2 mb-4">
                                    <div class="avatar-sm">
                                        <div class="avatar-title bg-primary-subtle text-primary rounded-circle">
                                            <i class="ri-information-line">
                                            </i>
                                        </div>
                                    </div>
                                    <div>
                                        <h5 class="fw-semibold mb-0">
                                            Informasi Kegiatan
                                        </h5>
                                        <p class="text-muted fs-13 mb-0">
                                            Atur cakupan dan identitas kegiatan generus.
                                        </p>
                                    </div>
                                </div>
                                <div class="row g-3">
                                    {{-- Scope --}}
                                    <div class="col-lg-3">
                                        <label class="form-label fw-semibold">Tingkat Kegiatan
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select rounded-3" wire:model="scope">
                                            <option value="">Pilih Tingkat</option>
                                            <option value="daerah">Daerah</option>
                                            <option value="desa">Desa</option>
                                            <option value="kelompok">Kelompok</option>
                                        </select>
                                        @error('scope')
                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>
                                        @enderror
                                    </div>
                                    {{-- Kelompok --}} @if($scope === 'kelompok')
                                    <div class="col-lg-5">
                                        <label class="form-label fw-semibold">
                                            Penempatan Kelompok
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select rounded-3" wire:model="ms_kelompok_id">
                                            <option value="">Pilih Kelompok</option>
                                            @foreach($listKelompok as $k)
                                            <option value="{{ $k->ms_kelompok_id }}">
                                                {{ $k->nama_kelompok }} @if($k->ms_desa) - {{ $k->ms_desa->nama_desa }}
                                                @endif
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('ms_kelompok_id')
                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>
                                        @enderror
                                    </div>
                                    @endif {{-- Jenjang --}}
                                    <div class="col-lg-4">
                                        <label class="form-label fw-semibold">
                                            Jenjang Peserta
                                        </label>
                                        <select class="form-select rounded-3" wire:model.defer="jenjang">
                                            <option value="semua">Semua Jenjang</option>
                                            <option value="caberawit">Caberawit</option>
                                            <option value="remaja">Remaja</option>
                                            <option value="gp">GP</option>
                                            {{-- <option value="pra_nikah">Pra Nikah</option> --}}
                                            <option value="mandiri">Mandiri</option>
                                        </select>
                                        @error('jenjang')
                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>
                                        @enderror
                                    </div>
                                    {{-- Nama Kegiatan --}}
                                    <div class="col-lg-12">
                                        <label class="form-label fw-semibold">
                                            Nama Kegiatan
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control rounded-3" wire:model.defer="nama_kegiatan" placeholder="Masukkan nama kegiatan">
                                        @error('nama_kegiatan')
                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- ================= TIPE KEGIATAN ================= --}}
                        <div class="col-12">
                            <div class="border rounded-4 p-4">
                                <div class="d-flex align-items-center gap-2 mb-4">
                                    <div class="avatar-sm">
                                        <div class="avatar-title bg-success-subtle text-success rounded-circle">
                                            <i class="ri-repeat-line"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h5 class="fw-semibold mb-0">
                                            Jadwal Kegiatan
                                        </h5>
                                        <p class="text-muted fs-13 mb-0">
                                            Tentukan apakah kegiatan berlangsung sekali atau rutin.
                                        </p>
                                    </div>
                                </div>
                                <div class="row g-3">
                                    {{-- Tipe Kegiatan --}}
                                    <div class="col-lg-12">
                                        <label class="form-label fw-semibold">
                                            Tipe Kegiatan
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="row g-3">
                                            <div class="col-lg-6">
                                                <label
                                                    class="border rounded-4 p-4 w-100 cursor-pointer bg-light-subtle">
                                                    <div class="d-flex align-items-start gap-3">
                                                        <input type="radio" wire:model="tipe_kegiatan" value="sekali" class="form-check-input mt-1">
                                                        <div>
                                                            <h6 class="fw-semibold mb-1">
                                                                Kegiatan Sekali
                                                            </h6>
                                                            <p class="text-muted fs-13 mb-0">Digunakan untuk event atau kegiatan pada tanggal tertentu.</p>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="col-lg-6">
                                                <label
                                                    class="border rounded-4 p-4 w-100 cursor-pointer bg-light-subtle">
                                                    <div class="d-flex align-items-start gap-3">
                                                        <input type="radio" wire:model="tipe_kegiatan" value="rutin" class="form-check-input mt-1">
                                                        <div>
                                                            <h6 class="fw-semibold mb-1">
                                                                Kegiatan Rutin
                                                            </h6>
                                                            <p class="text-muted fs-13 mb-0">Digunakan untuk kegiatan mingguan yang berulang.</p>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                        @error('tipe_kegiatan')
                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>
                                        @enderror
                                    </div>
                                    {{-- Waktu --}}
                                    <div class="col-lg-3">
                                        <label class="form-label fw-semibold">
                                            Waktu Kegiatan
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="time" step="1" class="form-control rounded-3" wire:model.defer="waktu">
                                        @error('waktu')
                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>
                                        @enderror
                                    </div>
                                    {{-- Tanggal --}} @if($tipe_kegiatan === 'sekali')
                                    <div class="col-lg-4">
                                        <label class="form-label fw-semibold">
                                            Tanggal Kegiatan
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" class="form-control rounded-3" wire:model.defer="tanggal">
                                        @error('tanggal')
                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>
                                        @enderror
                                    </div>
                                    @endif {{-- Hari Rutin --}} @if($tipe_kegiatan === 'rutin')
                                    <div class="col-lg-9">
                                        <label class="form-label fw-semibold">
                                            Hari Rutin
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="row g-3">
                                            @foreach($listHari as $key => $label)
                                            <div class="col-6 col-md-3">
                                                <label class="border rounded-3 p-3 w-100 cursor-pointer bg-light-subtle">
                                                    <div class="form-check mb-0">
                                                        <input class="form-check-input" type="checkbox" wire:model="hari_rutin" value="{{ $key }}" id="hari_{{ $key }}">
                                                        <label class="form-check-label fw-medium" for="hari_{{ $key }}">
                                                            {{ $label }}
                                                        </label>
                                                    </div>
                                                </label>
                                            </div>
                                            @endforeach
                                        </div>
                                        @error('hari_rutin')
                                        <small class="text-danger">
                                            {{ $message }}
                                        </small>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <div class="alert alert-info border-0 rounded-4 mb-0">
                                            <div class="d-flex gap-3">
                                                <i class="ri-information-line fs-20"></i>
                                                <div>
                                                    <h6 class="fw-semibold mb-1">
                                                        Informasi Kegiatan Rutin
                                                    </h6>
                                                    <p class="mb-0 fs-13">
                                                        Lokasi kegiatan dapat disesuaikan kembali saat presensi apabila terjadi perpindahan tempat.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        {{-- ================= LOKASI ================= --}}
                        <div class="col-12">
                            <div class="border rounded-4 p-4 bg-light-subtle">
                                <div class="d-flex align-items-center gap-2 mb-4">
                                    <div class="avatar-sm">
                                        <div class="avatar-title bg-warning-subtle text-warning rounded-circle">
                                            <i class="ri-map-pin-2-line"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h5 class="fw-semibold mb-0">
                                            Lokasi Kegiatan
                                        </h5>
                                        <p class="text-muted fs-13 mb-0">
                                            Gunakan lokasi default atau tambahkan lokasi alternatif.
                                        </p>
                                    </div>
                                </div>
                                @if($scope && $lokasi_default)
                                <div class="border rounded-4 p-4 bg-white mb-4">
                                    <div class="d-flex align-items-start gap-3">
                                        <div class="avatar-sm flex-shrink-0">
                                            <div class="avatar-title bg-success-subtle text-success rounded-circle">
                                                <i class="ri-building-line"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h6 class="fw-semibold mb-1">
                                                Lokasi Default
                                            </h6>
                                            <p class="mb-1 text-dark fw-medium">
                                                {{ $lokasi_default['tempat'] ?? '-' }}
                                            </p>
                                            <p class="text-muted fs-13 mb-2">
                                                {{ $lokasi_default['alamat'] ?? '-' }}
                                            </p>
                                            @if(!empty($lokasi_default['peta']))
                                            <a href="{{ $lokasi_default['peta'] }}" target="_blank" class="btn btn-sm btn-soft-primary rounded-pill">
                                                <i class="ri-map-pin-line me-1"></i>
                                                Lihat Peta
                                            </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endif {{-- Toggle --}}
                                <div class="form-check form-switch form-switch-md mb-4">
                                    <input class="form-check-input" type="checkbox" wire:model="use_custom_lokasi" id="useCustomLokasi">
                                    <label class="form-check-label fw-semibold" for="useCustomLokasi">
                                        Gunakan lokasi alternatif
                                    </label>
                                    <div class="text-muted fs-13">
                                        Aktifkan jika kegiatan tidak dilakukan di lokasi default.
                                    </div>
                                </div>
                                {{-- Custom Lokasi --}} @if($use_custom_lokasi)
                                <div class="border border-2 border-dashed rounded-4 p-4 bg-white">
                                    <div class="row g-3">
                                        <div class="col-lg-6">
                                            <label class="form-label fw-semibold">
                                                Nama Tempat
                                            </label>
                                            <input type="text" class="form-control rounded-3" wire:model.defer="tempat" placeholder="Contoh: Aula Desa">
                                            @error('tempat')
                                            <small class="text-danger">
                                                {{ $message }}
                                            </small>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label fw-semibold">
                                                Link Peta / Google Maps
                                            </label>
                                            <input type="url" class="form-control rounded-3" wire:model.defer="peta" placeholder="https://maps.google.com/...">
                                            @error('peta')
                                            <small class="text-danger">
                                                {{ $message }}
                                            </small>
                                            @enderror
                                        </div>
                                        <div class="col-lg-12">
                                            <label class="form-label fw-semibold">
                                                Alamat Lengkap
                                            </label>
                                            <input type="text" class="form-control rounded-3" wire:model.defer="alamat" placeholder="Masukkan alamat lokasi kegiatan">
                                            @error('alamat')
                                            <small class="text-danger">
                                                {{ $message }}
                                            </small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        {{-- ================= DESKRIPSI ================= --}}
                        <div class="col-12">
                            <div class="border rounded-4 p-4">
                                <label class="form-label fw-semibold">
                                    Deskripsi Kegiatan
                                </label>
                                <textarea class="form-control rounded-3" rows="4" wire:model.defer="deskripsi" placeholder="Tambahkan catatan atau deskripsi kegiatan...">
								</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- FOOTER --}}
                <div class="modal-footer border-0 px-4 pb-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">
                        <i class="ri-close-line me-1"></i>
                        Tutup
                    </button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="ri-save-3-line me-1"></i>
                        Simpan Kegiatan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>