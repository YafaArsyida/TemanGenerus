<div wire:ignore.self class="offcanvas offcanvas-top" id="offcanvasLaporan" aria-labelledby="offcanvasLaporanLabel"
    style="min-height:100vh;">

    <div class="offcanvas-header border-bottom">
        <div>
            <h5 class="offcanvas-title fw-bold" id="offcanvasLaporanLabel">
                <i class="ri-file-chart-line me-1 text-success"></i>
                Laporan Kehadiran Generus
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
                            ? \App\Http\Controllers\HelperController::formatTanggalIndonesia($kegiatan->tanggal, 'd F Y')
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
    
                {{-- DETAIL GRID --}}
                <div class="row g-3">
                    <div class="col-lg-3 col-sm-6">
                        <div class="p-2 border border-dashed rounded">
                            <p class="text-muted mb-1">Target Peserta</p>
                            <h6 class="mb-0">{{ $kegiatan->targetPeserta() ?? '-' }} Generus</h6>
                        </div>
                    </div>
    
                    <div class="col-lg-3 col-sm-6">
                        <div class="p-2 border border-dashed rounded">
                            <p class="text-muted mb-1">Hadir</p>
                            <h6 class="mb-0">{{ $kegiatan->totalHadir() ?? '-' }} Generus</h6>
                        </div>
                    </div>
    
                    <div class="col-lg-3 col-sm-6">
                        <div class="p-2 border border-dashed rounded">
                            <p class="text-muted mb-1">Izin</p>
                            <h6 class="mb-0">{{ $kegiatan->totalIzin() ?? '-' }} Generus</h6>
                        </div>
                    </div>
    
                    <div class="col-lg-3 col-sm-6">
                        <div class="p-2 border border-dashed rounded">
                            <p class="text-muted mb-1">Alfa</p>
                            <h6 class="mb-0">{{ $kegiatan->totalAlfa() ?? '-' }} Generus</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        {{-- CONTENT GRID 7 : 5 --}}
        <div class="row g-3">
            {{-- KIRI: PRESENSI (7) --}}
            <div class="col-xxl-7 col-lg-7">
                @livewire('laporan.kegiatan-event.report.attendance')
            </div>
    
            {{-- KANAN: ALFA / TANPA KETERANGAN (5) --}}
            <div class="col-xxl-5 col-lg-5">
                <div class="card h-100">
                    <div class="card-header border-0 d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">
                            Generus Alfa / Tanpa Keterangan
                        </h5>
                
                        <div class="flex-shrink-0 d-flex gap-2 flex-wrap">
                            <button data-bs-toggle="modal" data-bs-target="#ExportLaporanExcel" class="btn btn-soft-success">
                                <i class="ri-file-excel-2-line"></i> Export
                            </button>
                        </div>
                    </div>
                
                    <div class="card-body">
                        <div class="row g-3 mb-2">
                
                            {{-- Search --}}
                            <div class="col-xxl-6 col-sm-12">
                                <label class="form-label fw-semibold">Cari Nama Generus</label>
                                <div class="search-box">
                                    <input type="text" class="form-control" wire:model.debounce.400ms="search"
                                        placeholder="Ketik nama generus...">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                
                            {{-- Gender --}}
                            <div class="col-xxl-3 col-sm-6">
                                <label class="form-label fw-semibold">Laki-Laki/ Perempuan</label>
                                <select class="form-select" wire:model="gender">
                                    <option value="">Semua Generus</option>
                                    <option value="laki-laki">Laki-laki</option>
                                    <option value="perempuan">Perempuan</option>
                                </select>
                            </div>
                
                            {{-- Kelompok --}}
                            <div class="col-xxl-3 col-sm-6">
                                <label class="form-label">Kelompok</label>
                                <select class="form-select" wire:model="kelompokGenerus">
                                    <option value="">Semua Kelompok</option>
                                    {{-- @foreach($listKelompok as $k)
                                    <option value="{{ $k->ms_kelompok_id }}">
                                        Kelompok {{ $k->nama_kelompok }}
                                    </option>
                                    @endforeach --}}
                                </select>
                            </div>
                
                        </div>
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
                
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    
        </div>
        @endif
    </div>
</div>