<div class="card border-0 shadow-sm rounded-4 overflow-hidden" id="kegiatanGenerusList">
    {{-- HEADER --}}
    <div class="card-header bg-white border-0 p-4">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-4">
            {{-- TITLE --}}
            <div>
                <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="avatar-sm">
                        <div class="avatar-title bg-primary-subtle text-primary rounded-circle fs-20">
                            <i class="ri-team-line"></i>
                        </div>
                    </div>
    
                    <div>
                        <h4 class="fw-bold mb-1">
                            Kegiatan Generasi Penerus
                        </h4>
                        <p class="text-muted mb-0 fs-13">
                            Kelola data kegiatan generus sesuai jenjang usia
                        </p>
                    </div>
                </div>
            </div>
    
            {{-- ACTION --}}
            <div class="d-flex gap-2 flex-wrap">
                {{-- IMPORT --}}
                <button type="button" class="btn btn-light border rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#ExportLaporanExcel">
                    <i class="ri-database-2-line me-1 text-secondary"></i>
                    Export Data
                </button>
    
                {{-- TAMBAH --}}
                <button type="button" class="btn btn-success rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#ModalKegiatanCreate"
                        wire:click.prevent="$emit('KegiatanCreate', {{ $ms_desa_id }})">
                    <i class="ri-add-line me-1"></i>Tambah Kegiatan
                </button>
            </div>
        </div>
    </div>

    {{-- FILTER --}}
    <div class="card-body border-top border-bottom bg-light-subtle">
        <div class="row g-3">
            {{-- SEARCH --}}
            <div class="col-xxl-3 col-md-6">
                <label class="form-label fw-semibold">
                    Cari Kegiatan
                </label>
                <div class="search-box">
                    <input type="text" class="form-control" placeholder="Cari nama kegiatan..." wire:model.debounce.500ms="search">
                    <i class="ri-search-line search-icon"></i>
                </div>
            </div>

            {{-- TIPE --}}
            <div class="col-xxl-2 col-md-6">
                <label class="form-label fw-semibold">
                    Tipe Kegiatan
                </label>
                <select class="form-select" wire:model="tipeKegiatan">
                    <option value="">Semua Kegiatan</option>
                    <option value="rutin">Kegiatan Rutin</option>
                    <option value="sekali">Event / Sekali</option>
                </select>
            </div>

            {{-- KELOMPOK --}}
            <div class="col-xxl-2 col-md-6">
                <label class="form-label fw-semibold">
                    Kelompok
                </label>

                <select class="form-select" wire:model="ms_kelompok_id">
                    <option value="">Semua Kelompok</option>
                    @foreach($listKelompok as $k)
                    <option value="{{ $k->ms_kelompok_id }}">
                        {{ $k->nama_kelompok }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- JENJANG --}}
            <div class="col-xxl-2 col-md-6">
                <label class="form-label fw-semibold">
                    Jenjang Usia
                </label>
                <select class="form-select" wire:model="jenjangUsia">
                    <option value="">Semua Jenjang</option>
                    <option value="caberawit">Caberawit</option>
                    <option value="remaja">Remaja</option>
                    <option value="gp">GP</option>
                    {{-- <option value="pra_nikah">Pra Nikah</option> --}}
                    <option value="mandiri">Mandiri</option>
                </select>
            </div>

            {{-- SCOPE --}}
            <div class="col-xxl-1 col-md-6">
                <label class="form-label fw-semibold">Tingkat</label>
                <select class="form-select" wire:model="scope">
                    <option value="">Semua</option>
                    <option value="daerah">Daerah</option>
                    <option value="desa">Desa</option>
                    <option value="kelompok">Kelompok</option>
                </select>
            </div>

            {{-- PERIODE --}}
            <div class="col-xxl-2 col-md-6">
                <label class="form-label fw-semibold">Periode</label>
                <div class="input-group">
                    <input type="date" class="form-control" wire:model="startDate">
                    <input type="date" class="form-control" wire:model="endDate">
                    <button type="button" class="btn btn-light border" wire:click="resetTanggal" title="Reset Filter">
                        <i class="ri-refresh-line"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="card-body pt-3">
        <div class="table-responsive">
            <table id="Laporan" class="table table-hover align-middle table-nowrap mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="50">#</th>
                        <th>Jadwal</th>
                        <th>Kegiatan</th>
                        <th>Peserta</th>
                        <th>Tingkat</th>
                        <th>Tempat</th>
                        <th class="text-center" width="170">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($listKegiatan as $index => $item)
                    <tr>
                        {{-- NO --}}
                        <td class="fw-semibold text-muted">
                            {{ $listKegiatan->firstItem() + $index }}
                        </td>
                        {{-- JADWAL --}}
                        <td>
                            <div class="fw-semibold text-dark">
                                @if($item->tipe_kegiatan === 'rutin')
                                    <i class="ri-repeat-line text-primary me-1"></i>
                                    {{ $item->hari_label ?: 'Jadwal Mingguan' }}
                                @else
                                    <i class="ri-calendar-event-line text-danger me-1"></i>
                                    {{ $item->tanggal ? \App\Http\Controllers\HelperController::formatTanggalIndonesia($item->tanggal, 'd F Y') : '-' }}
                                @endif
                            </div>
                            <div class="text-muted fs-12">
                                <i class="ri-time-line me-1"></i>
                                {{ $item->waktu }}
                            </div>
                        </td>
                        {{-- KEGIATAN --}}
                        <td>
                            <div class="fw-semibold">{{ $item->nama_kegiatan }}</div>
                            <div class="mt-1">
                                @if($item->tipe_kegiatan === 'rutin')
                                <span class="badge bg-primary-subtle text-primary">
                                    Rutin
                                </span>
                                @else
                                <span class="badge bg-danger-subtle text-danger">
                                    Event
                                </span>
                                @endif
                            </div>
                        </td>

                        {{-- PESERTA --}}
                        <td>
                            @php
                            if ($item->jenjang) {
                                [$jenjangLabel, $jenjangClass] = match($item->jenjang) {
                                    'caberawit' => ['Caberawit', 'primary'],
                                    'remaja' => ['Remaja', 'success'],
                                    'gp' => ['GP', 'info'],
                                    'mandiri' => ['Mandiri', 'danger'],
                                    default => ['-', 'secondary'],
                                };
                            } else {
                                [$jenjangLabel, $jenjangClass] = ['Semua Jenjang', 'secondary'];
                            }

                            @endphp
                            <span class="badge bg-{{ $jenjangClass }}-subtle text-{{ $jenjangClass }}">
                                {{ $jenjangLabel }}
                            </span>
                            <div class="text-muted fs-12 mt-1">
                                @if($item->scope === 'kelompok')
                                    Kelompok {{ $item->ms_kelompok->nama_kelompok ?? '-' }}
                                @elseif($item->scope === 'desa')
                                    Desa {{ $item->ms_desa->nama_desa ?? '-' }}
                                @else
                                    Daerah Eragen Barat
                                @endif
                            </div>
                        </td>

                        {{-- TINGKAT --}}
                        <td>
                            @if($item->scope === 'daerah')
                            <span class="badge bg-danger-subtle text-danger">
                                Daerah
                            </span>
                            @elseif($item->scope === 'desa')
                            <span class="badge bg-success-subtle text-success">
                                Desa
                            </span>
                            @else
                            <span class="badge bg-primary-subtle text-primary">
                                Kelompok
                            </span>
                            @endif
                        </td>

                        {{-- TEMPAT --}}
                        <td>
                            @php $lokasi = $item->lokasi_final; @endphp
                            <div class="fw-semibold text-truncate" style="max-width: 220px;" title="{{ $lokasi['tempat'] }}">
                                <i class="ri-map-pin-line text-danger me-1"></i>
                                {{ $lokasi['tempat'] }}
                            </div>
                        </td>

                        {{-- AKSI --}}
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                {{-- DETAIL --}}
                                <a href="#ModalDetailKegiatan" data-bs-toggle="modal" class="btn btn-light btn-sm" title="Detail" wire:click.prevent="$emit('KegiatanDetail', {{ $item->ms_kegiatan_id }})">
                                    <i class="ri-eye-line text-primary"></i>
                                </a>

                                {{-- EDIT --}}
                                <a href="#ModalEditKegiatan" data-bs-toggle="modal" class="btn btn-light btn-sm" title="Edit" wire:click.prevent="$emit('KegiatanEdit', {{ $item->ms_kegiatan_id }}, {{ $ms_desa_id }})">
                                    <i class="ri-pencil-line text-warning"></i>
                                </a>

                                {{-- DELETE --}}
                                <a href="#ModalDeleteKegiatan" data-bs-toggle="modal" class="btn btn-light btn-sm" title="Hapus" wire:click.prevent="$emit('KegiatanDelete', {{ $item->ms_kegiatan_id }})">
                                    <i class="ri-delete-bin-5-line text-danger"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="d-flex flex-column align-items-center">
                                <div class="avatar-md mb-3">
                                    <div class="avatar-title bg-light text-muted rounded-circle fs-2">
                                        <i class="ri-calendar-event-line"></i>
                                    </div>
                                </div>
                                <h6 class="fw-semibold mb-1">
                                    Belum Ada Data Kegiatan
                                </h6>
                                <p class="text-muted mb-0 fs-13">
                                    Data kegiatan generus akan tampil di sini
                                </p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="mt-4">
            {{ $listKegiatan->links() }}
        </div>

    </div>
    {{-- MODAL EXPORT --}}
    <div class="modal fade" id="ExportLaporanExcel" tabindex="-1" aria-labelledby="exportRecordLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                {{-- HEADER --}}
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn btn-light btn-icon rounded-circle ms-auto" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ri-close-line fs-18"></i>
                    </button>
                </div>
    
                {{-- BODY --}}
                <div class="modal-body px-4 pb-5 pt-2 text-center">
                    {{-- ICON --}}
                    <div class="mb-4">
                        <div class="avatar-xl mx-auto">
                            <div class="avatar-title bg-success-subtle text-success rounded-circle">
                                <lord-icon src="https://cdn.lordicon.com/fjvfsqea.json" trigger="loop"
                                    colors="primary:#198754,secondary:#198754" style="width:70px;height:70px">
                                </lord-icon>
                            </div>
                        </div>
                    </div>
                    {{-- TITLE --}}
                    <div class="mb-2">
                        <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill mb-3">
                            Export Laporan
                        </span>
                        <h3 class="fw-bold mb-2" id="exportRecordLabel">
                            Export Data Kegiatan?
                        </h3>
    
                        <p class="text-muted mb-0 lh-lg px-lg-4">
                            Laporan kegiatan generus akan diekspor sesuai
                            filter dan data tabel yang sedang ditampilkan.
                        </p>
                    </div>
    
                    {{-- INFO --}}
                    <div class="alert alert-light border rounded-4 text-start mt-4 mb-0">
                        <div class="d-flex align-items-start gap-3">
                            <div class="flex-shrink-0">
                                <i class="ri-information-line text-primary fs-20"></i>
                            </div>
                            <div>
                                <h6 class="fw-semibold mb-1">
                                    Informasi Export
                                </h6>
    
                                <p class="text-muted mb-0 fs-13">
                                    File akan diunduh dalam format Excel (.xlsx)
                                    dan hanya mencakup data yang tampil pada tabel.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- FOOTER --}}
                <div class="modal-footer border-0 pt-0 px-4 pb-4 justify-content-center">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">
                        <i class="ri-close-line me-1"></i>
                        Batal
                    </button>
    
                    <button type="button" class="btn btn-success rounded-pill px-4" id="konfirmasiExportLaporan"
                        data-bs-dismiss="modal">
                        <i class="ri-file-excel-2-line me-1"></i>
                        Ya, Export
                    </button>
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