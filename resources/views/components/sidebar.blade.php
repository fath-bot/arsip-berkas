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
        @php
            $dashboardRoute = session('role') === 'user' ? 'user.dashboard' : 'admin.dashboard';
        @endphp
        <a class="nav-link {{ request()->routeIs($dashboardRoute) ? 'active' : '' }}" href="{{ route($dashboardRoute) }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span class="sidebar-text">Dashboard</span>
        </a>
    </li>

    @if(in_array(session('role'), ['admin', 'superadmin']))
        <!-- Master Data -->
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.transaksis.index') ? 'active' : '' }}" href="{{ route('admin.transaksis.index') }}">
                <i class="fas fa-fw fa-file-alt"></i>
                <span class="sidebar-text">Data Peminjaman</span>
            </a>
        </li>

        <!-- Management Arsip -->
        <li class="nav-item">
            @php
                $arsipActive = request()->is('admin/arsip/*');
            @endphp

            <a class="nav-link d-flex justify-content-between align-items-center {{ $arsipActive ? '' : 'collapsed' }}"
               data-bs-toggle="collapse"
               href="#arsipSubmenu"
               role="button"
               aria-expanded="{{ $arsipActive ? 'true' : 'false' }}"
               aria-controls="arsipSubmenu"
               id="arsipMenuLink"  
               style="{{ $arsipActive ? 'background-color: #0d6efd; color: white;' : '' }}">
                <div>
                    <i class="fas fa-fw fa-folder"></i>
                    <span class="sidebar-text">Management Arsip</span>
                </div>
                <i class="fas fa-chevron-down small"></i>
            </a>

            <div class="collapse {{ $arsipActive ? 'show' : '' }}" id="arsipSubmenu">
                <ul class="nav flex-column ms-4">
                    @foreach(['ijazah', 'pangkat', 'cpns', 'jabatan', 'mutasi', 'pemberhentian'] as $type)
                        @php
                            $isTypeActive = request()->is('admin/arsip/'.$type.'*');
                        @endphp
                        <li class="nav-item">
                            <a class="nav-link {{ $isTypeActive ? 'active' : '' }}"
                               href="{{ route('admin.arsip.index', ['type' => $type]) }}"
                               style="{{ $isTypeActive ? 'background-color: #cfe2ff; color: #084298;' : '' }}">
                                <i class="fas fa-angle-right me-1"></i>
                                {{ ucfirst($type) }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </li>
    @endif
</ul>

</div>

<!-- Sidebar Toggle Script -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const footer = document.querySelector('.footer');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const arsipMenuLink = document.getElementById('arsipMenuLink');

        // Fungsi untuk toggle sidebar
        function toggleSidebar(shouldCollapse = null) {
            const isCollapsed = sidebar.classList.contains('sidebar-collapsed');
            const collapse = shouldCollapse !== null ? shouldCollapse : !isCollapsed;
            
            if (collapse) {
                sidebar.classList.add('sidebar-collapsed');
                if (mainContent) mainContent.classList.add('main-content-collapsed');
                if (footer) footer.classList.add('footer-collapsed');
                
                // Tutup semua submenu saat minimize
                const submenu = document.getElementById('arsipSubmenu');
                if (submenu && submenu.classList.contains('show')) {
                    const bsCollapse = new bootstrap.Collapse(submenu, {
                        toggle: true
                    });
                    bsCollapse.hide();
                    if (arsipMenuLink) {
                        arsipMenuLink.setAttribute('aria-expanded', 'false');
                        arsipMenuLink.classList.add('collapsed');
                    }
                }
                
                // Hapus event listener klik luar
                document.removeEventListener('click', handleClickOutside);
            } else {
                sidebar.classList.remove('sidebar-collapsed');
                if (mainContent) mainContent.classList.remove('main-content-collapsed');
                if (footer) footer.classList.remove('footer-collapsed');
                
                // Tambahkan event listener klik luar
                document.addEventListener('click', handleClickOutside);
            }
            
            // Simpan state sidebar di localStorage
            localStorage.setItem('sidebarCollapsed', collapse);
        }

        // Fungsi untuk menangani klik di luar sidebar
        function handleClickOutside(event) {
            const isClickInsideSidebar = sidebar.contains(event.target);
            const isClickOnToggle = sidebarToggle && sidebarToggle.contains(event.target);
            const isClickOnNavbar = event.target.closest('.navbar') !== null;
            
            if (!isClickInsideSidebar && !isClickOnToggle && !isClickOnNavbar) {
                toggleSidebar(true); // Minimize sidebar
                if(window.innerWidth < 768){ 
                    toggleSidebar(false)
                }else{
                    
                }
            }
        }

        // Inisialisasi state sidebar dari localStorage
        const savedState = localStorage.getItem('sidebarCollapsed');
        const initialCollapse = savedState === 'true' || (window.innerWidth < 768 && savedState !== 'false');
        
        if (initialCollapse) {
            toggleSidebar(false);
        } else {
            // Hanya pasang event listener jika sidebar expanded
            document.addEventListener('click', handleClickOutside);
        }

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function() {
                toggleSidebar();
            });
        }

        // Handle klik menu arsip
        if (arsipMenuLink) {
            arsipMenuLink.addEventListener('click', function(e) {
                if (sidebar.classList.contains('sidebar-collapsed')) {
                    toggleSidebar(false);
                }
            });
        }
    });
</script>