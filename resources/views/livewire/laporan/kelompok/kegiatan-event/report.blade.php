<div wire:ignore.self class="offcanvas offcanvas-top" id="offcanvasLaporan" aria-labelledby="offcanvasLaporanLabel"
    style="min-height:100vh;">

    <div class="offcanvas-header border-bottom">
        <div>
            <h5 class="offcanvas-title fw-bold" id="offcanvasLaporanLabel">
                <i class="ri-file-chart-line me-1 text-success"></i>
                Laporan Kehadiran Generus Kelompok {{ $nama_kelompok }} Desa {{ $nama_desa }}
            </h5>
        </div>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">
        @if($kegiatan)

        {{-- HEADER / SUMMARY --}}
        <div class="card border shadow-sm mb-3">
            <div class="card-body">
                {{-- TITLE --}}
                <h4 class="fw-bold mb-1 text-truncate">
                    @if($kegiatan->tipe_kegiatan === 'rutin')
                    <i class="ri-repeat-line"></i> Rutin
                    @else
                    <i class="ri-calendar-event-line"></i>
                    @endif
                    {{ $kegiatan->nama_kegiatan }}
                </h4>

                {{-- DESKRIPSI --}}
                @if($kegiatan->deskripsi)
                <p class="mb-2 text-muted">{{ $kegiatan->deskripsi }}</p>
                @endif

                {{-- INFO BAR --}}
                <div class="hstack gap-3 text-muted fs-13 flex-wrap">
                    <div>
                        <i class="ri-group-line text-success me-1"></i>
                        <span class="text-body fw-medium">
                            Peserta {{ ucfirst($kegiatan->jenjang ?? 'Semua Jenjang') }}
                        </span>
                    </div>

                    <div class="vr d-none d-md-block"></div>

                    <div>
                        <i class="ri-focus-3-line text-primary me-1"></i>
                        <span class="text-body fw-medium">
                            Kegiatan {{ ucfirst($kegiatan->scope) }}
                        </span>
                    </div>

                    <div class="vr d-none d-md-block"></div>

                    <div>
                        <i class="ri-time-line text-warning me-1"></i>
                        Tanggal
                        <span class="text-body fw-medium">
                            {{ $kegiatan->tanggal
                            ? \App\Http\Controllers\HelperController::formatTanggalIndonesia($kegiatan->tanggal, 'd F
                            Y')
                            : '-'
                            }}
                        </span>
                    </div>

                    <div class="vr d-none d-md-block"></div>

                    <div>
                        <i class="ri-time-line text-primary me-1"></i>
                        Waktu
                        <span class="text-body fw-medium">
                            {{ $kegiatan->waktu ?? '-' }}
                        </span>
                    </div>
                </div>

                <hr>

                @if($this->isScopeDaerah)
                {{-- GLOBAL GRID --}}
                <div class="row g-3">

                    <!-- Target -->
                    <div class="col-lg-3 col-sm-6">
                        <div class="p-2 border border-dashed rounded">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-2">
                                    <div class="avatar-title rounded bg-transparent text-primary fs-24">
                                        <i class="ri-group-fill"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-1">Target Peserta</p>
                                    <h5 class="mb-0">
                                        {{ $this->totalTarget }}
                                        <small class="text-muted">Generus</small>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hadir -->
                    <div class="col-lg-3 col-sm-6">
                        <div class="p-2 border border-dashed rounded">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-2">
                                    <div class="avatar-title rounded bg-transparent text-success fs-24">
                                        <i class="ri-user-follow-fill"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-1">Hadir</p>
                                    <h5 class="mb-0">
                                        {{ $kegiatan->totalHadir() }}
                                        <small class="text-success">
                                            ({{ $kegiatan->presentaseHadir() }}%)
                                        </small>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Izin -->
                    <div class="col-lg-3 col-sm-6">
                        <div class="p-2 border border-dashed rounded">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-2">
                                    <div class="avatar-title rounded bg-transparent text-warning fs-24">
                                        <i class="ri-user-star-fill"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-1">Izin</p>
                                    <h5 class="mb-0">
                                        {{ $kegiatan->totalIzin() }}
                                        <small class="text-warning">
                                            ({{ $kegiatan->presentaseIzin() }}%)
                                        </small>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Alfa -->
                    <div class="col-lg-3 col-sm-6">
                        <div class="p-2 border border-dashed rounded">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-2">
                                    <div class="avatar-title rounded bg-transparent text-danger fs-24">
                                        <i class="ri-user-unfollow-fill"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-1">Alfa</p>
                                    <h5 class="mb-0 text-danger">
                                        {{ $kegiatan->totalAlfa() }}
                                        <small class="text-danger">
                                            ({{ $kegiatan->presentaseAlfa() }}%)
                                        </small>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <hr>
                @endif

                @if($this->isScopeDesa || $this->isScopeDaerah)
                <div class="row g-3">

                    <!-- Target Desa -->
                    <div class="col-lg-3 col-sm-6">
                        <div class="p-2 border border-dashed rounded">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-2">
                                    <div class="avatar-title rounded bg-transparent text-primary fs-24">
                                        <i class="ri-community-fill"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-1">
                                        Target Desa ({{ $nama_desa }})
                                    </p>
                                    <h5 class="mb-0">
                                        {{ $this->targetDesa }}
                                        <small class="text-muted">Generus</small>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hadir Desa -->
                    <div class="col-lg-3 col-sm-6">
                        <div class="p-2 border border-dashed rounded">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-2">
                                    <div class="avatar-title rounded bg-transparent text-success fs-24">
                                        <i class="ri-user-follow-fill"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-1">Hadir</p>
                                    <h5 class="mb-0">
                                        {{ $this->hadirDesa }}
                                        <small class="text-success fw-semibold">
                                            ({{ $this->presentaseHadirDesa }}%)
                                        </small>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Izin Desa -->
                    <div class="col-lg-3 col-sm-6">
                        <div class="p-2 border border-dashed rounded">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-2">
                                    <div class="avatar-title rounded bg-transparent text-warning fs-24">
                                        <i class="ri-user-star-fill"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-1">Izin</p>
                                    <h5 class="mb-0">
                                        {{ $this->izinDesa }}
                                        <small class="text-warning fw-semibold">
                                            ({{ $this->presentaseIzinDesa }}%)
                                        </small>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Alfa Desa -->
                    <div class="col-lg-3 col-sm-6">
                        <div class="p-2 border border-dashed rounded">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-2">
                                    <div class="avatar-title rounded bg-transparent text-danger fs-24">
                                        <i class="ri-user-unfollow-fill"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-1">Alfa</p>
                                    <h5 class="mb-0 text-danger">
                                        {{ $this->alfaDesa }}
                                        <small class="text-danger fw-semibold">
                                            ({{ $this->presentaseAlfaDesa }}%)
                                        </small>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <hr>
                @endif

                @if($this->isScopeKelompok || $this->isScopeDesa || $this->isScopeDaerah)
                <div class="row g-3">
                
                    <!-- Target Kelompok -->
                    <div class="col-lg-3 col-sm-6">
                        <div class="p-2 border border-dashed rounded">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-2">
                                    <div class="avatar-title rounded bg-transparent text-primary fs-24">
                                        <i class="ri-team-fill"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-1">
                                        Target Kelompok ({{ $nama_kelompok }})
                                    </p>
                                    <h5 class="mb-0">
                                        {{ $this->targetKelompok }}
                                        <small class="text-muted">Generus</small>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <!-- Hadir -->
                    <div class="col-lg-3 col-sm-6">
                        <div class="p-2 border border-dashed rounded">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-2">
                                    <div class="avatar-title rounded bg-transparent text-success fs-24">
                                        <i class="ri-user-follow-fill"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-1">Hadir</p>
                                    <h5 class="mb-0">
                                        {{ $this->hadirKelompok }}
                                        <small class="text-success fw-semibold">
                                            ({{ $this->presentaseHadirKelompok }}%)
                                        </small>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <!-- Izin -->
                    <div class="col-lg-3 col-sm-6">
                        <div class="p-2 border border-dashed rounded">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-2">
                                    <div class="avatar-title rounded bg-transparent text-warning fs-24">
                                        <i class="ri-user-star-fill"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-1">Izin</p>
                                    <h5 class="mb-0">
                                        {{ $this->izinKelompok }}
                                        <small class="text-warning fw-semibold">
                                            ({{ $this->presentaseIzinKelompok }}%)
                                        </small>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <!-- Alfa -->
                    <div class="col-lg-3 col-sm-6">
                        <div class="p-2 border border-dashed rounded">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-2">
                                    <div class="avatar-title rounded bg-transparent text-danger fs-24">
                                        <i class="ri-user-unfollow-fill"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-1">Alfa</p>
                                    <h5 class="mb-0 text-danger">
                                        {{ $this->alfaKelompok }}
                                        <small class="text-danger fw-semibold">
                                            ({{ $this->presentaseAlfaKelompok }}%)
                                        </small>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                
                </div>
                @endif
                <div class="mt-3">
                    <div class="card border-0 shadow-sm border-start border-4 border-primary">
                        <div class="card-body">

                            <div class="d-flex align-items-start">
                                <div class="me-3">
                                    <div class="avatar-sm">
                                        <div class="avatar-title rounded bg-soft-info text-white fs-20">
                                            <i class="ri-lightbulb-flash-line"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-semibold">
                                        Insight Kelompok — {{ $nama_kelompok }}
                                    </h6>

                                    <p class="text-muted mb-0">
                                        {{ $this->insightKelompok }}
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- CONTENT GRID 7 : 5 --}}
        <div class="row g-3">
            {{-- KIRI: PRESENSI (7) --}}
            <div class="col-xxl-7 col-lg-7">
                @livewire('laporan.kelompok.kegiatan-event.report.attendance', [
                'kegiatanId' => $kegiatanId
                ])
            </div>

            {{-- KANAN: ALFA / TANPA KETERANGAN (5) --}}
            <div class="col-xxl-5 col-lg-5">
                @livewire('laporan.kelompok.kegiatan-event.report.alfa', [
                'kegiatanId' => $kegiatanId
                ])

            </div>

        </div>
        @endif
    </div>
</div>