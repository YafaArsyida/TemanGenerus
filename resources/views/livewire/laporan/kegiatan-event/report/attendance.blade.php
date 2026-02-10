<div class="card h-100">
    <div class="card-header border-0 d-flex align-items-center">
        <h5 class="card-title mb-0 flex-grow-1">
            Presensi Kehadiran Generus
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

            {{-- Gender --}}
            <div class="col-xxl-3 col-sm-6">
                <label class="form-label fw-semibold">Laki-Laki / Perempuan</label>
                <select class="form-select" wire:model="gender">
                    <option value="">Semua Generus</option>
                    <option value="laki-laki">Laki-laki</option>
                    <option value="perempuan">Perempuan</option>
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
                    @forelse($presensi as $i => $row)
                    <tr>
                        <td>{{ $presensi->firstItem() + $i }}</td>
                        <td class="fw-medium">
                            {{ $row->ms_generus->nama_generus ?? '-' }}
                        </td>
                        <td>
                            {{ $row->ms_generus->ms_kelompok->nama_kelompok ?? '-' }}
                        </td>
                        <td>
                            <span class="badge 
                                    {{ $row->status_hadir === 'hadir' ? 'bg-success' : 
                                       ($row->status_hadir === 'izin' ? 'bg-warning' : 'bg-danger') }}">
                                {{ ucfirst($row->status_hadir) }}
                            </span>
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

        <div class="mt-3">
            {{ $presensi->links() }}
        </div>
    </div>
</div>