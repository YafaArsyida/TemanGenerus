<div class="card border-0 shadow-sm h-100 overflow-hidden">
    {{-- HEADER --}}
    <div class="card-header bg-white border-0 py-4">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
            {{-- TITLE --}}
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <div class="avatar-xs">
                        <div class="avatar-title bg-warning-subtle text-warning rounded-circle">
                            <i class="ri-trophy-line">
                            </i>
                        </div>
                    </div>
                    <h4 class="card-title mb-0 fw-bold">
                        Ranking Kehadiran
                    </h4>
                </div>
                <p class="text-muted mb-0 fs-13">
                    Daftar generus dengan tingkat kehadiran terbaik.
                </p>
            </div>
            {{-- FILTER --}}
            <div class="flex-shrink-0">
                <label class="form-label text-muted small mb-1">
                    Periode Ranking
                </label>
                <select wire:model="periode" class="form-select form-select-sm rounded-pill shadow-sm border-light">
                    <option value="1bulan">
                        1 Bulan
                    </option>
                    <option value="3bulan">
                        3 Bulan
                    </option>
                    <option value="1tahun">
                        1 Tahun
                    </option>
                </select>
            </div>
        </div>
    </div>
    {{-- TABLE --}}
    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="70px" class="text-uppercase text-muted fw-semibold">
                            Rank
                        </th>
                        <th class="text-uppercase text-muted fw-semibold">
                            Generus
                        </th>
                        <th class="text-center text-uppercase text-muted fw-semibold">
                            Kehadiran
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $index => $item) @php $ranking = $data->firstItem()
                    + $index; @endphp
                    <tr>
                        {{-- RANK --}}
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                {{-- ICON --}} @if($ranking == 1)
                                <div class="avatar-xs">
                                    <div class="avatar-title bg-warning text-white rounded-circle">
                                        <i class="ri-medal-fill">
                                        </i>
                                    </div>
                                </div>
                                @elseif($ranking == 2)
                                <div class="avatar-xs">
                                    <div class="avatar-title bg-secondary text-white rounded-circle">
                                        <i class="ri-award-fill">
                                        </i>
                                    </div>
                                </div>
                                @elseif($ranking == 3)
                                <div class="avatar-xs">
                                    <div class="avatar-title bg-danger text-white rounded-circle">
                                        <i class="ri-trophy-fill">
                                        </i>
                                    </div>
                                </div>
                                @else
                                <div class="avatar-xs">
                                    <div class="avatar-title bg-light text-muted rounded-circle fw-semibold">
                                        {{ $ranking }}
                                    </div>
                                </div>
                                @endif
                            </div>
                        </td>
                        {{-- NAMA --}}
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar-xs flex-shrink-0">
                                    <div class="avatar-title bg-primary-subtle text-primary rounded-circle fw-semibold">
                                        {{ strtoupper(substr($item->ms_generus->nama_generus ?? 'G', 0, 1)) }}
                                    </div>
                                </div>
                                <div>
                                    <div class="fw-semibold text-body">
                                        {{ $item->ms_generus->nama_generus ?? '-' }}
                                    </div>
                                    <small class="text-muted">
                                        {{ $item->ms_generus->ms_kelompok->nama_kelompok ?? '-' }}
                                    </small>
                                </div>
                            </div>
                        </td>

                        <td class="text-center">
                            <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill fw-semibold">
                                <i class="ri-checkbox-circle-line me-1">
                                </i>
                                {{ $item->total_hadir }}x Hadir
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <div class="d-flex flex-column align-items-center">
                                <div class="avatar-md mb-3">
                                    <div class="avatar-title bg-light text-muted rounded-circle fs-2">
                                        <i class="ri-bar-chart-grouped-line">
                                        </i>
                                    </div>
                                </div>
                                <h6 class="fw-semibold mb-1">
                                    Belum Ada Data Kehadiran
                                </h6>
                                <p class="text-muted mb-0 fs-13">
                                    Ranking kehadiran generus akan tampil di sini.
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