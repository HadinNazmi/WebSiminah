<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 ps bg-white"
    id="sidenav-main">
    <div class="sidenav-headers">
        <div class="logo-siminah p-3">
            <a href="{{ route('dashboard') }}">
                <div class="row">
                    <div class="d-flex">
                        <div class="col-6 d-flex align-items-center justify-content-center pe-4">
                            <div class="logo-utama justify-content-center">
                                <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
                                    aria-hidden="true" id="iconSidenav"></i>
                                <img src="{{ asset('siminah-header.png') }}" alt="Logo siminah"><br>
                                <span class="ms-3 font-weight-bold text-dark app-name text-center">&nbsp;Siminah</span>
                            </div>
                        </div>
                        <div class="col-6 ps-1 d-flex align-items-center justify-content-center">
                            <div class="logo-psti">
                                <img src="{{ asset('assets/img/default/logo_psti.png') }}" class=""
                                    alt="Logo PSTI PCR">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="logo-pcr-mobile">
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex align-items-top justify-content-center logo-pcr-sidebar">
                                <img src="{{ asset('assets/img/default/logo_pcr.png') }}"
                                    alt="Logo Politeknik Caltex Riau">
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <hr class="horizontal dark mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-8 text-poppins">Menu
                </h6>
            </li>
            <li class="nav-item">
                <a class="{{ isRouteActive('dashboard') ? 'active bg-gradient-info text-white' : ' text-dark' }} nav-link"
                    href="{{ route('dashboard') }}">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">home</i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>

            @if (isAdminCsr())
                <li class="nav-item">
                    <a class="{{ isRouteActive('admin') ? 'active bg-gradient-info text-white' : (isRouteActive('admin.create') ? 'active bg-gradient-info text-white' : (isRouteActive('admin.edit') ? 'active bg-gradient-info text-white' : 'text-dark')) }} nav-link"
                        href="{{ route('admin') }}">
                        <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">person</i>
                        </div>
                        <span class="nav-link-text ms-1">Admin</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="{{ isRouteActive('kontainer') ? 'active bg-gradient-info text-white' : ' text-dark' }} nav-link"
                        href="{{ route('kontainer') }}">
                        <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">local_drink</i>
                        </div>
                        <span class="nav-link-text ms-1">Kontainer</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="{{ isRouteActive('lokasi') ? 'active bg-gradient-info text-white' : (isRouteActive('lokasi.create') ? 'active bg-gradient-info text-white' : (isRouteActive('lokasi.edit') ? 'active bg-gradient-info text-white' : 'text-dark')) }} nav-link"
                        href="{{ route('lokasi') }}">
                        <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">location_on</i>
                        </div>
                        <span class="nav-link-text ms-1">Lokasi</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="{{ isRouteActive('sumbangan') ? 'active bg-gradient-info text-white' : ' text-dark' }} nav-link"
                        href="{{ route('sumbangan') }}">
                        <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">vertical_align_bottom</i>
                        </div>
                        <span class="nav-link-text ms-1">Sumbangan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="{{ isRouteActive('donatur') ? 'active bg-gradient-info text-white' : (isRouteActive('donatur.getById') ? 'active bg-gradient-info text-white' : 'text-dark') }} nav-link"
                        href="{{ route('donatur') }}">
                        <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">people</i>
                        </div>
                        <span class="nav-link-text ms-1">Donatur</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="{{ isRouteActive('redeem') ? 'active bg-gradient-info text-white' : (isRouteActive('hadiah') ? 'active bg-gradient-info text-white' : 'text-dark') }} nav-link"
                        href="{{ route('hadiah') }}">
                        <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">redeem</i>
                        </div>
                        <span class="nav-link-text ms-1">Hadiah</span>
                    </a>
                </li>
            @endif

            @if (isAdminKelurahan())
                <li class="nav-item">
                    <a class="{{ isRouteActive('sumbangan') ? 'active bg-gradient-info text-white' : (isRouteActive('sumbangan.detail') ? 'active bg-gradient-info text-white' : 'text-dark') }} nav-link"
                        href="{{ route('sumbangan') }}">
                        <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">vertical_align_bottom</i>
                        </div>
                        <span class="nav-link-text ms-1">Sumbangan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="{{ isRouteActive('kontainer') ? 'active bg-gradient-info text-white' : ' text-dark' }} nav-link"
                        href="{{ route('kontainer') }}">
                        <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">local_drink</i>
                        </div>
                        <span class="nav-link-text ms-1">Kontainer</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="{{ isRouteActive('donatur') ? 'active bg-gradient-info text-white' : (isRouteActive('donatur.getById') ? 'active bg-gradient-info text-white' : 'text-dark') }} nav-link"
                        href="{{ route('donatur') }}">
                        <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">people</i>
                        </div>
                        <span class="nav-link-text ms-1">Donatur</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="{{ isRouteActive('redeem') ? 'active bg-gradient-info text-white' : (isRouteActive('redeem.detail') ? 'active bg-gradient-info text-white' : 'text-dark') }} nav-link"
                        href="{{ route('redeem') }}">
                        <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">redeem</i>
                        </div>
                        <span class="nav-link-text ms-1">Hadiah</span>
                    </a>
                </li>

                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-8">Account pages
                    </h6>
                </li>
                <li class="nav-item">
                    <a class="{{ isRouteActive('profil') ? 'active bg-gradient-info text-white' : (isRouteActive('profil.edit') ? 'active bg-gradient-info text-white' : 'text-dark') }} nav-link"
                        href="{{ route('profil') }}">
                        <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">account_circle</i>
                        </div>
                        <span class="nav-link-text ms-1">Profile</span>
                    </a>
                </li>
            @endif




            {{-- <li class="nav-item">
                <a class="nav-link text-dark" href="##"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">logout</i> --}}
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
            {{-- </div>
                    <span class="nav-link-text ms-1">Log Out</span>
                </a>
            </li> --}}
        </ul>
    </div>
</aside>
