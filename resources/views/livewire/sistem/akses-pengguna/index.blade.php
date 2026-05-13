<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    {{-- HEADER --}}
    <div class="card-header bg-white border-0 p-4">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
            {{-- TITLE --}}
            <div>
                <h4 class="card-title mb-1 fw-bold d-flex align-items-center gap-2">
                    <i class="ri-team-line text-primary">
                    </i>
                    Petugas Administrasi
                </h4>
                <p class="text-muted mb-0 fs-13">
                    Kelola akun petugas, akses sistem, dan keamanan pengguna aplikasi.
                </p>
            </div>
            {{-- ACTION --}}
            <div class="d-flex gap-2 flex-wrap">
                <button class="btn btn-primary rounded-pill px-4 shadow-sm" data-bs-toggle="modal"
                    data-bs-target="#ModalAddPengguna" wire:click="$emit('openCreatePengguna')">
                    <i class="ri-user-add-line align-bottom me-1">
                    </i>
                    Petugas Baru
                </button>
            </div>
        </div>
    </div>
    {{-- FILTER --}}
    <div class="card-body border-top bg-light-subtle">
        <div class="row g-3 align-items-end">
            <div class="col-12">
                <label class="form-label fw-semibold">
                    Pencarian Pengguna
                </label>
                <div class="search-box">
                    <input type="text" class="form-control border-light shadow-sm rounded-3"
                        wire:model.debounce.300ms="search" placeholder="Cari nama, email, telepon, atau lainnya...">
                    <i class="ri-search-line search-icon">
                    </i>
                </div>
            </div>
        </div>
    </div>
    {{-- TABLE --}}
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle table-hover mb-0">
                <thead class="bg-light text-muted">
                    <tr>
                        <th width="60" class="ps-4">
                            #
                        </th>
                        <th>
                            Petugas
                        </th>
                        <th>
                            Username
                        </th>
                        <th>
                            Telepon
                        </th>
                        <th>
                            Peran
                        </th>
                        <th>
                            Akses
                        </th>
                        <th width="240" class="text-center">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengguna as $index => $user)
                    <tr class="fw-medium">
                        {{-- NO --}}
                        <td class="ps-4">
                            <span class="text-muted">
                                {{ $index + 1 }}
                            </span>
                        </td>
                        {{-- PETUGAS --}}
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar-sm">
                                    <div class="avatar-title rounded-circle bg-soft-primary text-primary fw-bold">
                                        {{ strtoupper(substr($user['nama'], 0, 1)) }}
                                    </div>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-semibold">
                                        {{ $user['nama'] }}
                                    </h6>
                                    <small class="text-muted">
                                        ID Pengguna
                                    </small>
                                </div>
                            </div>
                        </td>
                        {{-- USERNAME --}}
                        <td>
                            <span class="badge bg-light text-body border fw-medium px-3 py-2">
                                {{ $user['email'] }}
                            </span>
                        </td>
                        {{-- TELEPON --}}
                        <td>
                            @if($user['telepon'])
                            <span class="text-body">
                                {{ $user['telepon'] }}
                            </span>
                            @else
                            <span class="text-muted">
                                -
                            </span>
                            @endif
                        </td>
                        {{-- PERAN --}}
                        <td>
                            @php $roleClass = match($user['peran']) { 'superadmin' => 'bg-danger-subtle
                            text-danger', 'admin' => 'bg-primary-subtle text-primary', 'petugas' =>
                            'bg-success-subtle text-success', default => 'bg-light text-body' }; @endphp
                            <span class="badge {{ $roleClass }} px-3 py-2 text-uppercase fw-semibold">
                                {{ $user['peran'] }}
                            </span>
                        </td>
                        {{-- AKSES --}}
                        <td>
                            <div class="d-flex flex-wrap gap-1">
                                @foreach($user['aksesPengguna'] as $akses)
                                <span class="badge bg-soft-secondary text-secondary">
                                    {{ $akses }}
                                </span>
                                @endforeach
                            </div>
                        </td>
                        {{-- AKSI --}}
                        <td>
                            <div class="d-flex justify-content-center gap-2 flex-wrap">
                                {{-- DETAIL --}}
                                <a href="#ModalDetailPengguna" data-bs-toggle="modal"
                                    class="btn btn-sm btn-light border rounded-pill"
                                    wire:click.prevent="$emit('detailPengguna', {{ $user['ms_pengguna_id'] }})">
                                    <i class="ri-eye-line me-1">
                                    </i>
                                    Detail
                                </a>
                                {{-- EDIT --}}
                                <a href="#ModalEditPengguna" data-bs-toggle="modal"
                                    class="btn btn-sm btn-warning-subtle text-warning border-0 rounded-pill"
                                    wire:click.prevent="$emit('editPengguna', {{ $user['ms_pengguna_id'] }})">
                                    <i class="ri-pencil-line me-1">
                                    </i>
                                    Edit
                                </a>
                                {{-- RESET --}}
                                <a href="#ModalKonfirmasiReset" data-bs-toggle="modal"
                                    class="btn btn-sm btn-danger-subtle text-danger border-0 rounded-pill"
                                    wire:click.prevent="$emit('resetPassword', {{ $user['ms_pengguna_id'] }})">
                                    <i class="ri-lock-unlock-line me-1">
                                    </i>
                                    Reset
                                </a>
                                {{-- DELETE --}}
                                <a href="#ModalDeletePengguna" data-bs-toggle="modal"
                                    class="btn btn-sm btn-soft-danger rounded-pill"
                                    wire:click.prevent="$emit('deletePengguna', {{ $user['ms_pengguna_id'] }})">
                                    <i class="ri-delete-bin-6-line">
                                    </i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="text-center py-5">
                                <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                    colors="primary:#405189,secondary:#0ab39c" style="width:90px;height:90px">
                                </lord-icon>
                                <h5 class="mt-3 fw-semibold">
                                    Tidak Ada Data Pengguna
                                </h5>
                                <p class="text-muted mb-0">
                                    Belum ditemukan data petugas yang sesuai dengan pencarian.
                                </p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>