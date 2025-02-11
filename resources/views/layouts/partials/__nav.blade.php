<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="#" class="logo logo-dark">
            <span class="logo-sm">
                <img src="assets/images/logo-sm.png" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="assets/images/logo-dark.png" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="#" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('assets/images/icon-customer-service.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('assets/images/icon-customer-service.png') }}" alt="" height="40"> <span class="text-light fw-bolder">Sistem Reservasi</span>
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>

            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>

                @if(Auth::user()->role_id == 3)
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#">
                        <i class="ri-honour-line"></i> <span data-key="t-widgets">Reservasi Baru</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#">
                        <i class="ri-search-line"></i> <span data-key="t-widgets">Cek Reservasi</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#">
                        <i class="ri-calendar-todo-fill"></i> <span data-key="t-widgets">Kalender</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#">
                        <i class="ri-wallet-fill"></i> <span data-key="t-widgets">Lihat Pembayaran</span>
                    </a>
                </li>
                @endif

                @if(Auth::user()->role_id == 2)
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#">
                            <i class="ri-calendar-todo-fill"></i> <span data-key="t-widgets">Kalender</span>
                        </a>
                    </li>
                @endif

                @if(Auth::user()->role_id == 1)

                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('reservations.index') }}">
                        <i class="ri-honour-line"></i> <span data-key="t-widgets">Kelola Reservasi</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('reservations.calender') }}">
                        <i class="ri-calendar-line"></i> <span data-key="t-widgets">Kalender Reservasi</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#">
                        <i class="ri-wallet-fill"></i> <span data-key="t-widgets">Lihat Pembayaran</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('users.index') }}">
                        <i class="ri-group-fill"></i> <span data-key="t-widgets">Kelola Pengguna</span>
                    </a>
                </li>
                @endif
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
