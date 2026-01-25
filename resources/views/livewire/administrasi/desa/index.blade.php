<div class="">
    <div class="row g-3 mb-3">
        <div class="col-xxl-8 col-sm-6">
            <label class="form-label">Pencarian Desa</label>
            <div class="search-box">
                <input type="text" class="form-control search" wire:model.debounce.300ms="search"
                    placeholder="Cari nama desa, deskripsi, atau lainnya...">
                <i class="ri-search-line search-icon"></i>
            </div>
        </div>
        <div class="col-xxl-4 col-sm-6">
            <label class="form-label d-none d-sm-block">&nbsp;</label>
            <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#ModalDesaCreate"
                wire:click="$emit('DesaCreate')">
                <i class="ri-add-fill me-1 align-bottom"></i> Desa
            </button>
        </div>
    </div>

    <div class="col-xl-12">
        <div class="mt-4">
            <div class="live-preview">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover nowrap align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="text-uppercase text-center">No</th>
                                <th class="text-uppercase">Desa</th>
                                <th class="text-uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $index => $kat)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="ri-government-fill fs-1 text-primary me-2"></i>
                                        <div>
                                            <h5 class="fs-13 mb-0">{{ $kat->nama_desa }}</h5>
                                            <p class="fs-12 mb-0 text-muted">{{ $kat->nama_masjid ?? '-' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="#ModalDetailDesa" data-bs-toggle="modal"
                                        class="text-secondary d-inline-block detail-item-btn"
                                        title="Detail Desa"
                                        wire:click.prevent="$emit('detailDesa', {{ $kat->ms_desa_id }})">
                                        <i class="ri-eye-line fs-17 align-middle"></i> Detail
                                    </a>
                                            
                                    <a href="#ModalEditDesa" data-bs-toggle="modal" class="text-warning d-inline-block detail-item-btn ms-1"
                                        title="Edit Desa" wire:click.prevent="$emit('loadDataDesa', {{ $kat->ms_desa_id }})">
                                        <i class="ri-mark-pen-line fs-17 align-middle"></i> Edit
                                    </a>
                                    
                                    <!-- Hapus Desa -->
                                    <a href="#ModalDeleteDesa" data-bs-toggle="modal" class="text-danger d-inline-block detail-item-btn ms-1"
                                        title="Hapus Desa" wire:click.prevent="$emit('DesaDelete', {{ $kat->ms_desa_id }})">
                                        <i class="ri-delete-bin-5-line fs-17 align-middle"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">Tidak ada data Desa</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>