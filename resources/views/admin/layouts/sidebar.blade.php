{{-- Sidebar Blade --}}
<div class="p-4">
    {{-- Logo / Brand --}}
    <div class="mb-8 text-center">
        <a href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('images/logos/ARSIP KITA.png') }}" alt="Logo" class="h-12 mx-auto" />
        </a>
    </div>

    {{-- Menu Utama --}}
    <nav class="menu flex flex-col space-y-2">
        {{-- Dashboard --}}
        <a href="{{ route('admin.dashboard') }}"
            class="flex items-center px-3 py-2 rounded hover:bg-gray-200 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-200' : '' }}">
            <span class="mr-2">
                <!-- Contoh icon SVG dashboard -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18v18H3V3z" />
                </svg>
            </span>
            <span>Dashboard</span>
        </a>

        {{-- Master Data (Accordion / Submenu) --}}
        <div x-data="{ open: {{ request()->routeIs('admin.transaksis.*') ? 'true' : 'false' }} }">
            <button @click="open = !open"
                class="flex items-center justify-between w-full px-3 py-2 rounded hover:bg-gray-200 {{ request()->routeIs('admin.transaksis.*') ? 'bg-gray-200' : '' }}">
                <div class="flex items-center">
                    <span class="mr-2">
                        <!-- Contoh icon folder -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 7h4l2 2h10a2 2 0 012 2v7H3V7z" />
                        </svg>
                    </span>
                    <span>Master Data</span>
                </div>
                <span>
                    <!-- Panah kecil -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform" :class="{ 'rotate-90': open }"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </span>
            </button>

            <div x-show="open" class="ml-6 mt-1 space-y-1">
                <a href="{{ route('admin.transaksis.index') }}"
                    class="block px-3 py-2 rounded hover:bg-gray-200 {{ request()->routeIs('admin.transaksis.index') ? 'bg-gray-200' : '' }}">
                    Data Peminjaman Berkas
                </a>
                {{-- Tambahkan submenu lain jika perlu --}}
            </div>
        </div>
    </nav>
</div>
