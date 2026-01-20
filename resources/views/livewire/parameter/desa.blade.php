<div class="mt-3 mt-lg-0">
    <div class="row g-3 mb-0 align-items-center">
        <div class="col-sm-auto">
            <div class="input-group">
                <select wire:model="selectedDesa" style="cursor: pointer"
                    class="form-select border-0 dash-filter-picker shadow" data-bs-toggle="tooltip"
                    data-bs-trigger="hover" data-bs-placement="top" title="Pilih Desa">
                    {{-- <option value="" selected disabled>Pilih Desa</option> --}}
                    @foreach ($select_desa as $item)
                    <option value="{{ $item->ms_desa_id }}">Desa {{ $item->nama_desa }}</option>
                    @endforeach
                </select>
                <div class="input-group-text bg-primary border-primary text-white">
                    <i class=" ri-government-line"></i>
                </div>
            </div>
        </div>
        <!--end col-->
    </div>
    <script>
        document.addEventListener('livewire:load', function () {
            Livewire.emit('parameterUpdated', @json($selectedDesa));
        });
    </script>
</div>