 <nav class="navbar navbar-expand navbar-light">
        <div class="container-fluid">
            <!-- Sidebar Toggle Button -->
            <button class="sidebar-toggle me-3" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
            
            <!-- Brand -->
            <!-- <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('images/logos/ARSIP KITA.png') }}" alt="Arsip Kita Logo" class="logo">
                <span>Arsip Kita</span>
            </a> -->
             @php
                $dashboardRoute = session('role') === 'user' ? 'user.dashboard' : 'admin.dashboard';
            @endphp
            <a class="navbar-brand {{ request()->routeIs($dashboardRoute) ? 'active' : '' }}" href="{{ route($dashboardRoute) }}">
                <img src="{{ asset('images/logos/ARSIP KITA.png') }}" alt="Arsip Kita Logo" class="logo">
                <span>Arsip Kita</span>
            </a>
            
            <!-- Navbar Items -->
            <ul class="navbar-nav ms-auto">
                 <!-- User Dropdown -->
                <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-user"></i>
        <span class="d-none d-lg-inline">
            {{ session('user_name', 'Admin') }}
        </span>
    </a>

    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
        <li>
            <!-- Tombol logout sebagai link dengan form tersembunyi -->
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
            </a>
        </li>
    </ul>
</li>

            </ul>
        </div>
    </nav>