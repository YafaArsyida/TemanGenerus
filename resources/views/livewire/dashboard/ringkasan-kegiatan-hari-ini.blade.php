<div class="card border-0 shadow-sm">
    <div class="card-body">

        <h6 class="fw-bold mb-3">
            <i class="ri-dashboard-line me-1"></i>
            Ringkasan Kegiatan Bulan Ini
        </h6>

        <!-- SELECT KEGIATAN -->
        <div class="mb-3">
            <select wire:model="selectedKegiatan" class="form-select">
                <option value="">-- Pilih Kegiatan Bulan Ini --</option>

                @foreach ($listKegiatan as $kegiatan)
                <option value="{{ $kegiatan->ms_kegiatan_id }}">
                    {{ $kegiatan->nama_kegiatan }} - {{ $kegiatan->waktu }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- SUMMARY -->
        <div class="row text-center">
            <div class="col-6 col-md-3">
                <h4 class="fw-bold mb-0 text-success">{{ $hadir }}</h4>
                <small class="text-muted">Hadir</small>
            </div>
            <div class="col-6 col-md-3">
                <h4 class="fw-bold mb-0 text-warning">{{ $izin }}</h4>
                <small class="text-muted">Izin</small>
            </div>
            <div class="col-6 col-md-3 mt-3 mt-md-0">
                <h4 class="fw-bold mb-0 text-danger">{{ $alfa }}</h4>
                <small class="text-muted">Alfa</small>
            </div>
        </div>

    </div>
</div>