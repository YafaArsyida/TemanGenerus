<div class="row justify-content-center g-0 p-3">

    {{-- ================= INFO KEGIATAN (FULL WIDTH) ================= --}}
    <div class="col-lg-12">
        <div class="card shadow-sm border-0 mb-1">
            <div class="card-body">
    
                <div class="row g-3 align-items-start">
    
                    <!-- ================= LEFT SIDE ================= -->
                    <div class="col-lg-5 col-md-5 border-end-md">
    
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
                        
                            <div class="fw-medium text-body">
                                <h4 class="fw-medium mb-1">
                                    {{ $kegiatan->nama_kegiatan }}
                                </h4>
                                
                                @if($kegiatan->deskripsi)
                                <p class="text-muted mb-2">
                                    {{ $kegiatan->deskripsi }}
                                </p>
                                @endif

                                <div class="hstack gap-3 text-muted fs-13 flex-wrap mb-2 justify-content-lg-end">
                                
                                    <div>
                                        <i class="ri-group-line text-success me-1"></i>
                                        <span class="fw-medium text-body">
                                            @if($kegiatan->scope === 'daerah')
                                            Daerah Sragen Barat
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
                            </div>
                            <!-- RIGHT : Badges -->
                            <div class="d-flex gap-2 flex-wrap align-items-center">
                                {{-- <span class="badge bg-success-subtle text-success">
                                    {{ ucfirst($kegiatan->jenjang ?? 'Semua Jenjang') }}
                                </span>
                            
                                <span class="badge bg-info-subtle text-info">
                                    {{ ucfirst($kegiatan->scope) }}
                                </span> --}}
                                {{-- PARAMETER DESA HANYA JIKA SCOPE DAERAH --}}
                                @if($kegiatan->scope === 'daerah')
                                @livewire('parameter.desa')
                                @endif
                            </div>
                        </div>
                    </div>
    
                    <!-- ================= RIGHT SIDE ================= -->
                    <div class="col-lg-7 col-md-7 text-lg-end">
                    
                        <h4 class="mb-1">
                            Presensi Kegiatan {{ ucfirst($kegiatan->jenjang ?? 'Semua') }}
                        </h4>
                    
                        <span class="fs-13">
                            {{ \App\Http\Controllers\HelperController::formatTanggalIndonesia(
                            $kegiatan->tanggal,
                            'd F Y'
                            ) }}
                            {{ $kegiatan->waktu }}
                        </span>
                    
                    </div>
    
                </div>
    
            </div>
        </div>
    </div>
    {{-- ================= DATA GENERUS ================= --}}
    <div class="col-lg-7 pe-1">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h5>
                    <i class="ri-user-line me-1"></i>
                    Data Generus
                </h5>
                {{-- FILTER (STATIS) --}}
                <div class="p-3 border-bottom bg-light">
                    <div class="row g-2">
                        <div class="col-md-3">
                            <label class="form-label">Pencarian</label>
                            <input type="text" class="form-control" placeholder="Cari nama generus..." wire:model.debounce.500ms="searchGenerus">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Kelompok</label>
                            <select class="form-select" wire:model="kelompokGenerus">
                                <option value="">Semua Kelompok</option>
                                @foreach($listKelompok as $k)
                                <option value="{{ $k->ms_kelompok_id }}">
                                    Kelompok {{ $k->nama_kelompok }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">L/P</label>
                            <select class="form-select" wire:model="genderGenerus">
                                <option value="">Semua</option>
                                <option value="laki-laki">L</option>
                                <option value="perempuan">P</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Jenjang</label>
                            @if($kegiatan->jenjang)
                            <div class="alert alert-info py-2">
                                <i class="ri-filter-3-line"></i>
                                <strong>{{ strtoupper($kegiatan->jenjang) }}</strong>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
    
                {{-- TABEL --}}
                <div class="table-responsive" style="max-height: 1000px;">
                    <table class="table table-striped table-bordered align-middle mb-0">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Kelompok</th>
                                <th>Jenjang</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($listGenerus as $i => $g)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>
                                    {{ $g->nama_generus }}
                                </td>
                                <td>{{ $g->ms_kelompok->nama_kelompok ?? '-' }}</td>
                                <td>
                                    @if($g->usia)
                                    {{ collect($g->jenjang_usia)->implode(', ') }}
                                    @else
                                    -
                                    @endif
                                </td>
                                {{-- <td class="text-center" wire:poll.visible.5s="refreshPresensi"> --}}
                                <td class="text-center">
                                    @php $status = $presensiMap[$g->ms_generus_id] ?? null; @endphp
                                    
                                    @if(!$status)
                                    <button class="btn btn-sm btn-success" wire:click="hadir({{ $g->ms_generus_id }})">
                                        <i class="ri-check-line me-1"></i> Hadir
                                    </button>
                                    
                                    <a class="btn btn-link link-danger shadow-none fw-medium" wire:click="izin({{ $g->ms_generus_id }})">
                                        <i class="ri-close-line me-1"></i> Izin
                                    </a>
                                    
                                    @elseif($status === 'hadir')
                                    <button class="btn btn-sm btn-danger" wire:click="batalPresensi({{ $g->ms_generus_id }})">
                                        <i class="ri-close-line me-1"></i> Batal Hadir
                                    </button>
                                    
                                    @elseif($status === 'izin')
                                    <button class="btn btn-sm btn-danger" wire:click="batalPresensi({{ $g->ms_generus_id }})">
                                        <i class="ri-close-line me-1"></i> Batal Izin
                                    </button>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    Tidak ada generus sesuai filter
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
    
            </div>
    
        </div>
    </div>

    {{-- ================= KANAN : DATA ABSENSI ================= --}}
        {{-- ================= DATA ABSENSI ================= --}}
    <div class="col-lg-5">
        <div class="card shadow-sm h-100">
            <!-- BODY -->
            <div class="card-body">
                <h5>
                    <i class="ri-calendar-line me-1"></i>
                    Data Presensi
                </h5>
                {{-- FILTER (STATIS) --}}
                <div class="p-3 border-bottom bg-light">
                    <div class="row g-2">
                        <div class="col-md-5">
                            <label class="form-label">Pencarian</label>
                            <input type="text" class="form-control" placeholder="Cari nama generus..." wire:model.debounce.500ms="searchPresensi">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Kelompok</label>
                            <select class="form-select" wire:model="kelompokPresensi">
                                <option value="">Semua Kelompok</option>
                                @foreach($listKelompok as $k)
                                <option value="{{ $k->ms_kelompok_id }}">
                                    Kelompok {{ $k->nama_kelompok }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">L/P</label>
                            <select class="form-select" wire:model="genderPresensi">
                                <option value="">Semua</option>
                                <option value="laki-laki">L</option>
                                <option value="perempuan">P</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mx-n3">
                    <div class="table-responsive" style="max-height: 1000px;">
                        <table class="table table-striped table-bordered align-middle">
                        {{-- <table class="table table-striped table-bordered align-middle" wire:poll.visible.5s="refreshPresensi"> --}}
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
                                @forelse($this->riwayatAbsensi as $index => $absen)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $absen->ms_generus->nama_generus ?? '-' }}</td>
                                    <td>{{ $absen->ms_generus->ms_kelompok->nama_kelompok ?? '-' }}</td>
                                    {{-- <td>{{ ucfirst($absen->ms_generus->ms_kelompok->jenjang ?? '-') }}</td> --}}
                                    <td>
                                        @if($absen->status_hadir === 'hadir')
                                        <span class="badge bg-success">Hadir</span>
                                        @else
                                        <span class="badge bg-danger">{{ ucfirst($absen->status_hadir) }}</span>
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
                        {{-- <div class="mt-2">
                            {{ $this->riwayatAbsensi->links() }}
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>