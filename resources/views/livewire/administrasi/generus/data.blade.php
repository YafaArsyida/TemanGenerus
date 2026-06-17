<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle table-nowrap mb-0">
            <thead class="table-light">
                <tr class="text-uppercase fw-semibold">
                    <th width="60" class="text-center">No</th>
                    <th class="text-center">Hapus</th>
                    <th>Generus</th>
                    <th>Kartu</th>
                    <th>Status</th>
                    <th>Kontak</th>
                    <th>Kelompok</th>
                    <th class="text-center">Usia</th>
                    <th>Jenjang</th>
                    <th>Desa</th>
                    <th width="170" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($listGenerus as $row)
                <tr>
                    <td class="text-center text-muted fw-semibold">
                        {{ ($listGenerus->currentPage() - 1) * $listGenerus->perPage() + $loop->iteration }}
                    </td>
                    <td class="text-center">
                        {{-- DELETE --}}
                        <a href="#ModalDeleteGenerus" data-bs-toggle="modal"
                            class="btn btn-soft-danger btn-sm rounded-pill px-3" title="Hapus Data Generus"
                            wire:click.prevent="$emit('GenerusDelete', {{ $row->ms_generus_id }})">
                            <i class="ri-delete-bin-5-line me-1"></i>
                            Hapus
                        </a>
                    </td>
                    {{-- NAMA --}}
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar-xs flex-shrink-0">
                                <div class="avatar-title 
                                            {{ $row->jenis_kelamin == 'perempuan'
                                            ? 'bg-danger-subtle text-danger'
                                            : 'bg-primary-subtle text-primary' 
                                            }} 
                                            rounded-circle fw-semibold">
                                    {{ strtoupper(substr($row->nama_generus, 0, 1)) }}
                                </div>
                            </div>
                            <div>
                                <div class="fw-semibold">
                                    {{ $row->nama_generus }}
                                </div>
                                <small class="text-muted">
                                    {{ strtoupper($row->jenis_kelamin) }}
                                </small>
                            </div>
                        </div>
                    </td>
                    <td>
                        {{ $row->nomor_kartu }}
                    </td>
                    <td>
                        {{ $row->status_generus }}
                    </td>
                    {{-- TELEPON --}}
                    <td>
                        @if($row->nomor_telepon)
                        <div class="d-flex align-items-center text-success">
                            <i class="ri-whatsapp-line me-2 fs-16">
                            </i>
                            <span class="fw-medium">
                                {{ $row->nomor_telepon }}
                            </span>
                        </div>
                        @else
                        <span class="text-muted">
                            -
                        </span>
                        @endif
                    </td>
                    {{-- KELOMPOK --}}
                    <td>
                        <span class="badge bg-light text-body border px-3 py-2 fw-medium">
                            <i class="ri-group-line me-1 text-primary">
                            </i>
                            {{ $row->ms_kelompok->nama_kelompok ?? '-' }}
                        </span>
                    </td>
                    {{-- USIA --}}
                    <td class="text-center">
                        @if($row->usia)
                        <div class="fw-semibold">
                            {{ $row->usia }}
                        </div>
                        <small class="text-muted">
                            Tahun
                        </small>
                        @else
                        <span class="text-muted">
                            -
                        </span>
                        @endif
                    </td>
                    {{-- JENJANG --}}
                    <td>
                        @if($row->usia)
                        <div class="d-flex flex-wrap gap-1">
                            @foreach($row->jenjang_usia as $jenjang)
                            <span class="badge bg-light text-dark border">
                                {{ ucfirst(str_replace('_', ' ', $jenjang)) }}
                            </span>
                            @endforeach
                        </div>
                        @else
                        <span class="text-muted">
                            -
                        </span>
                        @endif
                    </td>
                    {{-- DESA --}}
                    <td>
                        <div class="d-flex align-items-center text-muted">
                            <i class="ri-government-line text-primary me-2">
                            </i>
                            <span class="fw-medium text-body">
                                {{ $row->ms_kelompok->ms_desa->nama_desa ?? '-' }}
                            </span>
                        </div>
                    </td>
                    {{-- AKSI --}}
                    <td>
                        <div class="d-flex justify-content-center gap-2">
    
                            {{-- DETAIL --}}
                            <a href="#ModalDetailGenerus" data-bs-toggle="modal"
                                class="btn btn-soft-primary btn-sm rounded-pill px-3" title="Lihat Detail Generus"
                                wire:click.prevent="$emit('GenerusDetail', {{ $row->ms_generus_id }})">
                                <i class="ri-eye-line me-1"></i>
                                Detail
                            </a>
    
                            {{-- EDIT --}}
                            <a href="#ModalEditGenerus" data-bs-toggle="modal"
                                class="btn btn-primary btn-sm rounded-pill px-3" title="Edit Data Generus"
                                wire:click.prevent="$emit('GenerusEdit', {{ $row->ms_generus_id }})">
                                <i class="ri-pencil-line me-1"></i>
                                Edit
                            </a>
    
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center py-5">
                        <div class="d-flex flex-column align-items-center">
                            <div class="avatar-md mb-3">
                                <div class="avatar-title bg-light text-muted rounded-circle">
                                    <i class="ri-user-search-line fs-2">
                                    </i>
                                </div>
                            </div>
                            <h6 class="fw-semibold mb-1">
                                Tidak Ada Data Generus
                            </h6>
                            <p class="text-muted mb-0 fs-13">
                                Data generus belum tersedia atau belum ditemukan.
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
                    {{ $listGenerus->firstItem() ?? 0 }}
                </span>
                -
                <span class="fw-semibold">
                    {{ $listGenerus->lastItem() ?? 0 }}
                </span>
                dari
                <span class="fw-semibold">
                    {{ $listGenerus->total() }}
                </span>
                data Generus
            </div>
            <div>
                {{ $listGenerus->links() }}
            </div>
        </div>
    </div>
</div>