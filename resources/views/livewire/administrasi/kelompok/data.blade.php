@forelse($listKelompok as $item)
<div class="col-xxl-4 col-lg-6">
    <div class="card shadow-sm border mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0 text-truncate" style="max-width: 70%">
                Kelompok {{ $item->nama_kelompok }}
            </h5>
        
            <div class="hstack gap-2">
        
                {{-- Tombol Detail --}}
                <a href="#ModalDetailKelompok" data-bs-toggle="modal" class="text-primary d-inline-block"
                    title="Detail Kelompok" wire:click.prevent="$emit('KelompokDetail', {{ $item->ms_kelompok_id }})">
                    <i class="ri-eye-line fs-17 align-middle"></i>
                </a>
        
                {{-- Tombol Edit --}}
                <a href="#ModalEditKelompok" data-bs-toggle="modal" class="text-warning d-inline-block" title="Edit Kelompok"
                    wire:click.prevent="$emit('KelompokEdit', {{ $item->ms_kelompok_id }})">
                    <i class="ri-mark-pen-line fs-17 align-middle"></i>
                </a>
        
                {{-- Tombol Hapus --}}
                <a href="#ModalDeleteKelompok" data-bs-toggle="modal" class="text-danger d-inline-block" title="Hapus Kelompok"
                    wire:click.prevent="$emit('KelompokDelete', {{ $item->ms_kelompok_id }})">
                    <i class="ri-delete-bin-5-line fs-17 align-middle"></i>
                </a>
        
            </div>
        </div>
        <div class="card-body">
            <div class="d-flex">
                <div class="flex-grow-1">
                    <div class="hstack gap-3 flex-wrap text-muted fs-12">
                        <div>
                            <i class="ri-building-2-line text-success me-1"></i>
                            <span class="text-body fw-medium">
                                {{ $item->nama_masjid ?? '-' }}
                            </span>
                        </div>
            
                        <div class="vr d-none d-md-block"></div>
                        <div>
                            <i class="ri-government-line text-primary me-1"></i>
                            <span class="text-body fw-medium">
                                Update {{ $item->updated_at?->format('d M Y') ?? '-' }}
                            </span>
                        </div>
        
                    </div>
                </div>
            </div>
            
            {{-- Address --}}
            <div class="mt-2">
                {{-- <i class="ri-map-pin-user-line text-warning me-1"></i> --}}
                <span class="text-body fw-medium d-inline-block text-truncate" style="max-width: 100%;" data-bs-toggle="tooltip"
                    title="{{ $item->alamat ?? '-' }}">
                    {{ $item->alamat ?? '-' }}
                </span>
            </div>
            
            {{-- 3 Box Info --}}
            <div class="row mt-4">
                <div class="col-lg-4 col-sm-6">
                    <div class="p-2 border border-dashed rounded">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm me-2">
                                <div class="avatar-title rounded bg-transparent text-secondary fs-24">
                                    <i class="ri-group-fill"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted mb-1">Generus :</p>
                                <h5 class="mb-0 fs-14">
                                    {{ $item->jumlah_generus() ?? 0 }}
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="col-lg-4 col-sm-6">
                    <div class="p-2 border border-dashed rounded">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm me-2">
                                <div class="avatar-title rounded bg-transparent text-secondary fs-24">
                                    <i class="ri-government-fill"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted mb-1">Desa :</p>
                                <h5 class="mb-0 fs-14">
                                    {{ $item->ms_desa->nama_desa ?? '-' }}
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="col-lg-4 col-sm-6">
                    <div class="p-2 border border-dashed rounded">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm me-2">
                                <div class="avatar-title rounded bg-transparent text-secondary fs-24">
                                    <i class="ri-map-pin-2-fill"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted mb-1">Peta :</p>
                                <h5 class="mb-0 fs-14">
                                    @if($item->peta)
                                    <a href="{{ $item->peta }}" target="_blank" class="text-primary">
                                        Lihat Lokasi
                                    </a>
                                    @else
                                    -
                                    @endif
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@empty
<div class="col-12 text-center text-muted py-5">
    Tidak ada data kelompok
</div>
@endforelse