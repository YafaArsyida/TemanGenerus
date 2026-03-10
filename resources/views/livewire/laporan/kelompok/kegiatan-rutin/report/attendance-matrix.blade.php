<div class="card h-100">

    {{-- HEADER --}}
    <div class="card-header border-0 d-flex align-items-center">
        <h5 class="card-title mb-0 flex-grow-1">
            Presensi Kehadiran Generus {{ $nama_kelompok }}
        </h5>

        <div class="flex-shrink-0 d-flex gap-2 flex-wrap">
            <button class="btn btn-soft-success">
                <i class="ri-file-excel-2-line"></i> Export
            </button>
        </div>
    </div>

    {{-- BODY --}}
    <div class="card-body">
        {{-- FILTER --}}
        <div class="row g-3 mb-3">

            {{-- Search --}}
            <div class="col-xxl-5 col-sm-6">
                <label class="form-label fw-semibold">Cari Nama Generus</label>
                <input type="text" class="form-control" placeholder="Cari nama kegiatan..." wire:model.debounce.500ms="search">
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


            {{-- Periode --}}
            <div class="col-xxl-4 col-sm-12">
                <label class="form-label fw-semibold">Periode</label>
                <div class="d-flex align-items-center gap-2">
                    <input type="date" id="startDate" class="form-control" wire:model.lazy="startDate" value="{{ $startDate }}">
                    <span class="text-muted">–</span>
                    <input type="date" id="endDate" class="form-control" wire:model.lazy="endDate" value="{{ $endDate }}">
                    <div class="col-auto">
                        <button type="button" class="btn btn-soft-secondary btn-icon rounded-circle" wire:click="resetTanggal"
                            title="Reset Tanggal">
                            <i class="ri-refresh-line fs-16"></i>
                        </button>
                    </div>
                </div>
            </div>

        </div>


        {{-- TABLE MATRIX --}}
        <div class="table-responsive">

            <table class="table table-bordered table-striped align-middle">

                <thead class="table-light">
                    <tr>
                        <th style="width:60px">#</th>
                        <th class="text-start" style="min-width:220px">
                            Nama Generus
                        </th>
                        <th style="min-width:140px">Kelompok</th>
                        @foreach($tanggalMatrix as $tgl)
                        <th class="text-center" style="min-width:90px">
                            {{ \App\Http\Controllers\HelperController::formatTanggalIndonesia($tgl, 'l') }}
                            <div class="small text-muted">
                                {{ \App\Http\Controllers\HelperController::formatTanggalIndonesia($tgl, 'd F Y') }}
                            </div>
                        </th>
                        @endforeach
                    </tr>
                </thead>    
                <tbody>
                
                    @forelse($generusList as $i => $g)
                
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td class="fw-semibold">
                            {{ $g->nama_generus }}
                        </td>
                
                        <td>
                            {{ $g->ms_kelompok->nama_kelompok ?? '-' }}
                        </td>
                
                        @foreach($tanggalMatrix as $tgl)
                
                        @php
                        $status = $this->status($g->ms_generus_id, $tgl);
                        @endphp
                
                        <td class="text-center">
                
                            @if($status == 'hadir')
                            <span class="badge bg-success">H</span>
                
                            @elseif($status == 'izin')
                            <span class="badge bg-warning">I</span>
                
                            @else
                            <span class="badge bg-danger">A</span>
                            @endif
                        </td>
                        @endforeach
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ 3 + count($tanggalMatrix) }}" class="text-center text-muted">
                            Tidak ada data generus
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

        </div>


        {{-- LEGEND --}}
        <div class="mt-3 d-flex gap-3 flex-wrap">
            <span class="badge bg-success">H</span> Hadir
            <span class="badge bg-warning">I</span> Izin
            <span class="badge bg-danger">A</span> Alfa
        </div>

    </div>

</div>