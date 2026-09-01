<!-- Wrapper Induk Layout -->
<div x-data="{ sidebarOpen: false }" class="relative min-h-screen bg-slate-100 flex">

    <!-- 1. OVERLAY MASK (Hanya Muncul di Mobile Saat Sidebar Terbuka) -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" class="fixed inset-0 bg-slate-900/60 z-40 md:hidden backdrop-blur-sm" x-cloak>
    </div>

    <!-- 2. SIDEBAR (Desktop Fixed & Mobile Slide-over) -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 text-slate-300 flex flex-col justify-between transition-transform duration-300 ease-in-out md:translate-x-0 md:static md:z-auto shrink-0">

        <div>
            <!-- Header Sidebar & Tombol Close Mobile -->
            <div class="h-16 flex items-center justify-between px-6 border-b border-slate-800">
                <div class="flex items-center space-x-3">
                    <div
                        class="w-9 h-9 bg-indigo-600 text-white rounded-lg flex items-center justify-center font-extrabold text-lg shadow-md shadow-indigo-600/30">
                        P
                    </div>
                    <span class="font-bold text-lg text-white tracking-wide">PinjamAlat</span>
                </div>
                <!-- Tombol Tutup Sidebar di Mobile -->
                <button @click="sidebarOpen = false"
                    class="md:hidden text-slate-400 hover:text-white focus:outline-none">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <!-- Menu Navigasi -->
            <nav class="sticky top-0 p-4 space-y-1 overflow-y-auto max-h-[calc(100vh-8rem)]">

                {{-- Dashboard Utama (Berlaku Semua Role) --}}
                <a href="{{ url('/dashboard') }}"
                    class="flex items-center px-3 py-2 text-slate-400 hover:bg-slate-800 hover:text-white rounded-lg transition text-sm font-medium">
                    <i class="fa-solid fa-chart-line w-6 text-slate-500"></i> Dashboard
                </a>

                {{-- Fitur khusus Admin --}}
                @if (Auth::user()?->role === 'admin')
                    <div class="pt-4">
                        <p class="px-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Manajemen
                            Admin
                        </p>
                        <a href="{{ url('/admin/user') }}"
                            class="flex items-center px-3 py-2 text-slate-400 hover:bg-slate-800 hover:text-white rounded-lg transition text-sm font-medium">
                            <i class="fa-solid fa-users w-6 text-slate-500"></i> Kelola User
                        </a>
                        <a href="{{ url('/admin/alat') }}"
                            class="flex items-center px-3 py-2 text-slate-400 hover:bg-slate-800 hover:text-white rounded-lg transition text-sm font-medium">
                            <i class="fa-solid fa-screwdriver-wrench w-6 text-slate-500"></i> Kelola Alat
                        </a>
                        <a href="{{ url('/admin/kategori') }}"
                            class="flex items-center px-3 py-2 text-slate-400 hover:bg-slate-800 hover:text-white rounded-lg transition text-sm font-medium">
                            <i class="fa-solid fa-tags w-6 text-slate-500"></i> Kelola Kategori
                        </a>
                        <a href="{{ url('/admin/log') }}"
                            class="flex items-center px-3 py-2 text-slate-400 hover:bg-slate-800 hover:text-white rounded-lg transition text-sm font-medium">
                            <i class="fa-solid fa-clock-rotate-left w-6 text-slate-500"></i> Log Aktivitas
                        </a>
                    </div>
                @endif

                {{-- Fitur khusus Petugas --}}
                @if (Auth::user()?->role === 'petugas')
                    <div class="pt-4">
                        <p class="px-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Menu Petugas
                        </p>
                        <a href="{{ url('/petugas/persetujuan') }}"
                            class="flex items-center px-3 py-2 text-slate-400 hover:bg-slate-800 hover:text-white rounded-lg transition text-sm font-medium">
                            <i class="fa-solid fa-clipboard-check w-6 text-slate-500"></i> Persetujuan Pinjam
                        </a>
                        <a href="{{ url('/petugas/laporan') }}"
                            class="flex items-center px-3 py-2 text-slate-400 hover:bg-slate-800 hover:text-white rounded-lg transition text-sm font-medium">
                            <i class="fa-solid fa-file-invoice w-6 text-slate-500"></i> Cetak Laporan
                        </a>
                    </div>
                @endif

                {{-- Fitur khusus Peminjam --}}
                @if (Auth::user()?->role === 'peminjam')
                    <div class="pt-4">
                        <p class="px-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Menu Peminjam
                        </p>
                        <a href="{{ url('/peminjam/katalog') }}"
                            class="flex items-center px-3 py-2 text-slate-400 hover:bg-slate-800 hover:text-white rounded-lg transition text-sm font-medium ">
                            <i class="fa-solid fa-layer-group w-6 text-slate-500"></i> Katalog Alat
                        </a>
                        <a href="{{ url('/peminjam/pinjaman') }}"
                            class="flex items-center px-3 py-2 text-slate-400 hover:bg-slate-800 hover:text-white rounded-lg transition text-sm font-medium">
                            <i class="fa-solid fa-hand-holding w-6 text-slate-500"></i> Pinjaman Saya
                        </a>
                    </div>
                @endif
            </nav>
        </div>

        <!-- User Profile Info & Logout Button -->
        <div class="p-4 border-t border-slate-800 flex items-center justify-between bg-slate-900/50">
            <div class="flex items-center space-x-3">
                @php
$initial = strtoupper(substr(auth()->user()->username ?? 'U', 0, 1));
                @endphp
                <div
                    class="w-9 h-9 rounded-full bg-indigo-600 text-white font-bold flex items-center justify-center text-xs shadow-sm">
                    {{ $initial }}
                </div>
                <div class="text-xs">
                    <p class="font-semibold text-white truncate max-w-[100px]">{{ auth()->user()->username ?? 'User' }}
                    </p>
                    <p class="text-[10px] text-slate-400 capitalize">{{ Auth::user()->role ?? 'Guest' }}</p>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="text-slate-400 hover:text-rose-400 p-2 rounded-lg hover:bg-slate-800 transition"
                    title="Logout">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </button>
            </form>
        </div>
    </aside>

    <!-- 3. KONTEN UTAMA + NAVBAR HEADER GLOBAL (Tampil di Desktop & Mobile) -->
    <div class="flex-1 flex flex-col min-w-0">

        <!-- Header Atas (Sekarang Tampil Responsif di Semua Ukuran Layar) -->
        <header
            class="h-16 bg-white border-b border-slate-200 px-4 sm:px-6 flex items-center justify-between sticky top-0 z-30 shadow-sm">
            <div class="flex items-center space-x-3">
                <!-- Tombol Hamburger (Khusus Mobile) -->
                <button @click="sidebarOpen = true"
                    class="md:hidden p-2 text-slate-600 hover:bg-slate-100 rounded-lg focus:outline-none">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
                <h1 class="font-bold text-slate-700 text-base sm:text-lg">Dashboard</h1>
            </div>

            <!-- Status Role Kanan Atas -->
            <span
                class="px-3 py-1 bg-indigo-50 text-indigo-700 text-xs font-semibold rounded-full border border-indigo-100 shadow-sm">
                Status: Login sebagai <span class="capitalize">{{ auth()->user()->role ?? 'Peminjam' }}</span>
            </span>
        </header>

        <!-- Area Main Content (Dengan Spacing / Margin yang Rapi) -->
        <main class="p-4 sm:p-6 md:p-8 flex-1 overflow-y-auto">
            @yield('content')
        </main>
    </div>

</div>

<!-- Dependencies Script -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
