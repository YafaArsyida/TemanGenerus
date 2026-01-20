<div wire:ignore.self class="modal fade" id="ModalDetailDesa" tabindex="-1" aria-labelledby="ModalDetailDesaLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-light p-3">
                <h5 class="modal-title fw-bold" id="ModalDetailDesaLabel">
                    Detail Desa
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                @if($desa)
                <div class="card border shadow-sm mb-0">
                    <div class="card-body">

                        <div class="d-flex">
                            <div class="flex-grow-1">

                                <h4 class="fw-bold mb-2 text-truncate">
                                    {{ $desa->nama_desa }}
                                </h4>

                                <div class="hstack gap-3 text-muted fs-13 flex-wrap">

                                    <div>
                                        <i class="ri-building-2-line text-success me-1"></i>
                                        <span class="text-body fw-medium">
                                            {{ $desa->nama_masjid ?? '-' }}
                                        </span>
                                    </div>

                                    <div class="vr d-none d-md-block"></div>

                                    <div>
                                        <i class="ri-government-line text-primary me-1"></i>
                                        <span class="text-body fw-medium">
                                            Update {{ $desa->updated_at?->format('d M Y') ?? '-' }}
                                        </span>
                                    </div>

                                </div>

                            </div>
                        </div>

                        {{-- Alamat --}}
                        <div class="mt-2">
                            <span class="text-body fw-medium d-inline-block text-truncate" style="max-width: 100%;"
                                data-bs-toggle="tooltip" title="{{ $desa->alamat ?? '-' }}">
                                {{ $desa->alamat ?? '-' }}
                            </span>
                        </div>

                        {{-- 3 Info Box --}}
                        <div class="row mt-4">

                            <div class="col-lg-4 col-sm-6">
                                <div class="p-2 border border-dashed rounded">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-2">
                                            <div class="avatar-title rounded bg-transparent text-secondary fs-24">
                                                <i class="ri-group-fill"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="text-muted mb-1">Jumlah Kelompok :</p>
                                            <h5 class="mb-0 fs-16">
                                                {{ $desa->ms_kelompok_count ?? 0 }}
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
                                                <i class="ri-file-text-line"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="text-muted mb-1">Deskripsi :</p>
                                            <h5 class="mb-0 fs-16 text-truncate" style="max-width:180px"
                                                title="{{ $desa->deskripsi ?? '-' }}">
                                                {{ $desa->deskripsi ?? '-' }}
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
                                        <div>
                                            <p class="text-muted mb-1">Peta :</p>
                                            <h5 class="mb-0 fs-16">
                                                @if($desa->peta)
                                                <a href="{{ $desa->peta }}" target="_blank" class="text-primary">
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
                @endif

            </div>

            <div class="modal-footer">
                <a href="javascript:void(0);" class="btn btn-link link-success shadow-none fw-medium" data-bs-dismiss="modal">
                    <i class="ri-close-line me-1"></i> Tutup
                </a>
            </div>

        </div>
    </div>

</div>