@extends('template_machine.v_template')
@section('content')
<div class="page-content">
    <div class="container-fluid">
    
        <div class="row mb-3 pb-1">
            <div class="col-12">
                <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-16 mb-1">Laporan Kegiatan Event Generus</h4>
                        <p class="text-muted mb-0">Laporan > Laporan Kegiatan Event Generus</p>
                    </div>
                    @livewire('parameter.desa')
                </div><!-- end card header -->
            </div>
            <!--end col-->
        </div>
    
        <div class="row">
            <div class="row-xxl-12">
                @livewire('laporan.kegiatan-event.index')
                @livewire('administrasi.kegiatan-generus.detail')
                @livewire('laporan.kegiatan-event.report')
            </div>
        </div>
    
    </div>
</div>

@endsection