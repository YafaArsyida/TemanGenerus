<div wire:ignore.self class="modal fade" id="ModalDetailKegiatan" tabindex="-1"
    aria-labelledby="ModalDetailKegiatanLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            {{-- HEADER --}}
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title fw-bold" id="ModalDetailKegiatanLabel">
                    <i class="ri-calendar-event-line me-1 text-primary"></i>
                    Detail Kegiatan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            {{-- BODY --}}
            @if($kegiatan)
            <div class="modal-body">
                <div class="card border shadow-sm mb-0">
                    <div class="card-body">

                        {{-- TITLE --}}
                        <h4 class="fw-bold mb-1 text-truncate">
                            @if($kegiatan->tipe_kegiatan === 'rutin')
                            <i class="ri-repeat-line"></i> Rutin
                            @else
                            <i class="ri-calendar-event-line"></i>
                            @endif
                            {{ $kegiatan->nama_kegiatan }}
                        </h4>

                        {{-- DESKRIPSI --}}
                        @if($kegiatan->deskripsi)
                        <p class="mb-2 text-muted">
                            {{ $kegiatan->deskripsi }}
                        </p>
                        @endif

                        {{-- INFO BAR --}}
                        <div class="hstack gap-3 text-muted fs-13 flex-wrap">

                            {{-- Jenjang --}}
                            <div>
                                <i class="ri-group-line text-success me-1"></i>
                                <span class="text-body fw-medium">
                                    Peserta {{ ucfirst($kegiatan->jenjang ?? 'Semua Jenjang') }}
                                </span>
                            </div>

                            <div class="vr d-none d-md-block"></div>

                            {{-- Scope --}}
                            <div>
                                <i class="ri-focus-3-line text-primary me-1"></i>
                                <span class="text-body fw-medium">
                                    Kegiatan {{ ucfirst($kegiatan->scope) }}
                                </span>
                            </div>

                            <div class="vr d-none d-md-block"></div>

                            {{-- Update --}}
                            <div>
                                <i class="ri-time-line text-warning me-1"></i>
                                Update:
                                <span class="text-body fw-medium">
                                    {{ $kegiatan->updated_at?->format('d M Y') ?? '-' }}
                                </span>
                            </div>

                        </div>

                        <hr>

                        {{-- DETAIL GRID --}}
                        <div class="row g-3">

                            {{-- Tanggal / Hari Rutin --}}
                            <div class="col-lg-4 col-sm-6">
                                <div class="p-2 border border-dashed rounded">
                                    <p class="text-muted mb-1">Tanggal</p>
                                    <h6 class="mb-0">
                                        @if($kegiatan->tipe_kegiatan === 'sekali')
                                        {{ $kegiatan->tanggal
                                        ? \App\Http\Controllers\HelperController::formatTanggalIndonesia($kegiatan->tanggal, 'd F Y')
                                        : '-'
                                        }}
                                        @else
                                            @if(!empty($kegiatan->hari_rutin_label))
                                            Rutin : {{ $kegiatan->hari_rutin_label }}
                                            @endif
                                        @endif
                                    </h6>
                                </div>
                            </div>

                            {{-- Waktu --}}
                            <div class="col-lg-4 col-sm-6">
                                <div class="p-2 border border-dashed rounded">
                                    <p class="text-muted mb-1">Waktu</p>
                                    <h6 class="mb-0">
                                        {{ $kegiatan->waktu ?? '-' }}
                                    </h6>
                                </div>
                            </div>

                            {{-- Jenjang --}}
                            <div class="col-lg-4 col-sm-6">
                                <div class="p-2 border border-dashed rounded">
                                    <p class="text-muted mb-1">Jenjang</p>
                                    <h6 class="mb-0">
                                        {{ ucfirst($kegiatan->jenjang ?? 'Semua') }}
                                    </h6>
                                </div>
                            </div>

                            {{-- Lokasi Administratif --}}
                            <div class="col-lg-12">
                                <div class="p-2 border border-dashed rounded">
                                    <p class="text-muted mb-1">Target Kegiatan</p>
                                    <h6 class="mb-0">
                                        @if($kegiatan->scope === 'daerah')
                                        Daerah Solo Selatan
                                        @elseif($kegiatan->scope === 'desa')
                                        Desa {{ $kegiatan->ms_desa->nama_desa ?? '-' }}
                                        @elseif($kegiatan->scope === 'kelompok')
                                        Kelompok {{ $kegiatan->ms_kelompok->nama_kelompok ?? '-' }}
                                        <span class="text-muted">
                                            (Desa {{ $kegiatan->ms_kelompok->ms_desa->nama_desa ?? '-' }})
                                        </span>
                                        @endif
                                    </h6>
                                </div>
                            </div>

                            {{-- TEMPAT --}}
                            <div class="col-lg-6">
                                <div class="p-2 border border-dashed rounded">
                                    <p class="text-muted mb-1">Tempat</p>
                                    <h6 class="mb-0">
                                        {{ $kegiatan->lokasi_final['tempat'] ?? '-' }}
                                    </h6>
                                </div>
                            </div>

                            {{-- PETA --}}
                            @if($kegiatan->lokasi_final['peta'])
                            <div class="col-lg-6">
                                <div class="p-2 border border-dashed rounded">
                                    <p class="text-muted mb-1">Peta Lokasi</p>
                                    <a href="{{ $kegiatan->lokasi_final['peta'] }}" target="_blank" class="text-primary fw-medium">
                                        <i class="ri-map-pin-line me-1"></i>
                                        Buka di Google Maps
                                    </a>
                                </div>
                            </div>
                            @endif
                            {{-- ALAMAT --}}
                            <div class="col-lg-12">
                                <div class="p-2 border border-dashed rounded">
                                    <p class="text-muted mb-1">Alamat</p>
                                    <h6 class="mb-0">
                                        {{ $kegiatan->lokasi_final['alamat'] ?? '-' }}
                                    </h6>
                                </div>
                            </div>

                            {{-- Pengumuman --}}
                            <div class="col-lg-3 col-sm-6">
                                <div class="p-2 border border-dashed rounded">
                                    <p class="text-muted mb-1">Pengumuman</p>
                                    <a style="cursor: pointer" wire:click.prevent="kegiatanPengumuman({{ $kegiatan->ms_kegiatan_id }})"
                                        class="text-success fw-medium">
                                        <i class="mdi mdi-whatsapp me-1"></i>
                                        Cetak Pengumuman
                                    </a>
                                </div>
                            </div>
                            
                            {{-- Laporan --}}
                            <div class="col-lg-3 col-sm-6">
                                <div class="p-2 border border-dashed rounded">
                                    <p class="text-muted mb-1">Laporan</p>
                                    <a wire:click.prevent="$emit('KegiatanPengumuman', {{ $kegiatan->ms_kegiatan_id }})" class="text-danger fw-medium">
                                        <i class="mdi mdi-file-chart-outline me-1"></i>
                                        Cetak Laporan
                                    </a>
                                </div>
                            </div>
                            
                            {{-- Presensi Kartu --}}
                            <div class="col-lg-3 col-sm-6">
                                <div class="p-2 border border-dashed rounded">
                                    <p class="text-muted mb-1">Presensi Kartu</p>
                                    <a href="{{ route('operasional.presensi-kegiatan-kartu', $kegiatan->token) }}" target="_blank" 
                                        class="text-primary fw-medium">
                                        <i class="mdi mdi-qrcode me-1"></i>
                                        Presensi Kartu
                                    </a>
                                    <a type="button" class="ms-1 text-body fs-16"
                                        onclick="copyToClipboard('{{ route('operasional.presensi-kegiatan-kartu', $kegiatan->token) }}')">
                                        <i class="mdi mdi-content-copy fs-14"></i>
                                    </a>
                                </div>
                            </div>
                            
                            {{-- Presensi Manual --}}
                            <div class="col-lg-3 col-sm-6">
                                <div class="p-2 border border-dashed rounded">
                                    <p class="text-muted mb-1">Presensi Manual</p>
                                    <a href="{{ route('operasional.presensi-kegiatan', $kegiatan->token) }}" target="_blank"
                                        class="text-secondary fw-medium">
                                        <i class="mdi mdi-account-edit-outline me-1"></i>
                                        Presensi Manual
                                    </a>
                                    <a type="button" class="ms-1 text-body fs-16"
                                        onclick="copyToClipboard('{{ route('operasional.presensi-kegiatan', $kegiatan->token) }}')">
                                        <i class="mdi mdi-content-copy fs-14"></i>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        
           @endif
            {{-- FOOTER --}}
            <div class="modal-footer">
                <a href="javascript:void(0);" class="btn btn-link link-success shadow-none fw-medium"
                    data-bs-dismiss="modal">
                    <i class="ri-close-line me-1"></i> Tutup
                </a>
            </div>

        </div>
    </div>
    <script>
        function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            // Notifikasi sukses, pakai alertify kalau sudah include
            if (window.alertify) {
                alertify.success('URL berhasil dicopy!');
            } else {
                alert('URL berhasil dicopy!');
            }
        }).catch(err => {
            console.error('Gagal menyalin:', err);
            if (window.alertify) {
                alertify.error('Gagal menyalin URL');
            } else {
                alert('Gagal menyalin URL');
            }
        });
    }
    </script>
</div>