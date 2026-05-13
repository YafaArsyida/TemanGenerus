<div>
    <div wire:ignore.self class="modal fade zoomIn" id="ModalKonfirmasiReset" tabindex="-1"
        aria-labelledby="ModalKonfirmasiResetLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 overflow-hidden shadow-lg">
                {{-- HEADER --}}
                <div class="modal-header border-0 bg-light-subtle px-4 py-3">
                    <div>
                        <h5 class="modal-title fw-bold mb-1" id="ModalKonfirmasiResetLabel">
                            <i class="ri-lock-password-line text-danger me-1">
                            </i>
                            Reset Password Pengguna
                        </h5>
                        <small class="text-muted">
                            Tindakan ini akan mengatur ulang password akun pengguna
                        </small>
                    </div>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal">
                    </button>
                </div>
                {{-- BODY --}}
                <div class="modal-body text-center px-5 py-5">
                    {{-- ICON --}}
                    <div class="mb-4">
                        <div class="avatar-xl mx-auto">
                            <div class="avatar-title bg-danger-subtle text-danger rounded-circle shadow-sm">
                                <lord-icon src="https://cdn.lordicon.com/dxjqoygy.json" trigger="loop"
                                    colors="primary:#dc3545,secondary:#f06548" style="width:70px;height:70px">
                                </lord-icon>
                            </div>
                        </div>
                    </div>
                    {{-- TITLE --}}
                    <h4 class="fw-bold mb-2">
                        Konfirmasi Reset Password
                    </h4>
                    {{-- DESCRIPTION --}}
                    <p class="text-muted fs-15 mb-4 mx-auto" style="max-width: 420px;">
                        Password pengguna akan direset ke password default sistem. Pastikan tindakan
                        ini dilakukan dengan persetujuan atau kebutuhan administrasi.
                    </p>
                    {{-- ALERT --}}
                    <div class="alert alert-warning border-0 rounded-4 text-start d-flex align-items-start mb-4">
                        <div class="me-3 fs-3">
                            <i class="ri-error-warning-line">
                            </i>
                        </div>
                        <div>
                            <div class="fw-semibold mb-1">
                                Perhatian
                            </div>
                            <small class="text-muted">
                                Setelah password direset, pengguna perlu login ulang menggunakan password
                                baru.
                            </small>
                        </div>
                    </div>
                    {{-- ACTION --}}
                    <div class="hstack gap-2 justify-content-center flex-wrap">
                        {{-- CANCEL --}}
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">
                            <i class="ri-close-line me-1">
                            </i>
                            Batal
                        </button>
                        {{-- RESET --}}
                        <button type="button" class="btn btn-danger rounded-pill px-4" wire:click="resetPass">
                            <i class="ri-refresh-line me-1">
                            </i>
                            Ya, Reset Password
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>