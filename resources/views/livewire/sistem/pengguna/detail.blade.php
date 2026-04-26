<div>
    <div wire:ignore.self class="modal fade" id="ModalDetailPengguna" tabindex="-1"
        aria-labelledby="ModalDetailPenggunaLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light p-3">
                    <h5 class="modal-title fw-bold">
                        <i class="ri-eye-line me-1 text-success"></i> Detail Pengguna
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                    
                        {{-- LEFT: DATA --}}
                        <div class="col-xl-5">
                    
                            <div class="card border-0 shadow-sm h-100">
                    
                                <div class="card-header bg-info text-white">
                                    <h6 class="mb-0 text-white">Informasi Pengguna</h6>
                                </div>
                    
                                <div class="card-body">
                    
                                    <div class="mb-3">
                                        <div class="text-muted small">Nama</div>
                                        <div class="fw-semibold">{{ $nama }}</div>
                                    </div>
                    
                                    <div class="mb-3">
                                        <div class="text-muted small">Email</div>
                                        <div class="fw-semibold">{{ $email }}</div>
                                    </div>
                    
                                    <div class="mb-3">
                                        <div class="text-muted small">Telepon</div>
                                        <div class="fw-semibold text-success">{{ $telepon ?: '-' }}</div>
                                    </div>
                    
                                    <div class="mb-3">
                                        <div class="text-muted small">Peran</div>
                                        <span class="badge bg-primary text-uppercase">
                                            {{ $peran }}
                                        </span>
                                    </div>
                    
                                    <div class="mb-0">
                                        <div class="text-muted small">Tanggal Daftar</div>
                                        <div class="fw-semibold">{{ $created_at }}</div>
                                    </div>
                    
                                </div>
                            </div>
                    
                        </div>
                    
                        {{-- RIGHT: AKSES --}}
                        <div class="col-xl-7">
                    
                            <div class="card border-0 shadow-sm">
                    
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Akses Pengguna</h6>
                                    <small class="text-muted">
                                        Scope:
                                        <span class="badge bg-secondary text-uppercase">
                                            {{ $scope_type }}
                                        </span>
                                    </small>
                                </div>
                    
                                <div class="card-body">
                    
                                    {{-- DAERAH --}}
                                    @if($scope_type == 'daerah')
                                    <div class="text-muted">
                                        Pengguna memiliki akses penuh ke seluruh wilayah.
                                    </div>
                                    @endif
                    
                                    {{-- DESA / KELOMPOK --}}
                                    @if(in_array($scope_type, ['desa','kelompok']))
                    
                                    <div class="row">
                                        @foreach($aksesPengguna as $akses)
                                        <div class="col-md-6 mb-2">
                                            <div class="border rounded px-3 py-2 bg-light">
                                                {{ $akses }}
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                    
                                    @if(empty($aksesPengguna))
                                    <div class="text-muted">Tidak ada data akses</div>
                                    @endif
                    
                                    @endif
                    
                                </div>
                            </div>
                    
                        </div>
                    
                    </div>
                </div>

                <div class="modal-footer">
                    <a href="javascript:void(0);" class="btn btn-link link-success shadow-none fw-medium"
                        data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Tutup</a>
                </div>
            </div>
        </div>
    </div>
</div>