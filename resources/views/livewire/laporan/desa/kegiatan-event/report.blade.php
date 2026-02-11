<div wire:ignore.self class="offcanvas offcanvas-top" id="offcanvasLaporan" aria-labelledby="offcanvasLaporanLabel"
    style="min-height:100vh;">

    <div class="offcanvas-header border-bottom">
        <div>
            <h5 class="offcanvas-title fw-bold" id="offcanvasLaporanLabel">
                <i class="ri-file-chart-line me-1 text-success"></i>
                Laporan Kehadiran Generus Desa {{ $nama_desa }}
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
                        <div class="col-lg-3 col-sm-6">
                            <div class="p-2 border border-dashed rounded">
                                <p class="text-muted mb-1">Total Target Peserta (Event)</p>
                                <h6 class="mb-0">
                                    {{ $this->totalTarget }} Generus
                                </h6>
                            </div>
                        </div>
                    
                        <div class="col-lg-3 col-sm-6">
                            <div class="p-2 border border-dashed rounded">
                                <p class="text-muted mb-1">Hadir (Global)</p>
                                <h6 class="mb-0">
                                    {{ $kegiatan->totalHadir() }} Generus
                                    <small class="text-muted">({{ $kegiatan->presentaseHadir() }}%)</small>
                                </h6>
                            </div>
                        </div>
                    
                        <div class="col-lg-3 col-sm-6">
                            <div class="p-2 border border-dashed rounded">
                                <p class="text-muted mb-1">Izin (Global)</p>
                                <h6 class="mb-0">
                                    {{ $kegiatan->totalIzin() }} Generus
                                    <small class="text-muted">({{ $kegiatan->presentaseIzin() }}%)</small>
                                </h6>
                            </div>
                        </div>
                    
                        <div class="col-lg-3 col-sm-6">
                            <div class="p-2 border border-dashed rounded">
                                <p class="text-muted mb-1">Alfa (Global)</p>
                                <h6 class="mb-0 text-danger">
                                    {{ $kegiatan->totalAlfa() }} Generus
                                    <small>({{ $kegiatan->presentaseAlfa() }}%)</small>
                                </h6>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                @endif
                
                @if($this->isScopeDaerah || $this->isScopeDesa)
                    <div class="row g-3">
                    
                        <div class="col-lg-3 col-sm-6">
                            <div class="p-2 border border-dashed rounded bg-soft-primary">
                                <p class="text-muted mb-1">Target Peserta ({{ $nama_desa }})</p>
                                <h6 class="mb-0">{{ $this->targetDesa }} Generus</h6>
                            </div>
                        </div>
                    
                        <div class="col-lg-3 col-sm-6">
                            <div class="p-2 border border-dashed rounded bg-soft-success">
                                <p class="text-muted mb-1">Hadir</p>
                                <h6 class="mb-0">
                                    {{ $this->hadirDesa }} Generus
                                    <small class="text-success fw-semibold">
                                        ({{ $this->presentaseHadirDesa }}%)
                                    </small>
                                </h6>
                            </div>
                        </div>
                    
                        <div class="col-lg-3 col-sm-6">
                            <div class="p-2 border border-dashed rounded bg-soft-warning">
                                <p class="text-muted mb-1">Izin</p>
                                <h6 class="mb-0">
                                    {{ $this->izinDesa }} Generus
                                    <small class="text-warning fw-semibold">
                                        ({{ $this->presentaseIzinDesa }}%)
                                    </small>
                                </h6>
                            </div>
                        </div>
                    
                        <div class="col-lg-3 col-sm-6">
                            <div class="p-2 border border-dashed rounded bg-soft-danger">
                                <p class="text-muted mb-1">Alfa</p>
                                <h6 class="mb-0 text-danger">
                                    {{ $this->alfaDesa }} Generus
                                    <small class="text-danger fw-semibold">
                                        ({{ $this->presentaseAlfaDesa }}%)
                                    </small>
                                </h6>
                            </div>
                        </div>
                    
                    </div>
                @endif
                <div class="mt-3">
                    <div class="alert alert-info border-dashed">
                        <i class="ri-lightbulb-flash-line me-1"></i>
                        <strong>Insight Desa {{ $nama_desa }}:</strong>
                        <br>
                        {{ $this->insightDesa }}
                    </div>
                </div>
            </div>
        </div>

        {{-- CONTENT GRID 7 : 5 --}}
        <div class="row g-3">
            {{-- KIRI: PRESENSI (7) --}}
            <div class="col-xxl-7 col-lg-7">
                @livewire('laporan.desa.kegiatan-event.report.attendance', [
                'kegiatanId' => $kegiatanId
                ])
            </div>

            {{-- KANAN: ALFA / TANPA KETERANGAN (5) --}}
            <div class="col-xxl-5 col-lg-5">
                @livewire('laporan.desa.kegiatan-event.report.alfa', [
                'kegiatanId' => $kegiatanId
                ])

            </div>

        </div>
        @endif
    </div>
</div>