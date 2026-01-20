<div>
    <div wire:ignore.self class="modal fade" id="ModalImportGenerus" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light p-3">
                    <h5 class="modal-title">Import Generus</h5>
                    <a href="{{ url('storage/template_import_excel/template_import_generus.xlsx') }}"
                        class="text-success d-inline-block detail-item-btn ms-3" download>
                        <i class="ri-file-excel-2-line fs-17 align-middle"></i> Template
                    </a>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form wire:submit.prevent="importGenerus">
                    <div class="modal-body">
                        <div class="text-center mb-4">
                            <lord-icon src="https://cdn.lordicon.com/fjvfsqea.json" trigger="loop"
                                colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px"></lord-icon>
                        </div>

                        <div class="row g-3">
                            <h4 class="fs-semibold text-center">Import Dokumen</h4>

                            <div class="col-lg-6">
                                <label for="file_import" class="form-label">Upload File Excel</label>
                                <input type="file" wire:model="file_import" id="file_import" class="form-control">
                                @error('file_import')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-lg-6">
                                <label for="ms_kelompok_id" class="form-label">Penempatan Kelompok</label>
                                <select id="ms_kelompok_id" wire:model="ms_kelompok_id" class="form-select">
                                    <option value="">Pilih Kelompok</option>
                                    @foreach ($select_kelompok as $item)
                                    <option value="{{ $item->ms_kelompok_id }}">
                                        {{ $item->nama_kelompok }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('ms_kelompok_id')
                                <footer class="text-danger mt-0">{{ $message }}</footer>
                                @enderror
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover nowrap align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Telepon</th>
                                            <th>Tempat Lahir</th>
                                            <th>Tanggal Lahir</th>
                                            <th>Jenis Kelamin</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($newGenerusList) && is_array($newGenerusList))
                                        @foreach($newGenerusList as $index => $generus)
                                        <tr>
                                            <td>{{ $index + 1 }}.</td>
                                            <td>{{ $generus['nama_generus'] ?? '-' }}</td>
                                            <td>{{ $generus['nomor_telepon'] ?? '-' }}</td>
                                            <td>{{ $generus['tempat_lahir'] ?? '-' }}</td>
                                            <td>{{ $generus['tanggal_lahir'] ?? '-' }}</td>
                                            <td>{{ $generus['jenis_kelamin'] ?? '-' }}</td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="5">Belum ada data generus baru yang diimpor.</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <a href="javascript:void(0);" class="btn btn-link link-success shadow-none fw-medium"
                            data-bs-dismiss="modal">
                            <i class="ri-close-line me-1 align-middle"></i> Tutup
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Import Generus
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>