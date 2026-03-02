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
                        <i class="ri-repeat-line text-warning me-1"></i>
                        Hari
                        <span class="text-body fw-medium">
                            @if($kegiatan->hari_rutin && count($kegiatan->hari_rutin))
                            {{ collect($kegiatan->hari_rutin)->map(fn($h) => ucfirst($h))->implode(', ') }}
                            @else
                            Jadwal Mingguan
                            @endif
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
            </div>
        </div>

        <div class="row g-3">
            <div class="col-xxl-12 col-lg-12">
                @livewire('laporan.kelompok.kegiatan-rutin.report.attendance-matrix', [
                'kegiatanId' => $kegiatanId
                ])
            </div>
        </div>
        @endif
    </div>
</div>