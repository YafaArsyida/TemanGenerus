 <div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        {{-- <a href="index.html" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{asset('assets')}}/images/logo-sm.png" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{asset('assets')}}/images/logo-dark.png" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="index.html" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{asset('assets')}}/images/logo-sm.png" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{asset('assets')}}/images/logo-light.png" alt="" height="17">
            </span>
        </a> --}}
        <a href="index.html" class="logo logo-dark">
            <span class="logo-sm">
                <span class="fw-bold fs-5">Teman</span>
            </span>
            <span class="logo-lg">
                <span class="fw-bold fs-4">TemanGenerus</span>
            </span>
        </a>
        <!-- Light Logo-->
        <a href="index.html" class="logo logo-light">
            <span class="logo-sm">
                <span class="fw-bold fs-5">Teman</span>
            </span>
            <span class="logo-lg">
                <span class="fw-bold fs-4">TemanGenerus</span>
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid" style="max-width: 100%">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="nav-item">
                    <a href="{{ route('dashboard.index') }}"
                        class="nav-link menu-link {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="menu-title"><span data-key="t-menu">Administrasi</span></li>
                <!-- Desa & Kelompok -->
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('administrasi.desa-kelompok') ? 'active' : '' }}"
                        href="{{ route('administrasi.desa-kelompok') }}">
                        <i class="mdi mdi-map-marker-multiple-outline"></i>
                        <span>Desa & Kelompok</span>
                    </a>
                </li>
                <!-- Genersi Penerus -->
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('administrasi.generasi-penerus') ? 'active' : '' }}"
                        href="{{ route('administrasi.generasi-penerus') }}">
                        <i class="mdi mdi-account-multiple-outline"></i>
                        <span>Generasi Penerus</span>
                    </a>
                </li>
                {{-- Kegiatan --}}
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('administrasi.kegiatan-generus') ? 'active' : '' }}"
                        href="{{ route('administrasi.kegiatan-generus') }}">
                        <i class="mdi mdi-calendar-check-outline"></i>
                        <span>Kegiatan Generus</span>
                    </a>
                </li>                
                @php($role = auth()->user()->peran)
                
                {{-- DAERAH --}}
                @if(in_array($role, ['SUPERADMIN','DAERAH']))
                {{-- <li class="menu-title"><span data-key="t-menu">Laporan Daerah</span></li> --}}
                {{-- <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('laporan.daerah.rutin') ? 'active' : '' }}"
                        href="{{ route('laporan.daerah.rutin') }}">
                        <i class="mdi mdi-calendar-sync"></i>
                        <span>Laporan Kegiatan Rutin</span>
                    </a>
                </li> --}}
                {{-- <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('laporan.daerah.event') ? 'active' : '' }}"
                        href="{{ route('laporan.daerah.event') }}">
                        <i class="mdi mdi-calendar-check-outline"></i>
                        <span>Laporan Kegiatan Event</span>
                    </a>
                </li> --}}
                @endif
                
                {{-- DESA --}}
                @if(in_array($role, ['SUPERADMIN','DESA']))
                {{-- <li class="menu-title"><span data-key="t-menu">Laporan Desa</span></li> --}}
                {{-- <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('laporan.desa.rutin') ? 'active' : '' }}"
                        href="{{ route('laporan.desa.rutin') }}">
                        <i class="mdi mdi-home-city-outline"></i>
                        <span>Laporan Kegiatan Rutin</span>
                    </a>
                </li> --}}
                {{-- <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('laporan.desa.event') ? 'active' : '' }}"
                        href="{{ route('laporan.desa.event') }}">
                        <i class="mdi mdi-calendar-check-outline"></i>
                        <span>Laporan Kegiatan Event</span>
                    </a>
                </li> --}}
                @endif
                
                {{-- KELOMPOK --}}
                @if(in_array($role, ['SUPERADMIN','KELOMPOK']))
                <li class="menu-title"><span data-key="t-menu">Laporan</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('laporan.kelompok.rutin') ? 'active' : '' }}"
                        href="{{ route('laporan.kelompok.rutin') }}">
                        <i class="mdi mdi-account-group-outline"></i>
                        <span>Laporan Kegiatan Rutin</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('laporan.kelompok.event') ? 'active' : '' }}"
                        href="{{ route('laporan.kelompok.event') }}">
                        <i class="mdi mdi-calendar-check-outline"></i>
                        <span>Laporan Kegiatan Event</span>
                    </a>
                </li>
                @endif
                {{-- <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('administrasi.kegiatan-generus') ? 'active' : '' }}"
                        href="{{ route('administrasi.kegiatan-generus') }}">
                        <i class="mdi mdi-calendar-check-outline"></i>
                        <span>Rekapitulasi Bulanan</span>
                    </a>
                </li> --}}
                <li class="menu-title"><span data-key="t-menu">sistem</span></li>
                <!-- Akses Petugas -->
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('sistem.akses-pengguna') ? 'active' : '' }}"
                        href="{{ route('sistem.akses-pengguna') }}">
                        <i class="mdi mdi-shield-account-outline"></i>
                        <span>Akses Pengguna</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>