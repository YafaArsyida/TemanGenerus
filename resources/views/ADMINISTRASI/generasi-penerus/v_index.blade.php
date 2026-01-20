@extends('template_machine.v_template')
@section('content')
<div class="page-content">
    <div class="container-fluid" style="max-width: 100%">
        <div class="row mb-3 pb-1">
            <div class="col-12">
                <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-16 mb-1">Generasi Penerus</h4>
                        <p class="text-muted mb-0">Administrasi > Generasi Penerus</p>
                    </div>
                    @livewire('parameter.desa')
                </div><!-- end card header -->
            </div>
            <!--end col-->
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-xxl-12">
                @livewire('administrasi.generus.index')
                @livewire('administrasi.generus.detail')
                @livewire('administrasi.generus.create')
                @livewire('administrasi.generus.import')
                @livewire('administrasi.generus.edit')
                @livewire('administrasi.generus.delete')
            </div>
        </div>
    </div>
</div>

@endsection