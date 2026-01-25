@extends('template_machine.v_template')
@section('content')

@php
$title = "Dashboard"
@endphp
@push('info-page')
<div class="page-title-right">
    <ol class="breadcrumb m-0">
        <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
        <li class="breadcrumb-item active">{{ $title ?? "SmartGate" }}</li>
    </ol>
</div>
@endpush
<div class="page-content">
    <div class="container-fluid" style="max-width: 100%">
        <div class="row mb-3 pb-1">
            <div class="col-12">
                <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-16 mb-1">Dashboard TemanGenerus</h4>
                        <p class="text-muted mb-0">Dashboard</p>
                    </div>
                    @livewire('parameter.desa')
                </div><!-- end card header -->
            </div>
            <!--end col-->
        </div>
        <div class="row">
            <div class="col-xxl-5">
                <div class="d-flex flex-column h-100">
                    <div class="row g-3">
                    
                        <!-- CTA Presensi Generus -->
                        <div class="col-12">
                            <div class="card shadow-sm border-0">
                                <div class="card-body p-0">
                                    <!-- Alert CTA -->
                                    <div class="alert alert-primary border-0 rounded-0 m-0 d-flex align-items-center" role="alert">
                                        <i class="bx bx-user-check text-primary me-2 fs-4"></i>
                                        <div class="flex-grow-1 text-truncate">
                                            Mulai proses <strong>Presensi Generus</strong> untuk hari ini.
                                        </div>
                                        <div class="flex-shrink-0">
                                            <a href="#" class="fw-semibold text-decoration-underline text-primary">
                                                Buka Presensi
                                            </a>
                                        </div>
                                    </div>
                    
                                    <!-- Body CTA -->
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <div class="p-4">
                                                <h5 class="fw-bold mb-2">Presensi Generus Berbasis RFID</h5>
                                                <p class="mb-3 text-muted">
                                                    Lakukan presensi masuk dan pulang generus dengan cepat menggunakan kartu RFID.
                                                    Status hadir, terlambat, dan pulang tercatat otomatis.
                                                </p>
                    
                                                <a href="#" class="btn btn-primary btn-lg">
                                                    <i class="bx bx-log-in-circle align-middle me-1"></i>
                                                    Mulai Presensi Generus
                                                </a>
                                            </div>
                                        </div>
                    
                                        <div class="col-md-4 text-end">
                                            <img src="{{ asset('assets/images/user-illustarator-2.png') }}" class="img-fluid"
                                                alt="Illustrasi Generus">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end col-->
                    
                        <!-- Statistik Generus -->
                        <div class="col-md-4">
                            <div class="card text-center shadow-sm border-0">
                                <div class="card-body">
                                    <i class="bx bx-group fs-2 text-primary mb-2"></i>
                                    <h6 class="text-muted">Total Generus</h6>
                                    <h3 class="fw-bold">120</h3>
                                </div>
                            </div>
                        </div>
                    
                        <div class="col-md-4">
                            <div class="card text-center shadow-sm border-0">
                                <div class="card-body">
                                    <i class="bx bx-time fs-2 text-success mb-2"></i>
                                    <h6 class="text-muted">Generus Hadir Hari Ini</h6>
                                    <h3 class="fw-bold">95</h3>
                                </div>
                            </div>
                        </div>
                    
                        <div class="col-md-4">
                            <div class="card text-center shadow-sm border-0">
                                <div class="card-body">
                                    <i class="bx bx-notepad fs-2 text-warning mb-2"></i>
                                    <h6 class="text-muted">Aktivitas Terbaru</h6>
                                    <h3 class="fw-bold">5</h3>
                                </div>
                            </div>
                        </div>
                    
                    </div>
                    <div class="row g-3">
                        <!-- CTA Laporan Generus -->
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-success-subtle text-success rounded-circle fs-4">
                                                <i class="bx bx-user-check"></i>
                                            </span>
                                        </div>
                    
                                        <h6 class="fw-bold mb-0 ms-3">
                                            Laporan Presensi Generus
                                        </h6>
                                    </div>
                    
                                    <p class="text-muted mb-3">
                                        Lihat laporan kehadiran generus, termasuk jam hadir, pulang,
                                        dan tingkat keaktifan setiap generus.
                                    </p>
                    
                                    <a href="#" class="btn btn-outline-success w-100">
                                        <i class="ri-pie-chart-2-line me-1"></i>
                                        Lihat Laporan Generus
                                    </a>
                                </div>
                            </div>
                        </div>
                    
                        <!-- CTA Laporan Aktivitas Generus -->
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-primary-subtle text-primary rounded-circle fs-4">
                                                <i class="bx bxs-report"></i>
                                            </span>
                                        </div>
                    
                                        <h6 class="fw-bold mb-0 ms-3">
                                            Laporan Aktivitas Generus
                                        </h6>
                                    </div>
                    
                                    <p class="text-muted mb-3">
                                        Lihat rekap aktivitas harian, mingguan, dan bulanan generus,
                                        termasuk kehadiran, keterlambatan, dan catatan kegiatan.
                                    </p>
                    
                                    <a href="#" class="btn btn-outline-primary w-100">
                                        <i class="ri-bar-chart-2-line me-1"></i>
                                        Lihat Laporan Aktivitas
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end row -->
                    
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <h6 class="fw-bold mb-3">
                                        <i class="ri-dashboard-line me-1"></i>
                                        Ringkasan Presensi Hari Ini
                                    </h6>
                    
                                    <div class="row text-center">
                                        <div class="col-6 col-md-3">
                                            <h4 class="fw-bold mb-0 text-success">42</h4>
                                            <small class="text-muted">Hadir</small>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <h4 class="fw-bold mb-0 text-warning">5</h4>
                                            <small class="text-muted">Terlambat</small>
                                        </div>
                                        <div class="col-6 col-md-3 mt-3 mt-md-0">
                                            <h4 class="fw-bold mb-0 text-danger">3</h4>
                                            <small class="text-muted">Belum Absen</small>
                                        </div>
                                        <div class="col-6 col-md-3 mt-3 mt-md-0">
                                            <h4 class="fw-bold mb-0 text-primary">18</h4>
                                            <small class="text-muted">Sudah Pulang</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end col-->
            <div class="col-xxl-7">
                <div class="row h-100">
                    <!-- Presensi Hari Ini -->
                    <div class="col-xl-7">
                        <div class="card card-height-100">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Presensi Generus Hari Ini</h4>
                
                                <!-- Select Kategori -->
                                <div class="flex-shrink-0">
                                    <select class="form-select form-select-sm">
                                        <option value="all">Semua</option>
                                        <option value="generus">Generus</option>
                                        <option value="mentor">Mentor</option>
                                    </select>
                                </div>
                            </div>
                
                            <div class="card-body">
                                <div class="table-responsive table-card">
                                    <table class="table table-centered table-hover align-middle table-nowrap mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="50px">No</th>
                                                <th>Nama</th>
                                                <th>Kategori</th>
                                                <th class="text-center">Waktu Scan</th>
                                                <th class="text-center">Status</th>
                                            </tr>
                                        </thead>
                
                                        <tbody>
                                            <tr>
                                                <td>1.</td>
                                                <td><span class="fw-medium">Ahmad Fauzi</span></td>
                                                <td><span class="badge bg-primary">Generus</span></td>
                                                <td class="text-center"><span class="fw-medium text-dark">06:55</span></td>
                                                <td class="text-center"><span class="badge bg-success">Masuk</span></td>
                                            </tr>
                
                                            <tr>
                                                <td>2.</td>
                                                <td><span class="fw-medium">Rina Pratiwi</span></td>
                                                <td><span class="badge bg-primary">Generus</span></td>
                                                <td class="text-center"><span class="fw-medium text-dark">07:02</span></td>
                                                <td class="text-center"><span class="badge bg-success">Masuk</span></td>
                                            </tr>
                
                                            <tr>
                                                <td>3.</td>
                                                <td><span class="fw-medium">Budi Santoso</span></td>
                                                <td><span class="badge bg-warning text-dark">Mentor</span></td>
                                                <td class="text-center"><span class="fw-medium text-dark">06:45</span></td>
                                                <td class="text-center"><span class="badge bg-success">Masuk</span></td>
                                            </tr>
                
                                            <tr>
                                                <td>4.</td>
                                                <td><span class="fw-medium">Siti Aminah</span></td>
                                                <td><span class="badge bg-warning text-dark">Mentor</span></td>
                                                <td class="text-center"><span class="fw-medium text-dark">07:10</span></td>
                                                <td class="text-center"><span class="badge bg-danger">Terlambat</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                
                                <!-- Pagination Dummy -->
                                <div class="mt-3 d-flex justify-content-end">
                                    <nav>
                                        <ul class="pagination pagination-sm mb-0">
                                            <li class="page-item disabled"><span class="page-link">Prev</span></li>
                                            <li class="page-item active"><span class="page-link">1</span></li>
                                            <li class="page-item"><span class="page-link">2</span></li>
                                            <li class="page-item"><span class="page-link">3</span></li>
                                            <li class="page-item"><span class="page-link">Next</span></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <!-- Jumlah Kehadiran -->
                    <div class="col-xl-5">
                        <div class="card card-height-100">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Ringkasan Kehadiran Generus</h4>
                
                                <div class="d-flex gap-2">
                                    <select class="form-select form-select-sm">
                                        <option value="all">Semua</option>
                                        <option value="generus">Generus</option>
                                        <option value="mentor">Mentor</option>
                                    </select>
                
                                    <select class="form-select form-select-sm">
                                        <option value="today">Hari Ini</option>
                                        <option value="yesterday">Kemarin</option>
                                        <option value="this_month">Bulan Ini</option>
                                        <option value="3_months">3 Bulan</option>
                                    </select>
                                </div>
                            </div>
                
                            <div class="card-body">
                                <div class="px-2 py-2 mt-2">
                
                                    <!-- Item 1 -->
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="fw-semibold text-dark">Ahmad Fauzi</div>
                                            <div class="text-muted small">Kelas XII IPA 2</div>
                                        </div>
                
                                        <div class="text-end">
                                            <span class="fw-bold fs-4 text-primary">12</span>
                                            <div class="text-muted small">Kehadiran</div>
                                        </div>
                                    </div>
                                    <hr>
                
                                    <!-- Item 2 -->
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="fw-semibold text-dark">Rina Pratiwi</div>
                                            <div class="text-muted small">Kelas XI IPS 1</div>
                                        </div>
                
                                        <div class="text-end">
                                            <span class="fw-bold fs-4 text-primary">11</span>
                                            <div class="text-muted small">Kehadiran</div>
                                        </div>
                                    </div>
                                    <hr>
                
                                    <!-- Item 3 -->
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="fw-semibold text-dark">Budi Santoso</div>
                                            <div class="text-muted small">Mentor Matematika</div>
                                        </div>
                
                                        <div class="text-end">
                                            <span class="fw-bold fs-4 text-primary">10</span>
                                            <div class="text-muted small">Kehadiran</div>
                                        </div>
                                    </div>
                
                                    <div class="mt-3 d-flex justify-content-end">
                                        <nav>
                                            <ul class="pagination pagination-sm mb-0">
                                                <li class="page-item disabled"><span class="page-link">Prev</span></li>
                                                <li class="page-item active"><span class="page-link">1</span></li>
                                                <li class="page-item"><span class="page-link">2</span></li>
                                                <li class="page-item"><span class="page-link">3</span></li>
                                                <li class="page-item"><span class="page-link">Next</span></li>
                                            </ul>
                                        </nav>
                                    </div>
                
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- end row -->
            </div><!-- end col -->
        </div>
        <div class="row">
            {{-- @livewire('widget.kartu-transaksi-jurnal')
            @livewire('widget.kartu-jurnal-detail') --}}
        </div><!-- end row -->
    </div>
</div>

@endsection