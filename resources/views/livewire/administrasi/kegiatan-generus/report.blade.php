<div wire:ignore.self class="offcanvas offcanvas-top" id="offcanvasLaporan" aria-labelledby="offcanvasLaporanLabel"
    style="min-height:100vh;">

    <div class="offcanvas-header border-bottom">
        <div>
            <h5 class="offcanvas-title fw-bold" id="offcanvasLaporanLabel">
                <i class="ri-file-chart-line me-1 text-success"></i>
                Laporan Kehadiran Generus
            </h5>
            @if($kegiatan)
            <small class="text-muted">
                {{ $kegiatan->nama_kegiatan }}
            </small>
            @endif
        </div>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">

        {{-- INFO GLOBAL KEGIATAN --}}
        @if($kegiatan)
        <div class="row g-3 mb-3">

            <div class="col-lg-4 col-sm-6">
                <div class="border rounded p-3 h-100">
                    <p class="text-muted mb-1">Tipe Kegiatan</p>
                    <h6 class="mb-0">
                        {{ ucfirst($kegiatan->tipe_kegiatan) }}
                        @if($kegiatan->tipe_kegiatan === 'rutin' && $kegiatan->hari_rutin_label)
                        <span class="d-block fs-12 text-muted">
                            Hari: {{ $kegiatan->hari_rutin_label }}
                        </span>
                        @endif
                    </h6>
                </div>
            </div>

            <div class="col-lg-2 col-sm-6">
                <div class="border rounded p-3 h-100">
                    <p class="text-muted mb-1">Target Peserta</p>
                    <h5 class="mb-0 fw-bold text-primary">
                        {{ $targetPeserta }} orang
                    </h5>
                </div>
            </div>

            <div class="col-lg-2 col-sm-6">
                <div class="border rounded p-3 h-100">
                    <p class="text-muted mb-1">Hadir</p>
                    <h5 class="mb-0 fw-bold text-success">
                        {{ $totalHadir }} orang
                    </h5>
                </div>
            </div>

            <div class="col-lg-2 col-sm-6">
                <div class="border rounded p-3 h-100">
                    <p class="text-muted mb-1">Izin</p>
                    <h5 class="mb-0 fw-bold text-success">
                        {{ $totalIzin }} orang
                    </h5>
                </div>
            </div>

            <div class="col-lg-2 col-sm-6">
                <div class="border rounded p-3 h-100">
                    <p class="text-muted mb-1">Persentase</p>
                    <h5 class="mb-0 fw-bold text-warning">
                        {{ $persentaseHadir }}%
                    </h5>
                </div>
            </div>

        </div>
        @endif
        <div class="row g-3">
            <div class="col-xxl-7">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex align-items-center">
                            <h5 class="card-title mb-0 flex-grow-1">Presensi Kehadiran Generus</h5>
                    
                            <div class="flex-shrink-0">
                                <div class="d-flex gap-2 flex-wrap">
                                    {{-- <button wire:click="cetakLaporanTagihan"
                                        class="btn btn-danger d-inline-flex align-items-center gap-1">
                                        <i class="ri-printer-line align-bottom"></i>
                                        <span>Cetak Laporan</span>
                                    </button> --}}
                                    <button data-bs-toggle="modal" data-bs-target="#ExportLaporanExcel" class="btn btn-soft-success"><i
                                            class="ri-file-excel-2-line pb-0"></i> Export</button>
                                    <button data-bs-toggle="modal" id="create-btn" data-bs-target="#ModalKegiatanCreate"
                                        wire:click.prevent="$emit('KegiatanCreate')" class="btn btn-primary"><i
                                            class="ri-play-list-add-line"></i> Kegiatan Baru</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        {{-- TABEL KEHADIRAN --}}
                        <div class="table-responsive">
                            <table class="table table-hover table-striped align-middle w-100">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th>Kelompok</th>
                                        <th>Status</th>
                                        <th>Verifikasi</th>
                                        <th>Waktu Hadir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($presensi as $i => $row)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td class="fw-medium">
                                            {{ $row->ms_generus->nama_generus ?? '-' }}
                                        </td>
                                        <td>
                                            {{ $row->ms_generus->ms_kelompok->nama_kelompok ?? '-' }}
                                        </td>
                                        <td>
                                            {{ $row->status_hadir }}
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-body">
                                                {{ ucfirst($row->verifikasi ?? '-') }}
                                            </span>
                                        </td>
                                        <td class="text-muted">
                                            {{ \Carbon\Carbon::parse($row->waktu_hadir)->format('d M Y H:i') }}
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            <i class="ri-information-line me-1"></i>
                                            Belum ada data presensi
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>