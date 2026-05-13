<div class="card border-0 shadow-sm overflow-hidden h-100">
    {{-- HEADER --}}
    <div class="card-header bg-white border-0 pb-0">
        <div class="d-flex align-items-center gap-2">
            <div class="avatar-xs">
                <div class="avatar-title bg-primary-subtle text-primary rounded-circle">
                    <i class="ri-dashboard-line">
                    </i>
                </div>
            </div>
            <div>
                <h5 class="fw-bold mb-0">
                    Ringkasan Kegiatan Bulan Ini
                </h5>
                <small class="text-muted">
                    Statistik kehadiran generus pada kegiatan terpilih
                </small>
            </div>
        </div>
    </div>
    {{-- BODY --}}
    <div class="card-body">
        {{-- FILTER --}}
        <div class="mb-4">
            <label class="form-label fw-semibold">
                Pilih Kegiatan
            </label>
            <select wire:model="selectedKegiatan" class="form-select rounded-3 shadow-sm border-light">
                <option value="">
                    -- Pilih Kegiatan Bulan Ini --
                </option>
                @foreach ($listKegiatan as $kegiatan)
                <option value="{{ $kegiatan->ms_kegiatan_id }}">
                    {{ $kegiatan->nama_kegiatan }} — {{ $kegiatan->waktu }}
                </option>
                @endforeach
            </select>
        </div>
        {{-- SUMMARY --}}
        <div class="row g-3 text-center">
            {{-- HADIR --}}
            <div class="col-md-4 col-12">
                <div class="border rounded-4 p-3 bg-success-subtle h-100">
                    <div class="avatar-sm mx-auto mb-3">
                        <div class="avatar-title bg-success text-white rounded-circle fs-4 shadow-sm">
                            <i class="ri-user-follow-fill">
                            </i>
                        </div>
                    </div>
                    <h2 class="fw-bold text-success mb-1">
                        {{ $hadir }}
                    </h2>
                    <div class="fw-semibold">
                        Hadir
                    </div>
                    <small class="text-muted">
                        Generus mengikuti kegiatan
                    </small>
                </div>
            </div>
            {{-- IZIN --}}
            <div class="col-md-4 col-12">
                <div class="border rounded-4 p-3 bg-warning-subtle h-100">
                    <div class="avatar-sm mx-auto mb-3">
                        <div class="avatar-title bg-warning text-white rounded-circle fs-4 shadow-sm">
                            <i class="ri-error-warning-fill">
                            </i>
                        </div>
                    </div>
                    <h2 class="fw-bold text-warning mb-1">
                        {{ $izin }}
                    </h2>
                    <div class="fw-semibold">
                        Izin
                    </div>
                    <small class="text-muted">
                        Generus berhalangan hadir
                    </small>
                </div>
            </div>
            {{-- ALFA --}}
            <div class="col-md-4 col-12">
                <div class="border rounded-4 p-3 bg-danger-subtle h-100">
                    <div class="avatar-sm mx-auto mb-3">
                        <div class="avatar-title bg-danger text-white rounded-circle fs-4 shadow-sm">
                            <i class="ri-user-unfollow-fill">
                            </i>
                        </div>
                    </div>
                    <h2 class="fw-bold text-danger mb-1">
                        {{ $alfa }}
                    </h2>
                    <div class="fw-semibold">
                        Alfa
                    </div>
                    <small class="text-muted">
                        Generus tidak hadir kegiatan
                    </small>
                </div>
            </div>
        </div>
        {{-- FOOTER INFO --}}
        <div class="mt-4 text-center">
            <small class="text-muted">
                <i class="ri-information-line me-1">
                </i>
                Data akan berubah otomatis sesuai kegiatan yang dipilih.
            </small>
        </div>
    </div>
</div>