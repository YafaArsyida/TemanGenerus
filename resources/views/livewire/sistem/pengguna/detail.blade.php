<div>
    <div wire:ignore.self class="modal fade" id="ModalDetailPengguna" tabindex="-1"
        aria-labelledby="ModalDetailPenggunaLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                {{-- HEADER --}}
                <div class="modal-header bg-light border-bottom px-4 py-3">
                    <div>
                        <h5 class="modal-title fw-bold mb-1">
                            <i class="ri-user-3-line text-primary me-1">
                            </i>
                            Detail Pengguna
                        </h5>
                        <small class="text-muted">
                            Informasi lengkap petugas administrasi & hak akses sistem
                        </small>
                    </div>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal">
                    </button>
                </div>
                {{-- BODY --}}
                <div class="modal-body bg-light-subtle">
                    <div class="row g-4">
                        {{-- ========================= --}} {{-- LEFT SIDEBAR --}} {{-- =========================
                        --}}
                        <div class="col-xl-4">
                            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                                {{-- PROFILE --}}
                                <div class="bg-primary bg-gradient p-4 text-center">
                                    <div class="avatar-lg mx-auto mb-3">
                                        <div
                                            class="avatar-title rounded-circle bg-white text-primary fs-2 fw-bold shadow">
                                            {{ strtoupper(substr($nama,0,1)) }}
                                        </div>
                                    </div>
                                    <h5 class="text-white mb-1 fw-bold">
                                        {{ $nama }}
                                    </h5>
                                    <div class="text-white-75 small">
                                        {{ $email }}
                                    </div>
                                </div>
                                {{-- INFO --}}
                                <div class="card-body">
                                    {{-- TELEPON --}}
                                    <div
                                        class="d-flex align-items-center justify-content-between border rounded-3 px-3 py-2 mb-3">
                                        <div>
                                            <small class="text-muted d-block">
                                                Telepon
                                            </small>
                                            <div class="fw-semibold">
                                                {{ $telepon ?: '-' }}
                                            </div>
                                        </div>
                                        <div class="text-success fs-4">
                                            <i class="ri-phone-line">
                                            </i>
                                        </div>
                                    </div>
                                    {{-- ROLE --}}
                                    <div
                                        class="d-flex align-items-center justify-content-between border rounded-3 px-3 py-2 mb-3">
                                        <div>
                                            <small class="text-muted d-block">
                                                Peran
                                            </small>
                                            <div>
                                                <span
                                                    class="badge bg-primary-subtle text-primary text-uppercase px-3 py-2">
                                                    {{ $peran }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="text-primary fs-4">
                                            <i class="ri-shield-user-line">
                                            </i>
                                        </div>
                                    </div>
                                    {{-- SCOPE --}}
                                    <div
                                        class="d-flex align-items-center justify-content-between border rounded-3 px-3 py-2 mb-3">
                                        <div>
                                            <small class="text-muted d-block">
                                                Scope Akses
                                            </small>
                                            <div>
                                                <span
                                                    class="badge bg-secondary-subtle text-secondary text-uppercase px-3 py-2">
                                                    {{ $scope_type }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="text-secondary fs-4">
                                            <i class="ri-focus-3-line">
                                            </i>
                                        </div>
                                    </div>
                                    {{-- CREATED --}}
                                    <div
                                        class="d-flex align-items-center justify-content-between border rounded-3 px-3 py-2">
                                        <div>
                                            <small class="text-muted d-block">
                                                Tanggal Dibuat
                                            </small>
                                            <div class="fw-semibold">
                                                {{ $created_at }}
                                            </div>
                                        </div>
                                        <div class="text-warning fs-4">
                                            <i class="ri-calendar-event-line">
                                            </i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- ========================= --}} {{-- RIGHT CONTENT --}} {{-- =========================
                        --}}
                        <div class="col-xl-8">
                            {{-- ACCESS CARD --}}
                            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                                <div class="card-header bg-white border-bottom px-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h6 class="fw-bold mb-1">
                                                Hak Akses Pengguna
                                            </h6>
                                            <small class="text-muted">
                                                Wilayah & akses operasional yang dimiliki pengguna
                                            </small>
                                        </div>
                                        <div>
                                            <span class="badge bg-info-subtle text-info text-uppercase px-3 py-2">
                                                {{ $scope_type }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    {{-- DAERAH --}} @if($scope_type == 'daerah')
                                    <div class="alert alert-success border-0 rounded-4 d-flex align-items-start mb-0">
                                        <div class="me-3 fs-3">
                                            <i class="ri-earth-line">
                                            </i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-1">
                                                Akses Penuh Daerah
                                            </h6>
                                            <p class="mb-0 text-muted">
                                                Pengguna memiliki akses penuh ke seluruh desa, kelompok, kegiatan, dan
                                                data administrasi.
                                            </p>
                                        </div>
                                    </div>
                                    @endif {{-- DESA / KELOMPOK --}} @if(in_array($scope_type, ['desa','kelompok']))
                                    <div class="row g-3">
                                        @forelse($aksesPengguna as $akses)
                                        <div class="col-lg-6">
                                            <div
                                                class="border rounded-4 px-3 py-3 bg-light h-100 d-flex align-items-center">
                                                <div class="avatar-sm me-3">
                                                    <div
                                                        class="avatar-title rounded-circle bg-primary-subtle text-primary">
                                                        <i class="ri-map-pin-2-line">
                                                        </i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="fw-semibold">
                                                        {{ $akses }}
                                                    </div>
                                                    <small class="text-muted">
                                                        Hak akses aktif
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                        @empty
                                        <div class="col-12">
                                            <div class="text-center py-5 border rounded-4 bg-light-subtle">
                                                <div class="mb-3 fs-1 text-muted">
                                                    <i class="ri-folder-warning-line">
                                                    </i>
                                                </div>
                                                <h6 class="fw-semibold">
                                                    Tidak Ada Data Akses
                                                </h6>
                                                <p class="text-muted mb-0">
                                                    Pengguna belum memiliki data akses wilayah.
                                                </p>
                                            </div>
                                        </div>
                                        @endforelse
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- FOOTER --}}
                <div class="modal-footer bg-white border-top">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">
                        <i class="ri-close-line me-1">
                        </i>
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>