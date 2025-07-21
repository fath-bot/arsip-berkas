@php
    use Illuminate\Support\Str;
    use App\Models\ArsipJenis;

    // Pastikan $arsipJenisList tersedia (bisa di-share lewat AppServiceProvider)
    $arsipJenisList = $arsipJenisList ?? ArsipJenis::all();
@endphp

<div class="sidebar" id="sidebar">
    <!-- Sidebar Brand -->
    <a class="sidebar-brand" href="#">
        <div class="sidebar-brand-icon"><i class="fas fa-archive"></i></div>
        <div class="sidebar-brand-text">Arsip Kita</div>
    </a>
    <hr class="sidebar-divider my-0">

    <ul class="sidebar-nav">
        <!-- dashboard -->
        <li class="nav-item">
            @php
                $dashboardRoute = session('role') === 'user'
                    ? 'user.dashboard'
                    : (session('role') === 'superadmin'
                        ? 'superadmin.dashboard'
                        : 'admin.dashboard');
            @endphp
            <a class="nav-link {{ request()->routeIs($dashboardRoute) ? 'active' : '' }}"
               href="{{ route($dashboardRoute) }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span class="sidebar-text">Dashboard</span>
            </a>
        </li>

        <!-- admin -->
        @if(in_array(session('role'), ['admin', 'superadmin']))
            <!-- Admin: Data Peminjaman -->
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.transaksis.*') ? 'active' : '' }}"
                   href="{{ route('admin.transaksis.index') }}">
                    <i class="fas fa-fw fa-file-alt"></i>
                    <span class="sidebar-text">Data Peminjaman</span>
                </a>
            </li>

            <!-- Admin: Arsip -->
            @php $arsipOpen = request()->is('admin/arsip/*'); @endphp
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center {{ $arsipOpen ? '' : 'collapsed' }}"
                   data-bs-toggle="collapse"
                   href="#adminArsipMenu"
                   aria-expanded="{{ $arsipOpen ? 'true' : 'false' }}"
                   aria-controls="adminArsipMenu">
                    <div>
                        <i class="fas fa-fw fa-folder"></i>
                        <span class="sidebar-text">Management Arsip</span>
                    </div>
                    <i class="fas fa-chevron-down small"></i>
                </a>
                <div class="collapse {{ $arsipOpen ? 'show' : '' }}" id="adminArsipMenu">
                    <ul class="nav flex-column ms-4">
                        @foreach($arsipJenisList as $jenis)
                            @php
                                $slug = Str::slug($jenis->nama_jenis);
                                $active = request()->is("admin/arsip/{$slug}*");
                            @endphp
                            <li class="nav-item">
                                <a class="nav-link {{ $active ? 'active' : '' }}"
                                   href="{{ route('admin.arsip.index', ['type' => $slug]) }}">
                                    <i class="fas fa-angle-right me-1"></i>
                                    {{ $jenis->nama_jenis }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </li>
        @endif

        <!-- user -->
        @if(session('role') === 'user')
            <!-- User: Data Peminjaman -->
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('user.transaksis.*') ? 'active' : '' }}"
                   href="{{ route('user.transaksis.index') }}">
                    <i class="fas fa-fw fa-file-alt"></i>
                    <span class="sidebar-text">Data Peminjaman</span>
                </a>
            </li>
             
            <!-- User: Arsip -->
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('user.arsip.index') ? 'active' : '' }}"
                href="{{ route('user.arsip.index') }}">
                    <i class="fas fa-fw fa-folder-open"></i>
                    <span class="sidebar-text">Master Arsip</span>
                </a>
            </li>
 
        @endif
    </ul>
</div>

{{-- Sidebar Toggle Script --}}

<script>
document.addEventListener('DOMContentLoaded', function () {
  const sidebar       = document.getElementById('sidebar');
  const mainContent   = document.getElementById('mainContent');
  const footer        = document.querySelector('.footer');
  const sidebarToggle = document.getElementById('sidebarToggle');

  // handleClickOutside: tutup sidebar kalau klik di luar
  function handleClickOutside(e) {
    const inside = sidebar.contains(e.target);
    const onToggle = sidebarToggle?.contains(e.target);
    const onNav = !!e.target.closest('.navbar');

    if (!inside && !onToggle && !onNav) {
      toggleSidebar(true); 
      if (window.innerWidth < 768) toggleSidebar(false, false);
    }
  }

  /**
   * @param {boolean|null} shouldCollapse   
   * @param {boolean}     attachOutside     
   */
  function toggleSidebar(shouldCollapse = null, attachOutside = true) {
    const isCollapsed = sidebar.classList.contains('sidebar-collapsed');
    const doCollapse = shouldCollapse === null ? !isCollapsed : shouldCollapse;

    if (doCollapse) {
      // collapse: hide semua submenu & remove outside listener
      sidebar.classList.add('sidebar-collapsed');
      mainContent?.classList.add('main-content-collapsed');
      footer?.classList.add('footer-collapsed');

      document.querySelectorAll('#sidebar .collapse.show').forEach(el => {
        bootstrap.Collapse.getOrCreateInstance(el, { toggle: false }).hide();
      });
      document.querySelectorAll('#sidebar [data-bs-toggle="collapse"]').forEach(t => {
        t.classList.add('collapsed');
        t.setAttribute('aria-expanded', 'false');
      });

      if (attachOutside) {
        document.removeEventListener('click', handleClickOutside);
      }
    } else {
      // expand: jangan close submenu; tambahkan outside listener jika diminta
      sidebar.classList.remove('sidebar-collapsed');
      mainContent?.classList.remove('main-content-collapsed');
      footer?.classList.remove('footer-collapsed');

      if (attachOutside) {
        document.addEventListener('click', handleClickOutside);
      }
    }

    localStorage.setItem('sidebarCollapsed', doCollapse);
  }

  // inisialisasi state dari localStorage / lebar layar
  const saved = localStorage.getItem('sidebarCollapsed');
  const startCollapsed = (saved === 'true') || (window.innerWidth < 768 && saved !== 'false');
  if (startCollapsed) {
    toggleSidebar(true, false);
  } else {
    toggleSidebar(false, true);
  }

  // toggle utama
  sidebarToggle?.addEventListener('click', (e) => {
    e.stopPropagation();
    toggleSidebar();
  });

  // override klik pada semua toggler submenu
  document.querySelectorAll('#sidebar [data-bs-toggle="collapse"]').forEach(toggler => {
    toggler.addEventListener('click', function (e) {
      const targetSel = this.getAttribute('href') || this.dataset.bsTarget;
      const collapseEl = document.querySelector(targetSel);

      // kalau sidebar masih collapsed, expand dulu tanpa outside listener
      if (sidebar.classList.contains('sidebar-collapsed')) {
        e.preventDefault();
        e.stopPropagation();
        toggleSidebar(false, false);
        bootstrap.Collapse.getOrCreateInstance(collapseEl, { toggle: false }).show();
        // setelah expand+show, kita bisa tambahkan outside listener
        document.addEventListener('click', handleClickOutside);
      }
      // kalau sudah expand, biar bootstrap handle show/hide submenu
    });
  });
});
</script>
