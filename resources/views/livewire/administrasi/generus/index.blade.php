<div class="card border-0 shadow-sm rounded-4 overflow-hidden" id="generusList">
    {{-- HEADER --}}
    <div class="card-header bg-white border-0 p-4">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-4">
            {{-- TITLE --}}
            <div>
                <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="avatar-sm">
                        <div class="avatar-title bg-primary-subtle text-primary rounded-circle fs-20">
                            <i class="ri-team-line">
                            </i>
                        </div>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-1">
                            Administrasi Data Generasi Penerus
                        </h4>
                        <p class="text-muted mb-0 fs-13">
                            Kelola data generus berdasarkan kelompok dan jenjang usia
                        </p>
                    </div>
                </div>
            </div>
            {{-- ACTION --}}
            <div class="d-flex gap-2 flex-wrap">
                {{-- IMPORT --}}
                <button type="button" class="btn btn-light border rounded-pill px-4" data-bs-toggle="modal"
                    data-bs-target="#ModalImportGenerus"
                    wire:click.prevent="$emit('showImportGenerus', {{ $selectedDesa }})">
                    <i class="ri-database-2-line me-1 text-secondary">
                    </i>
                    Import Generus
                </button>
                {{-- IMPORT KARTU --}}
                @if(Str::startsWith($activeTab, 'kelompok-'))
                    @php
                    $kelompokId = str_replace('kelompok-', '', $activeTab);
                    @endphp
                
                    <button type="button" class="btn btn-primary border rounded-pill px-4" data-bs-toggle="modal"
                        data-bs-target="#ModalImportKartu" wire:click.prevent="$emit('showImportKartu', {{ $kelompokId }})">
                    
                        <i class="ri-database-2-line me-1 text-white"></i>
                        Import Kartu
                    </button>
                @endif
                {{-- TAMBAH --}}
                <button type="button" class="btn btn-success rounded-pill px-4" data-bs-toggle="modal"
                    data-bs-target="#ModalGenerusCreate" wire:click="$emit('GenerusCreate')">
                    <i class="ri-add-line me-1">
                    </i>
                    Tambah Generus
                </button>
            </div>
        </div>
    </div>
    {{-- FILTER --}}
    <div class="card-body border-top border-light p-4">
        <div class="row g-3 align-items-end">
            {{-- SEARCH --}}
            <div class="col-xxl-7 col-lg-6">
                <label class="form-label fw-semibold">
                    Cari Nama Generus
                </label>
                <div class="position-relative">
                    <input type="text" class="form-control ps-5" wire:model.debounce.400ms="search"
                        placeholder="Cari nama generus...">
                    <i class="ri-search-line position-absolute top-50 start-0 translate-middle-y ms-3 text-muted fs-18">
                    </i>
                </div>
            </div>
            {{-- GENDER --}}
            <div class="col-xxl-2 col-lg-3 col-sm-6">
                <label class="form-label fw-semibold">
                    Gender
                </label>
                <select class="form-select" wire:model="gender">
                    <option value="">
                        Semua Generus
                    </option>
                    <option value="laki-laki">
                        Laki-laki
                    </option>
                    <option value="perempuan">
                        Perempuan
                    </option>
                </select>
            </div>
            {{-- JENJANG --}}
            <div class="col-xxl-3 col-lg-3 col-sm-6">
                <label class="form-label fw-semibold">
                    Jenjang Usia
                </label>
                <select class="form-select" wire:model="jenjangUsia">
                    <option value="">
                        Semua Jenjang
                    </option>
                    <option value="caberawit">
                        Caberawit (&lt; 12 Tahun)
                    </option>
                    <option value="remaja">
                        Remaja (12 – 30 Tahun)
                    </option>
                    <option value="gp">
                        GP (12 – 23 Tahun)
                    </option>
                    {{-- <option value="pra_nikah">
                        Pra Nikah (19 – 23 Tahun)
                    </option> --}}
                    <option value="mandiri">
                        Mandiri (&gt; 17 Tahun)
                    </option>
                </select>
            </div>
        </div>
    </div>
    {{-- CONTENT --}}
    <div class="card-body pt-0 px-4 pb-4">
        <div class="border rounded-4 overflow-hidden">
            {{-- TAB NAV --}}
            <div class="bg-light px-3 pt-3">
                <ul class="nav nav-pills gap-2 flex-nowrap overflow-auto pb-3" role="tablist">
                    {{-- SEMUA --}}
                    <li class="nav-item flex-shrink-0">
                        <button type="button"
                            class="nav-link rounded-pill px-4 py-2 fw-medium {{ $activeTab === 'semua' ? 'active' : '' }}"
                            wire:click="setActiveTab('semua')">
                            <i class="ri-user-3-line me-1">
                            </i>
                            Semua Generus
                        </button>
                    </li>
                    {{-- DINAMIS KELOMPOK --}} 
                    @foreach($kelompok as $item)
                    <li class="nav-item flex-shrink-0">
                        <button type="button"
                            class="nav-link rounded-pill px-4 py-2 fw-medium {{ $activeTab === 'kelompok-'.$item->ms_kelompok_id ? 'active' : '' }}"
                            wire:click="setActiveTab('kelompok-{{ $item->ms_kelompok_id }}')">
                            <i class="ri-group-2-line me-1">
                            </i>
                            {{ $item->nama_kelompok }}
                        </button>
                    </li>
                    @endforeach
                </ul>
            </div>
            {{-- TAB CONTENT --}}
            <div class="bg-white p-3 p-lg-4">
                <div class="tab-content">
                    {{-- SEMUA GENERUS --}}
                    <div class="tab-pane fade {{ $activeTab === 'semua' ? 'show active' : '' }}" id="tabSemua"
                        role="tabpanel">
                        @php $listGenerus = $allGenerus; @endphp
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                            <div>
                                <h5 class="fw-bold mb-1">
                                    Semua Generus
                                </h5>
                                <p class="text-muted mb-0 fs-13">
                                    Menampilkan seluruh data generasi penerus
                                </p>
                            </div>
                            <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill">
                                {{ count($listGenerus) }} Generus
                            </span>
                        </div>
                        @include('livewire.administrasi.generus.data', compact('listGenerus'))
                    </div>
                    {{-- PER KELOMPOK --}} @foreach($kelompok as $grp)
                    <div class="tab-pane fade {{ $activeTab === 'kelompok-'.$grp->ms_kelompok_id ? 'show active' : '' }}"
                        id="tabKelompok{{ $grp->ms_kelompok_id }}" role="tabpanel">
                        @php $listGenerus = $allGenerus->where( 'ms_kelompok_id', $grp->ms_kelompok_id
                        ); @endphp
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
                            <div>
                                <h5 class="fw-bold mb-1">
                                    Kelompok {{ $grp->nama_kelompok }}
                                </h5>
                                <p class="text-muted mb-0 fs-13">
                                    Data generus berdasarkan kelompok binaan
                                </p>
                            </div>
                            <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">
                                {{ count($listGenerus) }} Generus
                            </span>
                        </div>
                        @include('livewire.administrasi.generus.data', compact('listGenerus'))
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>