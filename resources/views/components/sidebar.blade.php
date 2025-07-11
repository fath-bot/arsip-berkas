<div class="sidebar" id="sidebar">
        <!-- Sidebar Brand -->
        <a class="sidebar-brand" href="#">
            <div class="sidebar-brand-icon">
                <i class="fas fa-archive"></i>
            </div>
            <div class="sidebar-brand-text">Arsip Kita</div>
        </a>
        
        <!-- Divider -->
        <hr class="sidebar-divider my-0">
        
        <!-- Nav Items -->
        <ul class="sidebar-nav">
            <!-- Dashboard -->
            <li class="nav-item">
                <a class="nav-link active" href="#">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span class="sidebar-text">Dashboard</span>
                </a>
            </li>
            
            <!-- Master Data -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.transaksis.index') }}">
                    <i class="fas fa-fw fa-file-alt"></i>
                    <span class="sidebar-text">Data Peminjaman</span>
                </a>
            </li>
            
            <!-- Management Arsip -->
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-folder"></i>
                    <span class="sidebar-text">Management Arsip</span>
                </a>
            </li>
        </ul>
    </div>