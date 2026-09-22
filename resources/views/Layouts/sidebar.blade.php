<!-- Wrapper Induk Layout (DIKUNCI SAMA TINGGI LAYAR) -->
<div x-data="{ sidebarOpen: false }" class="relative h-screen w-screen overflow-hidden bg-slate-100 flex">

    <!-- 1. OVERLAY MASK (Mobile Only) -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" class="fixed inset-0 bg-slate-900/60 z-40 md:hidden backdrop-blur-sm" x-cloak>
    </div>

    <!-- 2. SIDEBAR (STAYS FIXED - TIDAK BERGERAK SAMA SEKALI) -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 text-slate-300 flex flex-col justify-between transition-transform duration-300 ease-in-out md:translate-x-0 md:static md:z-auto shrink-0 h-screen">

        <!-- Bagian Atas: Logo + Navigasi -->
        <div class="flex flex-col flex-1 min-h-0">
            <!-- Header Logo Sidebar -->
            <div class="h-16 flex items-center justify-between px-6 border-b border-slate-800 shrink-0">
                <div class="flex items-center space-x-3">
                    <div
                        class="w-9 h-9 bg-indigo-600 text-white rounded-lg flex items-center justify-center font-extrabold text-lg shadow-md shadow-indigo-600/30">
                        P
                    </div>
                    <span class="font-bold text-lg text-white tracking-wide">PinjamAlat</span>
                </div>
                <button @click="sidebarOpen = false"
                    class="md:hidden text-slate-400 hover:text-white focus:outline-none">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <!-- Menu Navigasi (Bisa di-scroll jika menu terlalu banyak) -->
            <nav class="p-4 space-y-1 overflow-y-auto flex-1">

                <a href="{{ url('/dashboard') }}"
                    class="flex items-center px-3 py-2 rounded-lg transition text-sm font-medium {{ request()->is('dashboard*') ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i
                        class="fa-solid fa-chart-line w-6 {{ request()->is('dashboard*') ? 'text-white' : 'text-slate-500' }}"></i>
                    <span>Dashboard</span>
                </a>

                @if (Auth::user()?->role === 'admin')
                    <div class="pt-4">
                        <p class="px-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Manajemen
                            Admin
                        </p>

                        <a href="{{ url('/admin/user') }}"
                            class="flex items-center px-3 py-2 rounded-lg transition text-sm font-medium {{ request()->is('admin/user*') ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                            <i
                                class="fa-solid fa-users w-6 {{ request()->is('admin/user*') ? 'text-white' : 'text-slate-500' }}"></i>
                            Kelola User
                        </a>

                        <a href="{{ url('/admin/alat') }}"
                            class="flex items-center px-3 py-2 rounded-lg transition text-sm font-medium {{ request()->is('admin/alat*') ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                            <i
                                class="fa-solid fa-screwdriver-wrench w-6 {{ request()->is('admin/alat*') ? 'text-white' : 'text-slate-500' }}"></i>
                            Kelola Alat
                        </a>

                        <a href="{{ url('/admin/kategori') }}"
                            class="flex items-center px-3 py-2 rounded-lg transition text-sm font-medium {{ request()->is('admin/kategori*') ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                            <i
                                class="fa-solid fa-tags w-6 {{ request()->is('admin/kategori*') ? 'text-white' : 'text-slate-500' }}"></i>
                            Kelola Kategori
                        </a>

                        <a href="{{ url('/admin/log') }}"
                            class="flex items-center px-3 py-2 rounded-lg transition text-sm font-medium {{ request()->is('admin/log*') ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                            <i
                                class="fa-solid fa-clock-rotate-left w-6 {{ request()->is('admin/log*') ? 'text-white' : 'text-slate-500' }}"></i>
                            Log Aktivitas
                        </a>
                        <div class="pt-4">
                            <p class="px-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Pinjam
                                alat
                            </p>
                            <a href="{{ url('/admin/katalog') }}"
                                class="flex items-center px-3 py-2 rounded-lg transition text-sm font-medium {{ request()->is('admin/katalog*') ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                                <i
                                    class="fa-solid fa-layer-group w-6 {{ request()->is('admin/katalog*') ? 'text-white' : 'text-slate-500' }}"></i>
                                Katalog Alat
                            </a>

                            <a href="{{ url('/admin/pinjaman/' . auth()->id()) }}"
                                class="flex items-center px-3 py-2 rounded-lg transition text-sm font-medium {{ request()->is('admin/pinjaman*') ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                                <i
                                    class="fa-solid fa-hand-holding w-6 {{ request()->is('admin/pinjaman*') ? 'text-white' : 'text-slate-500' }}"></i>
                                Pinjaman Saya
                            </a>
                            <a href="{{ url('/admin/histori/' . auth()->id()) }}"
                                class="flex items-center px-3 py-2 rounded-lg transition text-sm font-medium {{ request()->is('admin/histori*') ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                                <i
                                    class="fa-solid fa-clock-rotate-left w-6 {{ request()->is('admin/histori*') ? 'text-white' : 'text-slate-500' }}"></i>
                                <span>Histori Peminjaman</span>
                            </a>
                        </div>
                    </div>
                @endif

                @if (Auth::user()?->role === 'petugas')
                    <div class="pt-4">
                        <p class="px-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Menu Petugas
                        </p>

                        <a href="{{ url('/petugas/persetujuan') }}"
                            class="flex items-center px-3 py-2 rounded-lg transition text-sm font-medium {{ request()->is('petugas/persetujuan*') ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                            <i
                                class="fa-solid fa-clipboard-check w-6 {{ request()->is('petugas/persetujuan*') ? 'text-white' : 'text-slate-500' }}"></i>
                            Persetujuan Pinjam
                        </a>

                        <a href="{{ url('/petugas/laporan') }}"
                            class="flex items-center px-3 py-2 rounded-lg transition text-sm font-medium {{ request()->is('petugas/laporan*') ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                            <i
                                class="fa-solid fa-file-invoice w-6 {{ request()->is('petugas/laporan*') ? 'text-white' : 'text-slate-500' }}"></i>
                            Cetak Laporan
                        </a>
                        <a href="{{ url('/petugas/daftar') }}"
                            class="flex items-center px-3 py-2 rounded-lg transition text-sm font-medium {{ request()->is('petugas/daftar*') ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                            <i
                                class="fa-solid fa-list w-6 {{ request()->is('petugas/laporan*') ? 'text-white' : 'text-slate-500' }}"></i>
                            Daftar peminjam
                        </a>
                    </div>
                @endif

                @if (Auth::user()?->role === 'peminjam')
                    <div class="pt-4">
                        <p class="px-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Menu Peminjam
                        </p>

                        <a href="{{ url('/peminjam/katalog') }}"
                            class="flex items-center px-3 py-2 rounded-lg transition text-sm font-medium {{ request()->is('peminjam/katalog*') ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                            <i
                                class="fa-solid fa-layer-group w-6 {{ request()->is('peminjam/katalog*') ? 'text-white' : 'text-slate-500' }}"></i>
                            Katalog Alat
                        </a>

                        <a href="{{ url('/peminjam/pinjaman/' . auth()->id()) }}"
                            class="flex items-center px-3 py-2 rounded-lg transition text-sm font-medium {{ request()->is('peminjam/pinjaman*') ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                            <i
                                class="fa-solid fa-hand-holding w-6 {{ request()->is('peminjam/pinjaman*') ? 'text-white' : 'text-slate-500' }}"></i>
                            Pinjaman Saya
                        </a>
                        <a href="{{ url('/peminjam/histori/' . auth()->id()) }}"
                            class="flex items-center px-3 py-2 rounded-lg transition text-sm font-medium {{ request()->is('peminjam/histori*') ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                            <i
                                class="fa-solid fa-clock-rotate-left w-6 {{ request()->is('peminjam/histori*') ? 'text-white' : 'text-slate-500' }}"></i>
                            <span>Histori Peminjaman</span>
                        </a>
                    </div>
                @endif
            </nav>
        </div>

        <!-- User Profile Info & Logout (TETAP DIAM DI POJOK KIRI BAWAH) -->
        <div class="p-4 border-t border-slate-800 flex items-center justify-between bg-slate-900 shrink-0">
            <div class="flex items-center space-x-3 overflow-hidden">
                @php
                    $initial = strtoupper(substr(auth()->user()->username ?? 'U', 0, 1));
                @endphp
                <div
                    class="w-9 h-9 rounded-full bg-indigo-600 text-white font-bold flex items-center justify-center text-xs shadow-sm shrink-0">
                    {{ $initial }}
                </div>
                <div class="text-xs truncate">
                    <p class="font-semibold text-white truncate max-w-[100px]">{{ auth()->user()->username ?? 'User' }}
                    </p>
                    <p class="text-[10px] text-slate-400 capitalize">{{ Auth::user()->role ?? 'Guest' }}</p>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Apakah kamu ingin logout?')">
                @csrf
                <button type="submit"
                    class="text-slate-400 hover:text-rose-400 p-2 rounded-lg hover:bg-slate-800 transition"
                    title="Logout">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </button>
            </form>
        </div>
    </aside>

    <!-- 3. KONTEN UTAMA DI KANAN (HANYA BAGIAN INI YANG DI-SCROLL) -->
    <div class="flex-1 flex flex-col h-screen min-w-0 overflow-hidden">

        <!-- Header Atas (STAYS FIXED - DIAM DI ATAS KONTEN) -->
        <header
            class="h-16 bg-white border-b border-slate-200 px-4 sm:px-6 flex items-center justify-between shrink-0 z-30 shadow-sm">
            <div class="flex items-center space-x-3">
                <button @click="sidebarOpen = true"
                    class="md:hidden p-2 text-slate-600 hover:bg-slate-100 rounded-lg focus:outline-none">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
                <h1 class="font-bold text-slate-700 text-base sm:text-lg">Dashboard</h1>
            </div>

            <span
                class="px-3 py-1 bg-indigo-50 text-indigo-700 text-xs font-semibold rounded-full border border-indigo-100 shadow-sm">
                Status: Login sebagai <span
                    class="capitalize font-bold">{{ auth()->user()->role ?? 'Peminjam' }}</span>
            </span>
        </header>

        <!-- Area Main Content (TABEL USER/DATA DI-SCROLL DI SINI) -->
        <main class="p-4 sm:p-6 md:p-8 flex-1 overflow-y-auto">
            @yield('content')
        </main>
    </div>

</div>
