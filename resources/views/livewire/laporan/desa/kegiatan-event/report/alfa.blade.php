<div class="card h-100">
    <div class="card-header border-0 d-flex align-items-center">
        <h5 class="card-title mb-0 flex-grow-1">
            Daftar Generus Alfa / Tidak Hadir
        </h5>

        <div class="flex-shrink-0 d-flex gap-2 flex-wrap">
            <div class="flex-shrink-0 d-flex gap-2 flex-wrap">
                <button id="btnExportAlfa" class="btn btn-soft-success">
                    <i class="ri-file-excel-2-line"></i> Export
                </button>
            </div>
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
                <select class="form-select" wire:model="ms_kelompok_id" {{ !$ms_desa_id ? 'disabled' : '' }}>
                    <option value="">Semua Kelompok</option>
                    @foreach($listKelompok as $k)
                    <option value="{{ $k->ms_kelompok_id }}">
                        Kelompok {{ $k->nama_kelompok }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Gender --}}
            <div class="col-xxl-3 col-sm-6">
                <label class="form-label">Gender</label>
                <select class="form-select" wire:model="gender">
                    <option value="">Semua</option>
                    <option value="laki-laki">Laki-laki</option>
                    <option value="perempuan">Perempuan</option>
                </select>
            </div>
        </div>

        <div class="table-responsive">
            <table id="Alfa" class="table table-hover table-striped align-middle w-100">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Kelompok</th>
                        <th>Alfa</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($alfa as $i => $g)
                    <tr>
                        <td>
                            {{ ($alfa->currentPage() - 1) * $alfa->perPage() + $loop->iteration }}
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $g->nama_generus }}</div>
                            <small class="text-muted">
                                {{ ucfirst($g->jenis_kelamin) }}
                            </small>
                        </td>
                        <td>
                            Kelompok {{ $g->ms_kelompok->nama_kelompok ?? '-' }}
                            <br>
                            <small class="text-muted">
                                {{ $g->ms_kelompok->ms_desa->nama_desa ?? '-' }}
                            </small>
                        </td>
                        <td>
                            <span class="badge bg-danger-subtle text-danger">
                                Alfa
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">
                            <i class="ri-information-line me-1"></i>
                            Belum ada data alfa
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $alfa->links() }}
        </div>
    </div>
    <script>
        document.getElementById('btnExportAlfa').addEventListener('click', function () {
            
                alertify.success("Menyiapkan Dokumen");
            
                setTimeout(function () {
            
                    var table = document.getElementById("Alfa");
            
                    var data = [];
                    var exportCols = [0,1,2,3];
            
                    // Header
                    var headers = [];
                    for (var i = 0; i < exportCols.length; i++) {
                        headers.push(table.tHead.rows[0].cells[exportCols[i]].innerText.trim());
                    }
                    data.push(headers);
            
                    // Body
                    for (var i = 0; i < table.tBodies[0].rows.length; i++) {
                        var row = table.tBodies[0].rows[i];
                        var rowData = [];
                        for (var j = 0; j < exportCols.length; j++) {
                            rowData.push(row.cells[exportCols[j]].innerText.trim());
                        }
                        data.push(rowData);
                    }
            
                    // Footer (jika ada)
                    if (table.tFoot) {
                        for (var i = 0; i < table.tFoot.rows.length; i++) {
                            var row = table.tFoot.rows[i];
                            var rowData = [];
                            for (var j = 0; j < exportCols.length; j++) {
                                rowData.push(row.cells[exportCols[j]].innerText.trim());
                            }
                            data.push(rowData);
                        }
                    }
            
                    // Excel
                    var wb = XLSX.utils.book_new();
                    var ws = XLSX.utils.aoa_to_sheet(data);
                    XLSX.utils.book_append_sheet(wb, ws, "Sheet1");
            
                    XLSX.writeFile(wb, "Laporan-Generus-Alfa.xlsx");
            
                }, 300); // delay kecil biar alert tampil
            });
    </script>
</div>