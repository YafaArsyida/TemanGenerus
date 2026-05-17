<div class="card border-0 shadow-sm h-100 overflow-hidden">
    {{-- HEADER --}}
    <div class="card-header bg-white border-0 py-4">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <div class="avatar-xs">
                        <div class="avatar-title bg-primary-subtle text-primary rounded-circle">
                            <i class="ri-team-line">
                            </i>
                        </div>
                    </div>
                    <h4 class="card-title mb-0 fw-bold">
                        Data Generus
                    </h4>
                </div>
                <p class="text-muted mb-0 fs-13">
                    Monitoring data generasi penerus berdasarkan kelompok dan jenjang usia.
                </p>
            </div>
            {{-- TOTAL --}}
            <div class="text-lg-end">
                <div class="badge bg-primary-subtle text-primary fs-13 px-3 py-2 rounded-pill">
                    <i class="ri-database-2-line me-1">
                    </i>
                    {{ $data->total() }} Generus
                </div>
            </div>
        </div>
    </div>
    {{-- FILTER --}}
    <div class="card-body border-top bg-light-subtle">
        <div class="row g-3 align-items-end">
            {{-- SEARCH --}}
            <div class="col-xxl-6 col-lg-6">
                <label class="form-label fw-semibold">
                    Cari Nama Generus
                </label>
                <div class="search-box">
                    <input type="text" class="form-control border-light shadow-sm rounded-3"
                        wire:model.debounce.400ms="search" placeholder="Ketik nama generus...">
                    <i class="ri-search-line search-icon">
                    </i>
                </div>
            </div>
            {{-- JENJANG --}}
            <div class="col-xxl-6 col-lg-6">
                <label class="form-label fw-semibold">
                    Jenjang Usia
                </label>
                <select class="form-select rounded-3 shadow-sm border-light" wire:model="jenjangUsia">
                    <option value="">
                        Semua Jenjang Usia
                    </option>
                    <option value="caberawit">
                        Caberawit (&lt; 12 Tahun)
                    </option>
                    <option value="remaja">
                        Remaja (12 – 30 Tahun)
                    </option>
                    <option value="gp">
                        GP (12 – 23 Tahun)
                    </option>
                    {{-- <option value="pra_nikah">
                        Pra Nikah (19 – 23 Tahun)
                    </option> --}}
                    <option value="mandiri">
                        Mandiri (&gt; 17 Tahun)
                    </option>
                </select>
            </div>
        </div>
    </div>
    {{-- TABLE --}}
    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle table-nowrap mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="60px" class="text-muted text-uppercase fw-semibold">
                            No
                        </th>
                        <th class="text-muted text-uppercase fw-semibold">
                            Nama Generus
                        </th>
                        <th class="text-muted text-uppercase fw-semibold">
                            Kelompok
                        </th>
                        <th class="text-center text-muted text-uppercase fw-semibold">
                            Usia
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $index => $item)
                    <tr>
                        {{-- NO --}}
                        <td class="fw-semibold text-muted">
                            {{ $data->firstItem() + $index }}
                        </td>
                        {{-- NAMA --}}
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar-xs flex-shrink-0">
                                    <div class="avatar-title bg-primary-subtle text-primary rounded-circle fw-semibold">
                                        {{ strtoupper(substr($item->nama_generus, 0, 1)) }}
                                    </div>
                                </div>
                                <div>
                                    <div class="fw-semibold text-body">
                                        {{ $item->nama_generus }}
                                    </div>
                                    <small class="text-muted">
                                        Generasi Penerus
                                    </small>
                                </div>
                            </div>
                        </td>
                        {{-- KELOMPOK --}}
                        <td>
                            <span class="badge bg-light text-body border px-3 py-2 fw-medium">
                                <i class="ri-group-line me-1 text-primary">
                                </i>
                                {{ $item->ms_kelompok->nama_kelompok ?? '-' }}
                            </span>
                        </td>
                        {{-- USIA --}}
                        <td class="text-center">
                            @if($item->usia)
                            <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">
                                <i class="ri-calendar-line me-1">
                                </i>
                                {{ $item->usia }} Tahun
                            </span>
                            @else
                            <span class="text-muted">
                                -
                            </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <div class="d-flex flex-column align-items-center">
                                <div class="avatar-md mb-3">
                                    <div class="avatar-title bg-light text-muted rounded-circle fs-2">
                                        <i class="ri-inbox-archive-line">
                                        </i>
                                    </div>
                                </div>
                                <h6 class="fw-semibold mb-1">
                                    Tidak Ada Data Generus
                                </h6>
                                <p class="text-muted mb-0 fs-13">
                                    Data generus belum tersedia atau tidak ditemukan.
                                </p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- PAGINATION --}}
        <div class="mt-4 d-flex justify-content-end">
            {{ $data->links() }}
        </div>
    </div>
</div>