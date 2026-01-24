<div class="card" id="produkList">
    <div class="card-header border-0">
        <div class="row align-items-center gy-3">
            <div class="col-sm">
                <h5 class="card-title mb-0">Administrasi Data Kelompok</h5>
                <p class="text-muted mb-0">Administrasi > Desa & Kelompok</p>
            </div>
            <div class="col-sm-auto">
                <div class="d-flex gap-1 flex-wrap">
                    <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal"
                        data-bs-target="#ModalKelompokCreate"
                        wire:click="$emit('KelompokCreate')">
                        <i class="ri-add-line align-bottom me-1"></i> Tambah Data Kelompok
                    </button>
                    {{-- <button type="button" class="btn btn-info">
                        <i class="ri-file-download-line align-bottom me-1"></i> Import
                    </button> --}}
                </div>
            </div>
        </div>
    </div>
    <!-- Search & Filter -->
    <div class="card-body border border-dashed border-end-0 border-start-0">
        <form>
            <div class="row g-3">
                <div class="col-xxl-10 col-sm-8">
                    <div class="search-box">
                        <input type="text" class="form-control search" wire:model.debounce.300ms="search"
                            placeholder="Cari nama produk...">
                        <i class="ri-search-line search-icon"></i>
                    </div>
                </div>
                <div class="col-xxl-2 col-sm-4">
                    <button type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasKategori"
                        aria-controls="offcanvasKategori" class="btn btn-primary w-100">
                        <i class="ri-equalizer-fill me-1 align-bottom"></i> Master Data Desa
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Tabs kategori -->
    <div class="card-body pt-0">
        <ul class="nav nav-tabs nav-tabs-custom nav-success" role="tablist">
            <!-- Tab Semua Produk -->
            <li class="nav-item">
                <a class="nav-link py-3 {{ $activeTab === 'semua' ? 'active' : '' }}" wire:click="setActiveTab('semua')"
                    data-bs-toggle="tab" href="#tabAll" role="tab">
                    <i class="ri-store-2-fill me-1 align-bottom"></i> Semua Kelompok
                </a>
            </li>

            @foreach($desa as $item)
            <li class="nav-item">
                <a class="nav-link py-3 {{ $activeTab === 'desa-'.$item->ms_desa_id ? 'active' : '' }}"
                    wire:click="setActiveTab('desa-{{ $item->ms_desa_id }}')" data-bs-toggle="tab"
                    href="#tabDesa{{ $item->ms_desa_id }}" role="tab">
                    <i class="mdi mdi-tag me-1 align-bottom"></i>
                    Desa {{ $item->nama_desa }}
                </a>
            </li>
            @endforeach
            <!-- Tombol Offcanvas di Kanan -->
            <li class="nav-item">
                <button data-bs-toggle="modal" data-bs-target="#ModalDesaCreate"
                    wire:click="$emit('DesaCreate')"
                    class="btn btn-sm shadow-none nav-link py-3">
                    <i class="ri-add-line me-1 align-bottom"></i> Tambah Data Desa
                </button>
            </li>
        </ul>

        <div class="tab-content mt-3">

            <!-- Semua Kelompok -->
            <div class="tab-pane fade {{ $activeTab === 'semua' ? 'show active' : '' }}" id="tabAll" role="tabpanel">
                <div class="row g-3">
                    @include('livewire.administrasi.kelompok.data', ['listKelompok' => $allKelompok])
                </div>
            </div>

            <!-- Kelompok per Desa -->
            @foreach($desa as $kat)
            <div class="tab-pane fade {{ $activeTab === 'desa-'.$kat->ms_desa_id ? 'show active' : '' }}"
                id="tabDesa{{ $kat->ms_desa_id }}" role="tabpanel">
                <div class="row g-3">
                    @php
                    $kelompokDesa = $allKelompok->where('ms_desa_id',
                    $kat->ms_desa_id);
                    @endphp

                    @include('livewire.administrasi.kelompok.data', ['listKelompok' => $kelompokDesa])
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>