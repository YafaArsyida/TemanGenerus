<div class="card" id="generusList">
    <div class="card-header border-0">
        <div class="row align-items-center gy-3">
            <div class="col-sm">
                <h5 class="card-title mb-0">Administrasi Data Generasi Penerus</h5>
                <p class="text-muted mb-0">Administrasi > Generasi Penerus</p>
            </div>

            <div class="col-sm-auto">
                <div class="d-flex gap-1 flex-wrap">
                    <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" data-bs-target="#ModalGenerusCreate"
                        wire:click="$emit('GenerusCreate')">
                        <i class="ri-add-line align-bottom me-1"></i> Tambah Data Generus
                    </button>
                    <button data-bs-toggle="modal" data-bs-target="#ModalImportGenerus"
                        wire:click.prevent="$emit('showImportGenerus', {{ $selectedDesa }})" class="btn btn-secondary"><i
                            class="ri-contacts-line me-1 align-bottom"></i> Import Generus
                    </button>

                    {{-- <button type="button" class="btn btn-soft-danger">
                        <i class="ri-delete-bin-2-line"></i>
                    </button> --}}
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="card-body border border-dashed border-start-0 border-end-0">
        <div class="row g-3">
    
            {{-- Search --}}
            <div class="col-xxl-8 col-sm-6">
                <div class="search-box">
                    <input type="text" class="form-control" wire:model.debounce.400ms="search"
                        placeholder="Cari nama generus ...">
                    <i class="ri-search-line search-icon"></i>
                </div>
            </div>
            <div class="col-xxl-2 col-sm-3">
                <select class="form-select" wire:model="gender">
                    <option value="">Semua Generus</option>
                    <option value="laki-laki">Laki - Laki</option>
                    <option value="perempuan">Perempuan</option>
                </select>
            </div>
    
            {{-- Jenjang Usia --}}
            <div class="col-xxl-2 col-sm-3">
                <select class="form-select" wire:model="jenjangUsia">
                    <option value="">Semua Jenjang Usia</option>
                    <option value="caberawit">Caberawit ( < 12 Tahun )</option>
                    <option value="remaja">Remaja ( 12 – 25 Tahun )</option>
                    <option value="gp">GP ( 12 – 23 Tahun )</option>
                    <option value="pra_nikah">Pra Nikah ( 19 – 23 Tahun )</option>
                    <option value="mandiri">Mandiri ( > 23 Tahun )</option>
                </select>
            </div>
    
        </div>
    </div>

    <div class="card-body pt-0">
        {{-- ================= TAB KELOMPOK ================= --}}
        <ul class="nav nav-tabs nav-tabs-custom nav-success" role="tablist">
            {{-- TAB SEMUA --}}
            <li class="nav-item">
                <a class="nav-link py-3 {{ $activeTab === 'semua' ? 'active' : '' }}" wire:click="setActiveTab('semua')"
                    data-bs-toggle="tab" href="#tabSemua" role="tab">
                    <i class="ri-user-3-fill me-1 align-bottom"></i> Semua Generus
                </a>
            </li>
        
            {{-- TAB DINAMIS KELOMPOK --}}
            @foreach($kelompok as $item)
            <li class="nav-item">
                <a class="nav-link py-3 {{ $activeTab === 'kelompok-'.$item->ms_kelompok_id ? 'active' : '' }}"
                    wire:click="setActiveTab('kelompok-{{ $item->ms_kelompok_id }}')" data-bs-toggle="tab"
                    href="#tabKelompok{{ $item->ms_kelompok_id }}" role="tab">
                    <i class="mdi mdi-account-group me-1 align-bottom"></i>
                    {{ $item->nama_kelompok }}
                </a>
            </li>
            @endforeach
        </ul>
        <div class="tab-content mt-3">
        
            {{-- === TAB SEMUA GENERUS === --}}
            <div class="tab-pane fade {{ $activeTab === 'semua' ? 'show active' : '' }}" id="tabSemua" role="tabpanel">
        
                @php
                $listGenerus = $allGenerus;
                @endphp
        
                @include('livewire.administrasi.generus.data', compact('listGenerus'))
            </div>
        
        
            {{-- === PER TAB KELOMPOK === --}}
            @foreach($kelompok as $grp)
            <div class="tab-pane fade {{ $activeTab === 'kelompok-'.$grp->ms_kelompok_id ? 'show active' : '' }}"
                id="tabKelompok{{ $grp->ms_kelompok_id }}" role="tabpanel">
        
                @php
                $listGenerus = $allGenerus->where('ms_kelompok_id', $grp->ms_kelompok_id);
                @endphp
        
                @include('livewire.administrasi.generus.data', compact('listGenerus'))
            </div>
            @endforeach
        
        </div>
    </div>
</div>