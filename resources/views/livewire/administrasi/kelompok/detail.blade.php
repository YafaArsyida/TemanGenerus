<div wire:ignore.self class="modal fade" id="ModalDetailKelompok" tabindex="-1"
    aria-labelledby="ModalDetailKelompokLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-light p-3">
                <h5 class="modal-title fw-bold" id="ModalDetailKelompokLabel">
                    Detail Kelompok
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                @if($kelompok)
                <div class="card border shadow-sm mb-0">
                    <div class="card-body">

                        <div class="d-flex">
                            <div class="flex-grow-1">

                                <h4 class="fw-bold mb-2 text-truncate">
                                    {{ $kelompok->nama_kelompok }}
                                </h4>
                                <p>
                                    {{ $kelompok->deskripsi }}
                                </p>

                                <div class="hstack gap-3 text-muted fs-13 flex-wrap">

                                    <div>
                                        <i class="ri-building-2-line text-success me-1"></i>
                                        <span class="text-body fw-medium">
                                            {{ $kelompok->nama_masjid ?? '-' }}
                                        </span>
                                    </div>

                                    <div class="vr d-none d-md-block"></div>

                                    <div>
                                        <i class="ri-government-line text-primary me-1"></i>
                                        <span class="text-body fw-medium">
                                            Update {{ $kelompok->updated_at?->format('d M Y') ?? '-' }}
                                        </span>
                                    </div>

                                </div>

                            </div>
                        </div>

                        {{-- Alamat --}}
                        <div class="mt-2">
                            <span class="text-body fw-medium d-inline-block text-truncate" style="max-width: 100%;"
                                data-bs-toggle="tooltip" title="{{ $kelompok->alamat ?? '-' }}">
                                {{ $kelompok->alamat ?? '-' }}
                            </span>
                        </div>

                        {{-- 3 Info Box --}}
                        <div class="row mt-4">

                            {{-- Generus --}}
                            <div class="col-lg-4 col-sm-6">
                                <div class="p-2 border border-dashed rounded">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-2">
                                            <div class="avatar-title rounded bg-transparent text-secondary fs-24">
                                                <i class="ri-map-pin-2-fill"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="text-muted mb-1">Generus :</p>
                                            <h5 class="mb-0 fs-14">
                                                1
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Desa --}}
                            <div class="col-lg-4 col-sm-6">
                                <div class="p-2 border border-dashed rounded">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-2">
                                            <div class="avatar-title rounded bg-transparent text-secondary fs-24">
                                                <i class="ri-file-text-line"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="text-muted mb-1">Desa :</p>
                                            <h5 class="mb-0 fs-14 text-truncate" style="max-width:180px"
                                                title="{{ $kelompok->ms_desa->nama_desa ?? '-' }}">
                                                {{ $kelompok->ms_desa->nama_desa ?? '-' }}
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Peta --}}
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
                                            <h5 class="mb-0 fs-14">
                                                @if($kelompok->peta)
                                                <a href="{{ $kelompok->peta }}" target="_blank" class="text-primary">
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
                <a href="javascript:void(0);" class="btn btn-link link-success shadow-none fw-medium"
                    data-bs-dismiss="modal">
                    <i class="ri-close-line me-1"></i> Tutup
                </a>
            </div>

        </div>
    </div>

</div>