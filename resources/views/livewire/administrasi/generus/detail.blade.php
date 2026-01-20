<div wire:ignore.self class="modal fade" id="ModalDetailGenerus" tabindex="-1" aria-labelledby="ModalDetailGenerusLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-light p-3">
                <h5 class="modal-title fw-bold" id="ModalDetailGenerusLabel">
                    Detail Generus
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                @if($generus)
                <div class="card border shadow-sm mb-0">
                    <div class="card-body">

                        <h4 class="fw-bold mb-2 text-truncate">
                            {{ $generus->nama_generus }}
                        </h4>

                        <p class="mb-2">
                            {{ $generus->deskripsi ?? '-' }}
                        </p>

                        {{-- Info Bar --}}
                        <div class="hstack gap-3 text-muted fs-13 flex-wrap">

                            <div>
                                <i class="ri-team-line text-success me-1"></i>
                                <span class="text-body fw-medium">
                                    {{ $generus->ms_kelompok->nama_kelompok ?? '-' }}
                                </span>
                            </div>

                            <div class="vr d-none d-md-block"></div>

                            <div>
                                <i class="ri-government-line text-primary me-1"></i>
                                <span class="text-body fw-medium">
                                    {{ $generus->ms_kelompok->ms_desa->nama_desa ?? '-' }}
                                </span>
                            </div>

                            <div class="vr d-none d-md-block"></div>

                            <div>
                                <i class="ri-time-line me-1 text-warning"></i>
                                Update:
                                <span class="text-body fw-medium">
                                    {{ $generus->updated_at?->format('d M Y') ?? '-' }}
                                </span>
                            </div>

                        </div>

                        <hr>

                        {{-- Detail --}}
                        <div class="row g-3">

                            {{-- Jenis Kelamin --}}
                            <div class="col-lg-4 col-sm-6">
                                <div class="p-2 border border-dashed rounded">
                                    <p class="text-muted mb-1">Jenis Kelamin</p>
                                    <h6 class="mb-0">
                                        {{ ucfirst($generus->jenis_kelamin) }}
                                    </h6>
                                </div>
                            </div>

                            {{-- Tempat Lahir --}}
                            <div class="col-lg-4 col-sm-6">
                                <div class="p-2 border border-dashed rounded">
                                    <p class="text-muted mb-1">Tempat Lahir</p>
                                    <h6 class="mb-0">
                                        {{ $generus->tempat_lahir ?? '-' }}
                                    </h6>
                                </div>
                            </div>

                            {{-- Tanggal Lahir + Usia --}}
                            <div class="col-lg-4 col-sm-6">
                                <div class="p-2 border border-dashed rounded">
                                    <p class="text-muted mb-1">Tanggal Lahir</p>
                                    <h6 class="mb-0">
                                        @if($generus->tanggal_lahir)
                                        {{ \Carbon\Carbon::parse($generus->tanggal_lahir)->format('d M Y') }}
                                        ({{ \Carbon\Carbon::parse($generus->tanggal_lahir)->age }} th)
                                        @else
                                        -
                                        @endif
                                    </h6>
                                </div>
                            </div>

                            {{-- Alamat --}}
                            <div class="col-lg-12">
                                <div class="p-2 border border-dashed rounded">
                                    <p class="text-muted mb-1">Alamat</p>
                                    <h6 class="mb-0">
                                        {{ $generus->alamat ?? '-' }}
                                    </h6>
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