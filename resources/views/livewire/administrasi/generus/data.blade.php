<div class="table-responsive">
    <table class="table table-hover table-nowrap align-middle mb-0">
        <thead class="table-light">
            <tr>
                <th width="40">#</th>
                <th>Nama Generus</th>
                <th>Kelompok</th>
                <th>Jenis Kelamin</th>
                <th>Usia</th>
                <th>Jenjang</th>
                <th>Desa</th>
                <th width="120" class="text-uppercase text-center">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($listGenerus as $i => $row)
            <tr>
                <td>{{ $loop->iteration }}</td>

                <td class="fw-semibold">
                    {{ $row->nama_generus }}
                </td>

                <td>
                    {{ $row->ms_kelompok->nama_kelompok ?? '-' }}
                </td>

                <td>
                    {{ $row->jenis_kelamin ?? '-' }}
                </td>

                <td>
                    @if($row->usia)
                    {{ $row->usia }} Tahun
                    @else
                    -
                    @endif
                </td>

                <td>
                    @if($row->usia)
                    {{ collect($row->jenjang_usia)->implode(', ') }}
                    @else
                    -
                    @endif
                </td>

                <td>
                    {{ $row->ms_kelompok->ms_desa->nama_desa ?? '-' }}
                </td>

                <td class="text-center">
                    <div class="hstack gap-2 justify-content-center">
                        {{-- Tombol Detail --}}
                        <a href="#ModalDetailGenerus" data-bs-toggle="modal" class="text-primary d-inline-block" title="Detail Generus"
                            wire:click.prevent="$emit('GenerusDetail', {{ $row->ms_generus_id }})">
                            <i class="ri-eye-line fs-17 align-middle"></i>
                        </a>
                        
                        {{-- Tombol Edit --}}
                        <a href="#ModalEditGenerus" data-bs-toggle="modal" class="text-warning d-inline-block" title="Edit Generus"
                            wire:click.prevent="$emit('GenerusEdit', {{ $row->ms_generus_id }})">
                            <i class="ri-mark-pen-line fs-17 align-middle"></i>
                        </a>
                        
                        {{-- Tombol Hapus --}}
                        <a href="#ModalDeleteGenerus" data-bs-toggle="modal" class="text-danger d-inline-block" title="Hapus Generus"
                            wire:click.prevent="$emit('GenerusDelete', {{ $row->ms_generus_id }})">
                            <i class="ri-delete-bin-5-line fs-17 align-middle"></i>
                        </a>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center text-muted py-3">
                    Tidak ada data generus
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>