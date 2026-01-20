{{-- Be like water. --}}
<div class="card">
    <div class="card-header border-0">
        <div class="d-flex align-items-center">
            <h5 class="card-title mb-0 flex-grow-1">Desa</h5>
            <div class="flex-shrink-0">
                <div class="d-flex gap-2 flex-wrap">
                    <button data-bs-toggle="modal" id="create-btn" data-bs-target="#ModalAddDesa" class="btn btn-success"><i class="ri-add-line align-bottom me-1"></i> Desa baru</button>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body border border-dashed border-end-0 border-start-0">
        <div class="row g-3">
            <div class="col-xxl-8 col-sm-12">
                <div class="search-box">
                    <input type="text" class="form-control search" wire:model.debounce.300ms="search" placeholder="cari nama, deskripsi atau lainnya...">
                    <i class="ri-search-line search-icon"></i>
                </div>
            </div>
            <div class="col-xxl-4 col-sm-12">
                <div>
                    <select wire:model="selectedStatus" style="cursor: pointer" class="form-select" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Pilih Status">
                        <option value=""> Semua</option>
                        <option value="aktif"> Aktif</option>
                        <option value="nonaktif"> Tidak Aktif</option>
                    </select>
                </div>
            </div>
        </div>
        <!--end row-->
    </div>
    <div class="card-body">
        <div class="live-preview">
            <div class="table-responsive">
                <table class="table table-hover nowrap align-middle" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th class="text-uppercase">Desa</th>
                            <th class="text-uppercase">Kelompok</th>
                            <th class="text-uppercase">keterangan</th>
                            <th class="text-uppercase">aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($desas as $item)
                        <tr>
                            <td>{{ $item->nama_desa }}</td>
                            <td>{{ $item->deskripsi }}</td>
                            <td>
                                <ul class="list-inline hstack gap-2 mb-0">
                                    <li class="list-inline-item edit" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Edit Desa">
                                        <a href="#ModalEditDesa" data-bs-toggle="modal" class="text-success d-inline-block edit-item-btn" wire:click.prevent="$emit('loadDataDesa', {{ $item->ms_desa_id }})">
                                            <i class="ri-pencil-line fs-17 align-middle"></i> Edit
                                        </a>
                                    </li>

                                    <li class="list-inline-item delete" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" title="Hapus Desa">
                                        <a href="#ModalDeleteDesa" data-bs-toggle="modal" class="text-danger d-inline-block delete-item-btn" wire:click.prevent="$emit('confirmDelete', {{ $item->ms_desa_id }})">
                                            <i class="ri-delete-bin-5-line fs-17 align-middle"></i> Hapus
                                        </a>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="noresult text-center py-3">
                                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" 
                                                colors="primary:#405189,secondary:#08a88a" 
                                                style="width:75px;height:75px"></lord-icon>
                                        <h5 class="mt-2">Maaf, Tidak Ada Data yang Ditemukan</h5>
                                        <p class="text-muted mb-0">Kami telah mencari keseluruhan data, namun tidak ditemukan hasil yang sesuai.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $desas->links() }}
            </div>
        </div>
    </div>
</div>

