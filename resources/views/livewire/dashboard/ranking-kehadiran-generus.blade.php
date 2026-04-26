<div class="card card-height-100">
    <div class="card-header d-flex align-items-center">
        <h4 class="card-title mb-0 flex-grow-1">
            Ranking Kehadiran Generus
        </h4>

        <div class="flex-shrink-0">
            <select wire:model="periode" class="form-select form-select-sm">
                <option value="1bulan">1 Bulan</option>
                <option value="3bulan">3 Bulan</option>
                <option value="1tahun">1 Tahun</option>
            </select>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="50px">#</th>
                        <th>Nama</th>
                        <th>Kelompok</th>
                        <th class="text-center">Jumlah Hadir</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($data as $index => $item)
                    <tr>
                        <td>{{ $data->firstItem() + $index }}</td>

                        <td class="fw-medium">
                            {{ $item->ms_generus->nama_generus ?? '-' }}
                        </td>

                        <td>
                            {{ $item->ms_generus->ms_kelompok->nama_kelompok ?? '-' }}
                        </td>

                        <td class="text-center">
                            <span class="badge bg-success">
                                {{ $item->total_hadir }}x
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">
                            Belum ada data kehadiran
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3 d-flex justify-content-end">
            {{ $data->links() }}
        </div>
    </div>
</div>