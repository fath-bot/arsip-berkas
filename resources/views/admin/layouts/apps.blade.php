<!-- Navbar -->
<x-header></x-header>

<!-- Navbar -->
<x-navbar></x-navbar>

<!-- Sidebar -->
<x-sidebar></x-sidebar>

<!-- Main Content -->
@yield('content')   

<!-- Page Styles Section --> 
@stack('styles')
    
<!-- Page Scripts Section -->
@stack('scripts')

<!-- footer -->
<x-footer></x-footer>