<div class="row justify-content-center g-0">
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
    <div class="col-lg-6">
        <div class="p-lg-5 p-4 h-100">
            {{-- <div class="bg-overlay"></div> --}}
            <div class="position-relative h-100 d-flex align-items-center justify-content-center">
                <div class="card shadow-lg border-0" style="max-width: 520px; width: 100%;">
                    {{-- ================= HEADER ================= --}}
                    <div class="card-header bg-white border-0 pb-0">
                    
                        {{-- LOGO & IDENTITAS --}}
                        <div class="text-center mb-3">
                            <img src="{{ asset('assets/images/logo-sm.png') }}" alt="Logo" style="max-height: 80px;" class="mb-2">
                    
                            <h5 class="fw-bold mb-0">PPG Solo Selatan</h5>
                    
                            <small class="text-muted">
                                TemanGenerus
                            </small>
                        </div>
                    
                        <hr class="my-3">
                    
                        {{-- JUDUL PRESENSI --}}
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
                    
                            <div>
                                <h4 class="fw-bold mb-0">
                                    Presensi Kegiatan {{ ucfirst($kegiatan->jenjang ?? 'Semua') }}
                                </h4>
                                <small class="text-muted">
                                    {{ \App\Http\Controllers\HelperController::formatTanggalIndonesia(
                                    $kegiatan->tanggal,
                                    'd F Y'
                                    ) }}
                                    {{ $kegiatan->waktu }}
                                </small>
                            </div>
                    
                            {{-- BADGE INFO --}}
                            <div class="d-flex gap-2 flex-wrap">
                                <span class="badge bg-success-subtle text-success">
                                    {{ ucfirst($kegiatan->jenjang ?? 'Semua Jenjang') }}
                                </span>

                                <span class="badge bg-info-subtle text-info">
                                    {{ ucfirst($kegiatan->scope) }}
                                </span>
                            </div>
                    
                        </div>
                    </div>
                    
                    {{-- ================= BODY ================= --}}
                    <div class="card-body">
                    
                        {{-- TITLE --}}
                        <h5 class="fw-bold mb-1">
                            {{ $kegiatan->nama_kegiatan }}
                        </h5>
                    
                        {{-- DESKRIPSI --}}
                        @if($kegiatan->deskripsi)
                        <p class="text-muted mb-3">
                            {{ $kegiatan->deskripsi }}
                        </p>
                        @endif
                    
                        {{-- INFO BAR --}}
                        <div class="hstack gap-1 text-muted fs-13 flex-wrap mb-3">
                    
                            <div>
                                <i class="ri-group-line text-success me-1"></i>
                                <span class="fw-medium text-body">
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
                                </span>
                            </div>
                    
                            <div class="vr d-none d-md-block"></div>
                    
                            <div>
                                <i class="ri-map-pin-line text-primary me-1"></i>
                                <span class="fw-medium text-body">
                                    {{ $kegiatan->lokasi_final['tempat'] ?? '-' }}
                                </span>
                            </div>
                        </div>
                    
                        {{-- ================= RFID SCAN ZONE ================= --}}
                        <div class="bg-light rounded p-4 border">
                    
                            <label class="fw-semibold fs-5 mb-2">
                                Silakan Scan Kartu RFID
                            </label>
                    
                            <div class="input-group input-group-lg shadow-sm">
                                <span class="input-group-text bg-primary text-white border-primary">
                                    <i class="ri-barcode-line fs-4"></i>
                                </span>
                            
                               <input id="barcodeInput" type="text" wire:model.lazy="barcodeInput" wire:keydown.enter="scanDariBarcode"
                                class="form-control border-primary" placeholder="Scan / ketik kode kartu..." autofocus>
                            </div>
                            
                            <small class="text-muted d-block mt-2">
                                Sistem akan otomatis menentukan Waktu
                                <strong>Hadir</strong>
                            </small>
                    
                            <h4 class="mt-3 fw-bold text-center">
                                <i class="ri-time-line me-1"></i>
                                <span id="live-clock">--:--</span>
                            </h4>
                    
                        </div>
                    
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="p-lg-5 p-4 h-100">
            <div class="card shadow-sm h-100">

                <!-- HEADER -->
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="ri-history-line me-1"></i>
                        Riwayat Absensi
                    </h5>
                    <small class="text-muted">
                        Data Generus Hadir
                    </small>
                </div>

                <!-- BODY -->
                <div class="card-body p-0">
                    <div class="mx-n3">
                        <div data-simplebar data-simplebar-auto-hide="false" style="max-height: 420px;" class="px-3">
                            <table class="table table-striped table-bordered align-middle">
                                <thead class="table-light sticky-top">
                                    <tr>
                                        <th>No</th>
                                        <th>Generus</th>
                                        <th>Kelompok</th>
                                        {{-- <th>Jenjang</th> --}}
                                        <th>Hadir</th>
                                        <th>Waktu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($riwayatAbsensi as $index => $absen)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $absen->ms_generus->nama_generus ?? '-' }}</td>
                                        <td>{{ $absen->ms_generus->ms_kelompok->nama_kelompok ?? '-' }}</td>
                                        {{-- <td>{{ ucfirst($absen->ms_generus->ms_kelompok->jenjang ?? '-') }}</td> --}}
                                        <td>
                                            @if($absen->status_hadir === 'hadir')
                                            <span class="badge bg-success">Hadir</span>
                                            @else
                                            <span class="badge bg-secondary">{{ ucfirst($absen->status_hadir) }}</span>
                                            @endif
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($absen->waktu_hadir)->format('H:i:s') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">
                                            Belum ada presensi hari ini
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- FOOTER -->
                <div class="card-footer text-muted small text-center">
                    <i class="ri-refresh-line me-1"></i>
                    Update otomatis
                </div>

            </div>
        </div>
    </div>
 
    <script>
        document.addEventListener('livewire:load', function () {
            Livewire.on('focusBarcode', () => {
                let input = document.getElementById('barcodeInput');
                if (input) input.focus();
            });
            // Fungsi untuk menampilkan waktu real-time
            function updateClock() {
                const clockEl = document.getElementById('live-clock');
                if (!clockEl) return;
                
                const now = new Date();
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const seconds = String(now.getSeconds()).padStart(2, '0');
                
                clockEl.textContent = `${hours}:${minutes}:${seconds}`;
            }
            
            // Update setiap detik
            updateClock(); // update langsung saat load
            setInterval(updateClock, 1000);
        });
    </script>
</div>