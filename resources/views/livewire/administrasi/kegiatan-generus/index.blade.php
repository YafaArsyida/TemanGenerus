<div class="card border-0 shadow-sm rounded-4 overflow-hidden" id="kegiatanGenerusList">
    {{-- HEADER --}}
    <div class="card-header bg-white border-0 p-4">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-4">
            {{-- TITLE --}}
            <div>
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar-sm">
                        <div class="avatar-title bg-primary-subtle text-primary rounded-circle fs-20">
                            <i class="ri-calendar-event-line">
                            </i>
                        </div>
                    </div>
    
                    <div>
                        <h5 class="fw-bold mb-1">
                            Kegiatan Generasi Penerus
                        </h5>
                        <small>
                            Kelola data kegiatan generus sesuai jenjang usia
                        </small>
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
                <button type="button" class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#ModalKegiatanCreate"
                        wire:click.prevent="$emit('KegiatanCreate', {{ $ms_desa_id }})">
                    <i class="ri-add-line me-1"></i>Tambah Kegiatan
                </button>
            </div>
        </div>
    </div>

    {{-- FILTER --}}
    <div class="card-body border-top border-bottom bg-light-subtle">
        <div class="row g-3 align-items-end">
            {{-- SEARCH --}}
            <div class="col-12 col-lg-6 col-xxl-3">
                <label class="form-label fw-semibold">
                    Cari Kegiatan
                </label>
                <div class="search-box">
                    <input type="text" class="form-control" placeholder="Cari nama kegiatan..."
                        wire:model.debounce.500ms="search">
                    <i class="ri-search-line search-icon">
                    </i>
                </div>
            </div>
            {{-- TIPE --}}
            <div class="col-6 col-md-4 col-lg-3 col-xxl-2">
                <label class="form-label fw-semibold">
                    Tipe Kegiatan
                </label>
                <select class="form-select" wire:model="tipeKegiatan">
                    <option value="">
                        Semua Kegiatan
                    </option>
                    <option value="rutin">
                        Kegiatan Rutin
                    </option>
                    <option value="sekali">
                        Event / Sekali
                    </option>
                </select>
            </div>
            {{-- KELOMPOK --}}
            <div class="col-6 col-md-4 col-lg-3 col-xxl-2">
                <label class="form-label fw-semibold">
                    Kelompok
                </label>
                <select class="form-select" wire:model="ms_kelompok_id">
                    <option value="">
                        Semua Kelompok
                    </option>
                    @foreach($listKelompok as $k)
                    <option value="{{ $k->ms_kelompok_id }}">
                        {{ $k->nama_kelompok }}
                    </option>
                    @endforeach
                </select>
            </div>
            {{-- JENJANG --}}
            <div class="col-6 col-md-4 col-lg-3 col-xxl-2">
                <label class="form-label fw-semibold">
                    Jenjang Usia
                </label>
                <select class="form-select" wire:model="jenjangUsia">
                    <option value="">
                        Semua Jenjang
                    </option>
                    <option value="caberawit">
                        Caberawit
                    </option>
                    <option value="remaja">
                        Remaja
                    </option>
                    <option value="gp">
                        GP
                    </option>
                    <option value="mandiri">
                        Mandiri
                    </option>
                </select>
            </div>
            {{-- PERIODE --}}
            <div class="col-12 col-xl-8 col-xxl-3">
                <label class="form-label fw-semibold">
                    Periode
                </label>
                <div class="d-flex align-items-center gap-2">
                    <input type="date" class="form-control rounded-3" wire:model="startDate" value="{{ $startDate }}">
                    <div class="text-muted flex-shrink-0">
                        —
                    </div>
                    <input type="date" class="form-control rounded-3" wire:model="endDate" value="{{ $endDate }}">
                    <button type="button" class="btn btn-soft-secondary btn-icon rounded-circle flex-shrink-0"
                        wire:click="resetTanggal" title="Reset Tanggal">
                        <i class="ri-refresh-line">
                        </i>
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
                    <tr class="text-uppercase fw-semibold">
                        <th class="text-center" width="50">No</th>
                        <th class="text-center" width="50">Hapus</th>
                        <th>Jadwal</th>
                        <th>Kegiatan</th>
                        <th>Peserta</th>
                        <th>Level</th>
                        <th>Tempat</th>
                        <th class="text-center" width="170">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($listKegiatan as $index => $item)
                    <tr class="fw-semibold">
                        {{-- NO --}}
                        <td class="text-muted text-center">
                            {{ $listKegiatan->firstItem() + $index }}
                        </td>
                        <td class="text-center">
                            {{-- DELETE --}}
                            <a href="#ModalDeleteKegiatan" data-bs-toggle="modal" class="btn btn-soft-danger btn-sm rounded-pill px-3"
                                title="Hapus Kegiatan" wire:click.prevent="$emit('KegiatanDelete', {{ $item->ms_kegiatan_generus_id }})">
                                <i class="ri-delete-bin-5-line me-1"></i>
                                Hapus
                            </a>
                        </td>
                        {{-- JADWAL --}}
                        <td>
                            <div>
                                @if($item->tipe_kegiatan === 'rutin')
                                    <i class="ri-repeat-line text-primary me-1"></i>
                                    {{ $item->hari_label ?: 'Jadwal Mingguan' }}
                                @else
                                    <i class="ri-calendar-event-line text-danger me-1"></i>
                                    {{ $item->tanggal ? \App\Http\Controllers\HelperController::formatTanggalIndonesia($item->tanggal, 'd F Y') : '-' }}
                                @endif
                            </div>
                            <small class="text-muted">
                                <i class="ri-time-line me-1"></i>
                                {{ $item->waktu }}
                            </small>
                        </td>
                        {{-- KEGIATAN --}}
                        <td>
                            <div>{{ $item->nama_kegiatan }}</div>
                            @if($item->tipe_kegiatan === 'rutin')
                            <span class="badge bg-primary-subtle text-primary">
                                Rutin
                            </span>
                            @else
                            <span class="badge bg-danger-subtle text-danger">
                                Event
                            </span>
                            @endif
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
                                    default => ['semua jenjang', 'secondary'],
                                };
                            } else {
                                [$jenjangLabel, $jenjangClass] = ['Semua Jenjang', 'secondary'];
                            }

                            @endphp
                            <div>
                                @if($item->scope === 'kelompok')
                                    Kelompok {{ $item->ms_kelompok->nama_kelompok ?? '-' }}
                                @elseif($item->scope === 'desa')
                                    Desa {{ $item->ms_desa->nama_desa ?? '-' }}
                                @else
                                    Daerah Sragen Barat
                                @endif
                            </div>
                            <span class="badge bg-{{ $jenjangClass }}-subtle text-{{ $jenjangClass }}">
                                {{ $jenjangLabel }}
                            </span>
                        </td>

                        {{-- TINGKAT --}}
                        <td>
                            @if($item->scope === 'daerah')
                            Kegiatan Daerah
                            @elseif($item->scope === 'desa')
                            Kegiatan Desa
                            @else
                            Kegiatan Kelompok
                            @endif
                        </td>

                        {{-- TEMPAT --}}
                        <td>
                            @php $lokasi = $item->lokasi_final; @endphp
                            <i class="ri-map-pin-line text-danger me-1"></i>
                            {{ $lokasi['tempat'] }}
                        </td>

                        {{-- AKSI --}}
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                {{-- DETAIL --}}
                                <a href="#ModalDetailKegiatan" data-bs-toggle="modal" class="btn btn-soft-primary btn-sm rounded-pill px-3"
                                    title="Detail Kegiatan" wire:click.prevent="$emit('KegiatanDetail', {{ $item->ms_kegiatan_generus_id }})">
                                    <i class="ri-eye-line me-1"></i>
                                    Detail
                                </a>

                                {{-- EDIT --}}
                                <a href="#ModalEditKegiatan" data-bs-toggle="modal" class="btn btn-primary btn-sm rounded-pill px-3"
                                    title="Edit Kegiatan" wire:click.prevent="$emit('KegiatanEdit', {{ $item->ms_kegiatan_generus_id }}, {{ $ms_desa_id }})">
                                    <i class="ri-pencil-line me-1"></i>
                                    Edit
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
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
        <div class="mt-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div class="text-muted fs-13">
                    Menampilkan
                    <span class="fw-semibold">
                        {{ $listKegiatan->firstItem() ?? 0 }}
                    </span>
                    -
                    <span class="fw-semibold">
                        {{ $listKegiatan->lastItem() ?? 0 }}
                    </span>
                    dari
                    <span class="fw-semibold">
                        {{ $listKegiatan->total() }}
                    </span>
                    data Kegiatan
                </div>
                <div>
                    {{ $listKegiatan->links() }}
                </div>
            </div>
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
        window.copyToClipboard = function(text) {
            navigator.clipboard.writeText(text)
                .then(() => {
                    if (window.alertify) {
                        alertify.success('URL berhasil dicopy!');
                    } else {
                        alert('URL berhasil dicopy!');
                    }
                })
                .catch(err => {
                    console.error('Gagal menyalin:', err);

                    if (window.alertify) {
                        alertify.error('Gagal menyalin URL');
                    } else {
                        alert('Gagal menyalin URL');
                    }
                });
        }

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