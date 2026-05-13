<div class="card border-0 shadow-sm h-100 overflow-hidden position-relative">
    {{-- DECORATION --}}
    <div class="position-absolute top-0 end-0 opacity-10 pe-3 pt-2">
        <i class="ri-calendar-event-fill display-4 text-primary">
        </i>
    </div>
    <div class="card-body d-flex flex-column p-4">
        {{-- HEADER --}}
        <div class="d-flex align-items-center mb-4">
            <div class="avatar-sm flex-shrink-0">
                <span class="avatar-title bg-primary-subtle text-primary rounded-circle fs-3 shadow-sm">
                    <i class="ri-file-chart-line">
                    </i>
                </span>
            </div>
            <div class="ms-3">
                <h5 class="fw-bold mb-1">
                    Laporan Kegiatan Event
                </h5>
                <span class="badge bg-primary-subtle text-primary fw-medium">
                    Monitoring Kehadiran
                </span>
            </div>
        </div>
        {{-- DESCRIPTION --}}
        <div class="mb-4">
            <p class="text-muted mb-3">
                Pantau aktivitas dan kehadiran generus pada setiap kegiatan event secara
                lebih detail dan terstruktur.
            </p>
            {{-- FEATURES --}}
            <div class="d-flex flex-column gap-2">
                <div class="d-flex align-items-start gap-2">
                    <i class="ri-checkbox-circle-fill text-success mt-1">
                    </i>
                    <span class="text-muted fs-14">
                        Rekap hadir, izin, dan alfa generus
                    </span>
                </div>
                <div class="d-flex align-items-start gap-2">
                    <i class="ri-time-fill text-primary mt-1">
                    </i>
                    <span class="text-muted fs-14">
                        Monitoring waktu dan status kehadiran
                    </span>
                </div>
                <div class="d-flex align-items-start gap-2">
                    <i class="ri-pie-chart-2-fill text-warning mt-1">
                    </i>
                    <span class="text-muted fs-14">
                        Analisis persentase keaktifan kegiatan
                    </span>
                </div>
            </div>
        </div>
        {{-- CTA --}}
        <div class="mt-auto">
            <a href="{{ route('laporan.kelompok.event') }}" class="btn btn-primary w-100 rounded-pill">
                <i class="ri-bar-chart-box-line me-1">
                </i>
                Lihat Laporan Event
            </a>
        </div>
    </div>
</div>