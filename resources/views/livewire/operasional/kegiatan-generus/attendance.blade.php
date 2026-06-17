<div class="card border-0 rounded-4 overflow-hidden">
    {{-- HEADER --}}
    <div class="card-header border-0 p-4">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
            {{-- TITLE --}}
            <div class="d-flex align-items-center gap-3">
                <div class="avatar-sm">
                    <div class="avatar-title bg-primary-subtle text-primary rounded-circle fs-18">
                        <i class="ri-team-line">
                        </i>
                    </div>
                </div>
                <div>
                    <h5 class="fw-bold mb-1">
                        Kehadiran Generus
                    </h5>
                    <small>
                        Monitoring data hadir, izin, dan verifikasi peserta kegiatan
                    </small>
                </div>
            </div>
            {{-- ACTION --}}
            <div class="d-flex gap-2 flex-wrap">
                <button id="btnExportAttendance" class="btn btn-success rounded-pill px-4">
                    <i class="ri-file-excel-2-line me-1">
                    </i>
                    Export Excel
                </button>
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
                    <input type="text" class="form-control rounded-3" wire:model.debounce.400ms="search"
                        placeholder="Ketik nama generus...">
                    <i class="ri-search-line search-icon">
                    </i>
                </div>
            </div>
            {{-- KELOMPOK --}}
            <div class="col-xxl-3 col-lg-3 col-sm-6">
                <label class="form-label fw-semibold">
                    Kelompok
                </label>
                <select class="form-select rounded-3" wire:model="ms_kelompok_id" {{ !$ms_desa_id ? 'disabled' : '' }}>
                    <option value="">
                        Semua Kelompok
                    </option>
                    @foreach($listKelompok as $k)
                    <option value="{{ $k->ms_kelompok_id }}">
                        Kelompok {{ $k->nama_kelompok }}
                    </option>
                    @endforeach
                </select>
            </div>
            {{-- GENDER --}}
            <div class="col-xxl-3 col-lg-3 col-sm-6">
                <label class="form-label fw-semibold">
                    Gender
                </label>
                <select class="form-select rounded-3" wire:model="gender">
                    <option value="">
                        Semua Generus
                    </option>
                    <option value="laki-laki">
                        Laki-laki
                    </option>
                    <option value="perempuan">
                        Perempuan
                    </option>
                </select>
            </div>
        </div>
    </div>
    {{-- TABLE --}}
    <div class="card-body pt-0">
        <div class="table-responsive">
            <table id="Attendance" class="table align-middle table-hover mb-0">
                <thead class="table-light">
                    <tr class="text-uppercase fw-semibold">
                        <th style="width:70px;">#</th>
                        <th>Generus</th>
                        <th>Kelompok</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Verifikasi</th>
                        <th>
                            Waktu Hadir
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($presensi as $i => $row)
                    <tr>
                        {{-- NO --}}
                        <td class="text-muted fw-semibold">
                            {{ $presensi->firstItem() + $i }}
                        </td>
                        {{-- NAMA --}}
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar-xs flex-shrink-0">
                                    <div class="avatar-title 
                                        {{ $row->ms_generus->jenis_kelamin == 'perempuan'
                                        ? 'bg-danger-subtle text-danger'
                                        : 'bg-primary-subtle text-primary' 
                                        }} 
                                        rounded-circle fw-semibold">
                                        {{ strtoupper(substr($row->ms_generus->nama_generus, 0, 1)) }}
                                    </div>
                                </div>
                                <div>
                                    <div class="fw-semibold">
                                        {{ $row->ms_generus->nama_generus }}
                                    </div>
                                    <small class="text-muted">
                                        {{ strtoupper($row->ms_generus->jenis_kelamin) }}
                                    </small>
                                </div>
                            </div>
                        </td>
                        {{-- KELOMPOK --}}
                        <td>
                            <div class="fw-semibold">
                                Kelompok {{ $row->ms_generus->ms_kelompok->nama_kelompok ?? '-' }}
                            </div>
                        </td>
                        {{-- STATUS --}}
                        <td>
                            @php $statusClass = match($row->status_hadir) { 'hadir' => 'primary',
                            'izin' => 'danger', default => 'danger' }; @endphp
                            <div class="text-{{ $statusClass }} fw-semibold text-center">
                                {{ ucfirst($row->status_hadir) }}
                            </div>
                        </td>
                        {{-- VERIFIKASI --}}
                        <td class="text-center">
                            {{ ucfirst($row->verifikasi ?? '-') }}
                        </td>
                        {{-- WAKTU --}}
                        <td> 
                            @if($row->status_hadir === 'izin' || empty($row->waktu_hadir)) 
                                <div class="fw-semibold text-dark">izin</div> 
                            @else 
                                <div class="fw-semibold text-dark"> 
                                    {{ $row->tanggal_presensi ? \App\Http\Controllers\HelperController::formatTanggalIndonesia($row->tanggal_presensi, 'd F Y') : '-' }}
                                </div> 
                                <small class="text-muted"> 
                                    {{ \Carbon\Carbon::parse($row->waktu_hadir)->format('H:i') }} WIB 
                                </small> 
                            @endif 
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="d-flex flex-column align-items-center">
                                <div class="avatar-md mb-3">
                                    <div class="avatar-title rounded-circle bg-light text-muted fs-24">
                                        <i class="ri-inbox-archive-line">
                                        </i>
                                    </div>
                                </div>
                                <h6 class="fw-semibold mb-1">
                                    Belum Ada Data Presensi
                                </h6>
                                <p class="text-muted mb-0 fs-13">
                                    Data kehadiran generus akan tampil di sini
                                </p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    {{-- PAGINATION --}}
    <div class="card-footer bg-white border-top py-3">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="text-muted fs-13">
                Menampilkan
                <span class="fw-semibold">
                    {{ $presensi->firstItem() ?? 0 }}
                </span>
                -
                <span class="fw-semibold">
                    {{ $presensi->lastItem() ?? 0 }}
                </span>
                dari
                <span class="fw-semibold">
                    {{ $presensi->total() }}
                </span>
                data presensi
            </div>
            <div>
                {{ $presensi->links() }}
            </div>
        </div>
    </div>
</div>