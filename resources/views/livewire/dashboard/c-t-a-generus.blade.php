<div class="card shadow-sm border-0 mb-0">
    <div class="card-body p-0">
        <!-- Alert CTA -->
        <div class="alert alert-primary border-0 rounded-0 m-0 d-flex align-items-center" role="alert">
            <i class="bx bx-group text-primary me-2 fs-4"></i>
            <div class="flex-grow-1 text-truncate">
                Kelola data <strong>Generus</strong> dengan lebih rapi dan terstruktur.
            </div>
            <div class="flex-shrink-0">
                <a href="{{ route('administrasi.generasi-penerus') }}" 
                   class="fw-semibold text-decoration-underline text-primary">
                    Buka Data
                </a>
            </div>
        </div>

        <!-- Body CTA -->
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="p-4">
                    <h5 class="fw-bold mb-2">Manajemen Data Generus</h5>
                    <p class="mb-3 text-muted">
                        Akses dan kelola seluruh data generus mulai dari identitas, 
                        kelompok, hingga status keaktifan dalam satu sistem terpusat.
                    </p>

                    <a href="{{ route('administrasi.generasi-penerus') }}" 
                       class="btn btn-primary btn-lg">
                        <i class="bx bx-user align-middle me-1"></i>
                        Kelola Generus Sekarang
                    </a>
                </div>
            </div>

            <div class="col-md-4 text-end">
                <img src="{{ asset('assets/images/user-illustarator-2.png') }}" 
                     class="img-fluid"
                     alt="Illustrasi Generus">
            </div>
        </div>
    </div>
</div>