<div class="row justify-content-center g-3 p-3">
    {{-- ================= HEADER KEGIATAN ================= --}}
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            {{-- TOP BAR --}}
            <div class="bg-primary bg-gradient" style="height: 5px;">
            </div>
            <div class="card-body p-4">
                <div class="row g-4 align-items-center">
                    {{-- LEFT --}}
                    <div class="col-lg-7">
                        <div class="d-flex align-items-start gap-3">
                            {{-- ICON --}}
                            <div class="avatar-md flex-shrink-0">
                                <div class="avatar-title rounded-circle bg-primary-subtle text-primary fs-2 shadow-sm">
                                    @if($kegiatan->tipe_kegiatan === 'rutin')
                                    <i class="ri-repeat-line">
                                    </i>
                                    @else
                                    <i class="ri-calendar-event-line">
                                    </i>
                                    @endif
                                </div>
                            </div>
                            {{-- CONTENT --}}
                            <div class="flex-grow-1">
                                <div class="d-flex flex-wrap gap-2 mb-2">
                                    <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">
                                        {{ ucfirst($kegiatan->tipe_kegiatan) }}
                                    </span>
                                    <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                                        {{ ucfirst($kegiatan->jenjang ?? 'Semua Jenjang') }}
                                    </span>
                                    <span class="badge bg-info-subtle text-info rounded-pill px-3 py-2">
                                        {{ ucfirst($kegiatan->scope) }}
                                    </span>
                                </div>
                                <h3 class="fw-bold mb-2">
                                    {{ $kegiatan->nama_kegiatan }}
                                </h3>
                                @if($kegiatan->deskripsi)
                                <p class="text-muted mb-3">
                                    {{ $kegiatan->deskripsi }}
                                </p>
                                @endif {{-- META --}}
                                <div class="d-flex flex-wrap gap-4 text-muted fs-14">
                                    <div>
                                        <i class="ri-map-pin-line text-danger me-1">
                                        </i>
                                        @if($kegiatan->scope === 'daerah') Daerah Sragen Barat @elseif($kegiatan->scope
                                        === 'desa') Desa {{ $kegiatan->ms_desa->nama_desa ?? '-' }}
                                        @elseif($kegiatan->scope
                                        === 'kelompok') Kelompok {{ $kegiatan->ms_kelompok->nama_kelompok ?? '-'
                                        }} @endif
                                    </div>
                                    <div>
                                        <i class="ri-building-line text-primary me-1">
                                        </i>
                                        {{ $kegiatan->lokasi_final['tempat'] ?? '-' }}
                                    </div>
                                    <div>
                                        <i class="ri-calendar-line text-success me-1">
                                        </i>
                                        {{ \App\Http\Controllers\HelperController::formatTanggalIndonesia(
                                        $kegiatan->tanggal,
                                        'd F Y' ) }}
                                    </div>
                                    <div>
                                        <i class="ri-time-line text-warning me-1">
                                        </i>
                                        {{ $kegiatan->waktu }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- RIGHT --}}
                    <div class="col-lg-5 text-lg-end">
                        <div class="d-flex flex-column gap-3 align-items-lg-end">
                            {{-- SUMMARY --}}
                            <div class="d-flex gap-3 flex-wrap justify-content-lg-end">
                                <div class="border rounded-4 px-4 py-3 text-center bg-success-subtle">
                                    <div class="fw-bold fs-3 text-success">
                                        {{ collect($presensiMap)->filter(fn($v) => $v === 'hadir')->count() }}
                                    </div>
                                    <small class="text-muted">
                                        Hadir
                                    </small>
                                </div>
                                <div class="border rounded-4 px-4 py-3 text-center bg-danger-subtle">
                                    <div class="fw-bold fs-3 text-danger">
                                        {{ collect($presensiMap)->filter(fn($v) => $v === 'izin')->count() }}
                                    </div>
                                    <small class="text-muted">
                                        Izin
                                    </small>
                                </div>
                            </div>
                            {{-- PARAMETER --}} @if($kegiatan->scope === 'daerah')
                            <div>
                                @livewire('parameter.desa')
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- ================= DATA GENERUS ================= --}}
    <div class="col-xl-12">
        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
            {{-- HEADER --}}
            <div class="card-header bg-white border-0 p-4">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div>
                        <h5 class="fw-bold mb-1">
                            <i class="ri-team-line text-primary me-1">
                            </i>
                            Data Generus
                        </h5>
                        <p class="text-muted mb-0">
                            Kelola presensi generus secara realtime
                        </p>
                    </div>
                    <div class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">
                        {{ count($listGenerus) }} Generus
                    </div>
                </div>
            </div>
            {{-- FILTER --}}
            <div class="card-body border-top bg-light-subtle">
                <div class="row g-3 align-items-end">
                    {{-- SEARCH --}}
                    <div class="col-lg-4">
                        <label class="form-label fw-semibold">
                            Cari Generus
                        </label>
                        <div class="search-box">
                            <input type="text" class="form-control rounded-3" placeholder="Cari nama generus..."
                                wire:model.debounce.500ms="searchGenerus">
                            <i class="ri-search-line search-icon">
                            </i>
                        </div>
                    </div>
                    {{-- KELOMPOK --}}
                    <div class="col-lg-4">
                        <label class="form-label fw-semibold">
                            Kelompok
                        </label>
                        <select class="form-select rounded-3" wire:model="kelompokGenerus">
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
                    <div class="col-lg-2">
                        <label class="form-label fw-semibold">
                            L / P
                        </label>
                        <select class="form-select rounded-3" wire:model="genderGenerus">
                            <option value="">
                                Semua
                            </option>
                            <option value="laki-laki">
                                L
                            </option>
                            <option value="perempuan">
                                P
                            </option>
                        </select>
                    </div>
                    {{-- JENJANG --}}
                    <div class="col-lg-2">
                        <label class="form-label fw-semibold">
                            Jenjang
                        </label>
                        <div class="alert alert-primary py-2 px-3 mb-0 rounded-3 text-center">
                            <strong>
                                {{ strtoupper($kegiatan->jenjang ?? 'SEMUA') }}
                            </strong>
                        </div>
                    </div>
                </div>
            </div>
            {{-- TABLE --}}
            <div class="table-responsive" style="max-height: 850px;">
                <table class="table align-middle table-hover mb-0">
                    <thead class="table-light sticky-top z-1">
                        <tr>
                            <th width="60">
                                #
                            </th>
                            <th>
                                Generus
                            </th>
                            <th>
                                Kelompok
                            </th>
                            <th style="white-space: nowrap" class="text-center">
                                Presensi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($listGenerus as $i => $g) @php $status = $presensiMap[$g->ms_generus_id]
                        ?? null; @endphp
                        <tr>
                            <td class="fw-semibold">
                                {{ $i + 1 }}
                            </td>
                            <td class="fw-semibold">
                                {{ $g->nama_generus }}
                            </td>
                            <td>
                                Kelompok {{ $g->ms_kelompok->nama_kelompok ?? '-' }}
                            </td>
                            {{-- <td>
                                @if($g->usia)
                                <span class="badge bg-light text-dark border">
                                    {{ collect($g->jenjang_usia)->implode(', ') }}
                                </span>
                                @else - @endif
                            </td> --}}
                            {{-- ACTION --}}
                            <td class="text-center text-nowrap">
                                @if(!$status)
                                <div class="d-inline-flex align-items-center gap-2 flex-nowrap">
                                    <button class="btn btn-success btn-sm rounded-pill px-3" wire:click="hadir({{ $g->ms_generus_id }})">
                                        <i class="ri-check-line me-1">
                                        </i>
                                        Hadir
                                    </button>
                                    <button class="btn btn-soft-danger btn-sm rounded-pill px-3" wire:click="izin({{ $g->ms_generus_id }})">
                                        <i class="ri-close-line me-1">
                                        </i>
                                        Izin
                                    </button>
                                </div>
                                @elseif($status === 'hadir')
                                <div class="d-inline-flex align-items-center gap-2 flex-nowrap">
                                    <button class="btn btn-soft-success btn-sm rounded-pill px-3">
                                        <i class="ri-check-double-line me-1">
                                        </i>
                                        Sudah Hadir
                                    </button>
                                    <a class="text-danger small fw-semibold text-decoration-none"
                                        wire:click="batalPresensi({{ $g->ms_generus_id }})" style="cursor:pointer;">
                                        Batalkan
                                    </a>
                                </div>
                                @elseif($status === 'izin')
                                <div class="d-inline-flex align-items-center gap-2 flex-nowrap">
                                    <button class="btn btn-soft-warning btn-sm rounded-pill px-3">
                                        <i class="ri-error-warning-line me-1">
                                        </i>
                                        Izin
                                    </button>
                                    <a class="text-danger small fw-semibold text-decoration-none"
                                        wire:click="batalPresensi({{ $g->ms_generus_id }})" style="cursor:pointer;">
                                        Batalkan
                                    </a>
                                </div>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-5">
                                <i class="ri-inbox-line fs-1 d-block mb-2">
                                </i>
                                Tidak ada data generus
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- ================= DATA PRESENSI ================= --}}
    {{-- <div class="col-xl-5">
        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
            <div class="card-header bg-white border-0 p-4">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div>
                        <h5 class="fw-bold mb-1">
                            <i class="ri-file-list-3-line text-success me-1">
                            </i>
                            Riwayat Presensi
                        </h5>
                        <p class="text-muted mb-0">
                            Aktivitas presensi realtime kegiatan
                        </p>
                    </div>
                    <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                        {{ count($this->riwayatAbsensi) }} Presensi
                    </span>
                </div>
            </div>
            <div class="card-body border-top bg-light-subtle">
                <div class="row g-3 align-items-end">
                    <div class="col-lg-5">
                        <label class="form-label fw-semibold">
                            Cari
                        </label>
                        <div class="search-box">
                            <input type="text" class="form-control rounded-3" placeholder="Cari nama..."
                                wire:model.debounce.500ms="searchPresensi">
                            <i class="ri-search-line search-icon">
                            </i>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <label class="form-label fw-semibold">
                            Kelompok
                        </label>
                        <select class="form-select rounded-3" wire:model="kelompokPresensi">
                            <option value="">
                                Semua
                            </option>
                            @foreach($listKelompok as $k)
                            <option value="{{ $k->ms_kelompok_id }}">
                                {{ $k->nama_kelompok }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label class="form-label fw-semibold">
                            L / P
                        </label>
                        <select class="form-select rounded-3" wire:model="genderPresensi">
                            <option value="">
                                Semua
                            </option>
                            <option value="laki-laki">
                                L
                            </option>
                            <option value="perempuan">
                                P
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="table-responsive" style="max-height: 850px;">
                <table class="table align-middle table-hover mb-0">
                    <thead class="table-light sticky-top z-1">
                        <tr>
                            <th width="60">
                                #
                            </th>
                            <th>
                                Generus
                            </th>
                            <th>
                                Kelompok
                            </th>
                            <th>
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($this->riwayatAbsensi as $index => $absen)
                        <tr>
                            <td class="fw-semibold">
                                {{ $index + 1 }}
                            </td>
                            <td>
                                <div class="fw-semibold">
                                    {{ $absen->ms_generus->nama_generus ?? '-' }}
                                </div>
                            </td>
                            <td>
                                {{ $absen->ms_generus->ms_kelompok->nama_kelompok ?? '-' }}
                            </td>
                            <td>
                                @if($absen->status_hadir === 'hadir')
                                <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                                    <i class="ri-check-line me-1">
                                    </i>
                                    Hadir
                                </span>
                                @else
                                <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2">
                                    <i class="ri-close-line me-1">
                                    </i>
                                    {{ ucfirst($absen->status_hadir) }}
                                </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-5">
                                <i class="ri-calendar-close-line fs-1 d-block mb-2">
                                </i>
                                Belum ada presensi hari ini
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div> --}}
</div>