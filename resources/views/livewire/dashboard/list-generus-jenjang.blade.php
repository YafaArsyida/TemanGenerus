<div class="card card-height-100">
    <div class="card-header align-items-center d-flex">
        <h4 class="card-title mb-0 flex-grow-1">
            Data Generus
        </h4>
    </div>
    <!-- Search & Filter -->
    <div class="card-body">
        <div class="row g-3 mb-3">
    
            {{-- Search --}}
            <div class="col-xxl-6 col-sm-12">
                <label class="form-label fw-semibold">Cari Nama Generus</label>
                <div class="search-box">
                    <input type="text" class="form-control" wire:model.debounce.400ms="search"
                        placeholder="Ketik nama generus...">
                    <i class="ri-search-line search-icon"></i>
                </div>
            </div>
    
            {{-- Jenjang Usia --}}
            <div class="col-xxl-6 col-sm-12">
                <label class="form-label fw-semibold">Jenjang Usia</label>
                <select class="form-select" wire:model="jenjangUsia">
                    <option value="">Semua Jenjang Usia</option>
                    <option value="caberawit">Caberawit (&lt; 12 Tahun)</option>
                    <option value="remaja">Remaja (12 – 30 Tahun)</option>
                    <option value="gp">GP (12 – 23 Tahun)</option>
                    <option value="pra_nikah">Pra Nikah (19 – 23 Tahun)</option>
                    <option value="mandiri">Mandiri (&gt; 23 Tahun)</option>
                </select>
            </div>
    
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle table-nowrap mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="50px">No</th>
                        <th>Nama</th>
                        <th>Kelompok</th>
                        <th class="text-center">Usia</th>
                    </tr>
                </thead>
        
                <tbody>
                    @forelse ($data as $index => $item)
                    <tr>
                        <td>{{ $data->firstItem() + $index }}</td>
        
                        <td>
                            <span class="fw-medium">
                                {{ $item->nama_generus }}
                            </span>
                        </td>
        
                        <td>
                            {{ $item->ms_kelompok->nama_kelompok ?? '-' }}
                        </td>
        
                        <td>
                            <i class="ri-calendar-line text-primary me-1 align-bottom"></i>
                            @if($item->usia)
                            {{ $item->usia }} Tahun
                            @else
                            -
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">
                            Tidak ada data generus
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="mt-3 d-flex justify-content-end">
            {{ $data->links() }}
        </div>
    </div>
</div>