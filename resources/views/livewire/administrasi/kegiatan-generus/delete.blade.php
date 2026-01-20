<div wire:ignore.self class="modal fade zoomIn" id="ModalDeleteKegiatan" tabindex="-1"
    aria-labelledby="deleteKegiatanLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-5 text-center">

                <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                    colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px">
                </lord-icon>

                <div class="mt-4 text-center">
                    <h4 class="fs-semibold">
                        Anda yakin ingin menghapus kegiatan ini?
                    </h4>

                    <p class="text-muted fs-14 mb-4 pt-1">
                        Data kegiatan akan dihapus permanen dan
                        <strong>tidak dapat dikembalikan</strong>.
                    </p>

                    <div class="hstack gap-2 justify-content-center">
                        <button class="btn btn-link link-success fw-medium shadow-none" data-bs-dismiss="modal">
                            <i class="ri-close-line me-1"></i> Batal
                        </button>

                        <button class="btn btn-danger" wire:click="deleteKegiatan">
                            <i class="ri-delete-bin-6-line me-1"></i>
                            Ya, Hapus!
                        </button>
                    </div>
                </div>

            </div>

        </div>
    </div>

</div>