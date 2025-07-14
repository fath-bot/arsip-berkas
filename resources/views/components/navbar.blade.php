 <nav class="navbar navbar-expand navbar-light">
        <div class="container-fluid">
            <!-- Sidebar Toggle Button -->
            <button class="sidebar-toggle me-3" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
            
            <!-- Brand -->
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('images/logos/ARSIP KITA.png') }}" alt="Arsip Kita Logo" class="logo">
                <span>Arsip Kita</span>
            </a>
            
            <!-- Navbar Items -->
            <ul class="navbar-nav ms-auto">
                <!-- Notifications -->
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" id="notificationsDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-bell"></i>
                        <span class="badge bg-danger rounded-pill">3</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="#"><i class="fas fa-file me-2"></i> Request pengambilan Arsip</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#"><i class="fas fa-file me-2"></i> (NIPxxxxxx) ingin mengambil arsip xxx</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#"><i class="fas fa-file me-2"></i> Notifikasi</a>
                        <div class="dropdown-divider"></div>
                    </div>  
                    
                </li>
                
                <!-- Messages -->
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" id="messagesDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-envelope"></i>
                        <span class="badge bg-success rounded-pill">7</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="#"><i class="fas fa-file me-2"></i> Notifikasi arsip Sudah siap diambil</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#"><i class="fas fa-file me-2"></i> Arsip kamu siap diambil diruangan </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#"><i class="fas fa-file me-2"></i> Notifikasi</a>
                        <div class="dropdown-divider"></div>
                    </div>
                </li>
                
                <!-- User Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user"></i>
                        <span class="d-none d-lg-inline">Admin</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="#"><i class="fas fa-user fa-sm me-2"></i> Profile</a>
                        <a class="dropdown-item" href="#"><i class="fas fa-cog fa-sm me-2"></i> Settings</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt fa-sm me-2"></i> Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>