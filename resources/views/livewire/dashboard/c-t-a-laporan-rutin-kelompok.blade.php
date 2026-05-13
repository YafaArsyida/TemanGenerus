<div class="card border-0 shadow-sm h-100 overflow-hidden position-relative">
    {{-- DECORATION --}}
    <div class="position-absolute top-0 end-0 opacity-10 pe-3 pt-2">
        <i class="ri-team-fill display-4 text-success">
        </i>
    </div>
    <div class="card-body d-flex flex-column p-4">
        {{-- HEADER --}}
        <div class="d-flex align-items-center mb-4">
            <div class="avatar-sm flex-shrink-0">
                <span class="avatar-title bg-success-subtle text-success rounded-circle fs-3 shadow-sm">
                    <i class="ri-user-follow-line">
                    </i>
                </span>
            </div>
            <div class="ms-3">
                <h5 class="fw-bold mb-1">
                    Laporan Presensi Generus
                </h5>
                <span class="badge bg-success-subtle text-success fw-medium">
                    Rekap Kehadiran
                </span>
            </div>
        </div>
        {{-- DESCRIPTION --}}
        <div class="mb-4">
            <p class="text-muted mb-3">
                Monitoring kehadiran generus pada setiap kegiatan dengan tampilan laporan
                yang rapi, detail, dan mudah dianalisis.
            </p>
            {{-- FEATURES --}}
            <div class="d-flex flex-column gap-2">
                <div class="d-flex align-items-start gap-2">
                    <i class="ri-checkbox-circle-fill text-success mt-1">
                    </i>
                    <span class="text-muted fs-14">
                        Rekap hadir, izin, dan alfa secara otomatis
                    </span>
                </div>
                <div class="d-flex align-items-start gap-2">
                    <i class="ri-table-2 text-primary mt-1">
                    </i>
                    <span class="text-muted fs-14">
                        Tampilan matriks presensi yang mudah dipahami
                    </span>
                </div>
                <div class="d-flex align-items-start gap-2">
                    <i class="ri-download-2-fill text-warning mt-1">
                    </i>
                    <span class="text-muted fs-14">
                        Siap export untuk kebutuhan administrasi dan evaluasi
                    </span>
                </div>
            </div>
        </div>
        {{-- CTA --}}
        <div class="mt-auto">
            <a href="{{ route('laporan.kelompok.rutin') }}" class="btn btn-success w-100 rounded-pill">
                <i class="ri-bar-chart-box-line me-1">
                </i>
                Lihat Laporan Presensi
            </a>
        </div>
    </div>
</div>