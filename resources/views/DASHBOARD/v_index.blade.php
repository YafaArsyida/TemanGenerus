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
                            @livewire('dashboard.c-t-a-generus')
                        </div> <!-- end col-->
                    
                        <div class="col-md-4">
                            @livewire('dashboard.total-kelompok')
                        </div>

                        <!-- Statistik Generus -->
                        <div class="col-md-4">
                            @livewire('dashboard.total-generus')
                        </div>
                    
                        <div class="col-md-4">
                            @livewire('dashboard.total-kegiatan')
                        </div>
                    
                    </div>
                    <div class="row g-3">
                        <!-- CTA Laporan Generus -->
                        <div class="col-md-6">
                            @livewire('dashboard.c-t-a-laporan-rutin-kelompok')
                        </div>
                    
                        <!-- CTA Laporan Aktivitas Generus -->
                        <div class="col-md-6">
                            @livewire('dashboard.c-t-a-laporan-event-kelompok')
                        </div>
                    </div> <!-- end row -->
                    
                    <div class="row mt-3">
                        <div class="col-12">
                            @livewire('dashboard.ringkasan-kegiatan-hari-ini')
                        </div>
                    </div>
                </div>
            </div> <!-- end col-->
            <div class="col-xxl-7">
                <div class="row h-100">
                    <!-- Presensi Hari Ini -->
                    <div class="col-xl-7">
                        @livewire('dashboard.list-generus-jenjang')
                    </div>
                
                    <!-- Jumlah Kehadiran -->
                    <div class="col-xl-5">
                        @livewire('dashboard.ranking-kehadiran-generus')
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