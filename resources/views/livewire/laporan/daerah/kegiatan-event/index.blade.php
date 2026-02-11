<div class="card">
    <div class="card-header border-0">
        <div class="d-flex align-items-center">
            <h5 class="card-title mb-0 flex-grow-1">Kegiatan Event Generasi Penerus</h5>

            <div class="flex-shrink-0">
                <div class="d-flex gap-2 flex-wrap">
                    <button data-bs-toggle="modal" data-bs-target="#ExportLaporanExcel" class="btn btn-soft-success"><i
                            class="ri-file-excel-2-line pb-0"></i> Export</button>
                </div>
            </div>
        </div>
    </div>

    <div class="card-body border border-dashed border-end-0 border-start-0">

        <div class="row g-3 align-items-end">
        
            {{-- Search --}}
            <div class="col-xxl-4 col-sm-6">
                <label class="form-label">Pencarian</label>
                <input type="text" class="form-control" placeholder="Cari nama kegiatan..." wire:model.debounce.500ms="search">
            </div>
        
            {{-- Jenjang --}}
            <div class="col-xxl-2 col-sm-4">
                <label class="form-label">Jenjang Usia</label>
                <select class="form-select" wire:model="jenjangUsia">
                    <option value="">Semua Generus</option>
                    <option value="caberawit">Caberawit (0–11)</option>
                    <option value="remaja">Remaja (12–30)</option>
                    <option value="gp">GP (12–23)</option>
                    <option value="pra_nikah">Pra Nikah (19–23)</option>
                    <option value="mandiri">Mandiri (23–25)</option>
                </select>
            </div>
        
            {{-- Status (opsional kalau ada kolom status) --}}
            <div class="col-xxl-2 col-sm-4">
                <label class="form-label">Status</label>
                <select class="form-select" wire:model="status">
                    <option value="">Semua</option>
                    <option value="aktif">Aktif</option>
                    <option value="selesai">Selesai</option>
                </select>
            </div>
        
            {{-- Periode --}}
            <div class="col-xxl-4 col-sm-6">
                <label class="form-label fw-semibold">Periode</label>
                <div class="d-flex align-items-center gap-2">
                    <input type="date" id="startDate" class="form-control" wire:model="startDate" value="{{ $startDate }}">
                    <span class="text-muted">–</span>
                    <input type="date" id="endDate" class="form-control" wire:model="endDate" value="{{ $endDate }}">
                    <div class="col-auto">
                        <button type="button" class="btn btn-soft-secondary btn-icon rounded-circle" wire:click="resetTanggal"
                            title="Reset Tanggal">
                            <i class="ri-refresh-line fs-16"></i>
                        </button>
                    </div>
                </div>
            </div>
        
        </div>

    </div>

    <div class="card-body">

        <div class="table-responsive">
            <table id="Laporan" class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px">#</th>
                        <th>Tanggal & Waktu</th>
                        <th>Kegiatan</th>
                        <th>Peserta</th>
                        <th>Tingkat</th>
                        <th>Target</th>
                        <th>Hadir</th>
                        <th>Izin</th>
                        <th>Alfa</th>
                        <th>% Hadir</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($data as $index => $item)
                    <tr>
                        <td>{{ $data->firstItem() + $index }}</td>
                        {{-- Tanggal & Waktu --}}
                        <td>
                            {{ $item->tanggal
                            ? \App\Http\Controllers\HelperController::formatTanggalIndonesia($item->tanggal, 'd F Y')
                            : '-' }}
                            <div>{{ $item->waktu }}</div>
                        </td>
                        <td>
                            <strong>{{ $item->nama_kegiatan }}</strong>
                        </td>
                        <td>
                            @php
                            // 1️⃣ Jenjang: label + warna
                            if ($item->jenjang) {
                            [$jenjangLabel, $jenjangClass] = match($item->jenjang) {
                            'caberawit' => ['Caberawit', 'text-bold'],
                            'remaja' => ['Remaja', 'text-primary'],
                            'gp' => ['GP', 'text-success'],
                            'mandiri' => ['Mandiri', 'text-danger'],
                            default => ['-', 'text-muted'],
                            };
                            } else {
                            [$jenjangLabel, $jenjangClass] = ['Semua Jenjang', 'text-muted'];
                            }

                            // 2️⃣ Lokasi sesuai scope
                            if ($item->scope === 'kelompok' && $item->ms_kelompok) {
                            $lokasiLabel = "Kelompok ". $item->ms_kelompok->nama_kelompok;

                            } elseif ($item->scope === 'desa' && $item->ms_desa) {
                            $lokasiLabel = " Desa {$item->ms_desa->nama_desa}";

                            } elseif ($item->scope === 'daerah') {
                            $lokasiLabel = " Daerah Solo Selatan";

                            } else {
                            $lokasiLabel = '-';
                            }
                            @endphp

                            {{-- FORMAT AKHIR --}}
                            <strong class="{{ $jenjangClass }}">
                                {{ $jenjangLabel }}
                            </strong>
                            <div class="text-bold">{{ $lokasiLabel }}</div>
                        </td>

                        <td>
                            @if($item->scope === 'daerah')
                            <strong>Kegiatan Daerah</strong>
                            {{-- <div class="text-bold">Solo Selatan</div> --}}
                            @elseif($item->scope === 'desa')
                            <strong>Kegiatan Desa</strong>
                            {{-- <div class="text-bold">{{ $item->ms_desa->nama_desa ?? '-' }}</div> --}}
                            @elseif($item->scope === 'kelompok')
                            <strong>Kegiatan Kelompok</strong>
                            {{-- <div class="text-bold">{{ $item->ms_kelompok->nama_kelompok ?? '-' }}</div> --}}
                            @endif
                        </td>
                        <td>
                            <strong>{{ $item->targetPeserta() }} Peserta</strong>
                        </td>
                        <td class="fw-semibold text-primary">
                            {{ $item->totalHadir() }} Peserta
                        </td>

                        <td class="fw-semibold text-body">
                            {{ $item->totalIzin() }} Peserta
                        </td>

                        <td class="fw-semibold text-danger">
                            {{ $item->totalAlfa() }} Peserta
                        </td>
                        <td class="fw-semibold text-primary fs-14">
                            {{ $item->presentaseHadir() }} %
                        </td>

                        <td class="fw-semibold">
                            {{-- 2️⃣ Tombol CRUD --}}
                            <div class="hstack gap-2 justify-content-center">
                                {{-- Detail --}}
                                <a href="#ModalDetailKegiatan" data-bs-toggle="modal"
                                    class="text-primary d-inline-block" title="Detail Kegiatan"
                                    wire:click.prevent="$emit('KegiatanDetail', {{ $item->ms_kegiatan_id }})">
                                    <i class="ri-eye-line fs-17 align-middle"></i> Detail
                                </a>

                                {{-- Laporan --}}
                                <a href="javascript:void(0)" class="text-success d-inline-block"
                                    title="Laporan Kehadiran" data-bs-toggle="offcanvas"
                                    data-bs-target="#offcanvasLaporan" aria-controls="offcanvasLaporan"
                                    wire:click.prevent="$emit('KegiatanReport', {{ $item->ms_kegiatan_id }})">
                                    <i class="ri-file-chart-line fs-17 align-middle"></i> Laporan
                                </a>
                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            Belum ada data kegiatan
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        <div class="mt-3">
            {{ $data->links() }}
        </div>

    </div>

    {{-- MODAL --}}
    <div class="modal fade zoomIn" id="ExportLaporanExcel" tabindex="-1" aria-labelledby="exportRecordLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-5 text-center">
                    <lord-icon src="https://cdn.lordicon.com/fjvfsqea.json" trigger="loop"
                        colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px"></lord-icon>
                    <div class="mt-4 text-center">
                        <h4 class="fs-semibold">Konfirmasi Export</h4>
                        <p class="text-muted fs-14 mb-4 pt-1">
                            Apakah Anda yakin ingin mengekspor laporan Kegiatan Generus? Data yang diekspor akan
                            sesuai dengan tabel yang ditampilkan.
                        </p>
                        <div class="hstack gap-2 justify-content-center remove">
                            <button class="btn btn-link link-success fw-medium text-decoration-none shadow-none"
                                data-bs-dismiss="modal">
                                <i class="ri-close-line me-1 align-middle"></i> Batal
                            </button>
                            <button class="btn btn-primary" id="konfirmasiExportLaporan" data-bs-dismiss="modal">Ya,
                                Export!</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('konfirmasiExportLaporan').addEventListener('click', function () {
                alertify.success("Menyiapkan Dokumen");
    
                setTimeout(function () {
                    var table = document.getElementById("Laporan");
    
                    var data = [];
                    // Kolom yang ingin diexport 
                    var exportCols = [0,1,2,3,4,5];
    
                    // Ambil header
                    var headers = [];
                    for(var i=0; i<exportCols.length; i++){
                        headers.push(table.tHead.rows[0].cells[exportCols[i]].innerText.trim());
                    }
                    data.push(headers);
    
                    // Ambil data tbody
                    for(var i=0; i<table.tBodies[0].rows.length; i++){
                        var row = table.tBodies[0].rows[i];
                        var rowData = [];
                        for(var j=0; j<exportCols.length; j++){
                            rowData.push(row.cells[exportCols[j]].innerText.trim());
                        }
                        data.push(rowData);
                    }
    
                    // Ambil data tfoot (jika ada)
                    if(table.tFoot){
                        for(var i=0; i<table.tFoot.rows.length; i++){
                            var row = table.tFoot.rows[i];
                            var rowData = [];
                            for(var j=0; j<exportCols.length; j++){
                                rowData.push(row.cells[exportCols[j]].innerText.trim());
                            }
                            data.push(rowData);
                        }
                    }
    
                    // Buat workbook
                    var wb = XLSX.utils.book_new();
                    var ws = XLSX.utils.aoa_to_sheet(data);
                    XLSX.utils.book_append_sheet(wb, ws, "Sheet1");
    
                    XLSX.writeFile(wb, "Laporan-Kegiatan-Generus.xlsx");
    
                }, 1000);
            });
    
    </script>
</div>