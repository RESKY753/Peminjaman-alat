@extends('Layouts.app')

@section('content')

        <div class="space-y-6">

            <!-- Welcome Banner -->
            <div
                class="bg-gradient-to-r from-indigo-600 to-violet-600 rounded-2xl p-6 text-white shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h2 class="text-xl md:text-2xl font-bold">Halo, {{ auth()->user()->username ?? 'User' }}! 👋</h2>
                    <p class="text-indigo-100 text-xs md:text-sm mt-1">
                        Selamat datang kembali di sistem manajemen peminjaman alat (<span
                            class="font-semibold">PinjamAlat</span>).
                        Kelola inventaris dan peminjaman dengan lebih mudah dan cepat.
                    </p>
                </div>
                <div class="bg-white/10 backdrop-blur-md px-4 py-2 rounded-xl border border-white/20 text-xs font-medium">
                    <i class="fa-solid fa-calendar-days mr-1.5"></i> {{ date('d F Y') }}
                </div>
            </div>

            <!-- 1. DASHBOARD KHUSUS ADMIN -->
            @if(Auth::user()?->role === 'admin')
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Card Total Alat -->
                    <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Inventaris Alat</p>
                            <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ $totalAlat ?? 0 }}</h3>
                        </div>
                        <div
                            class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center text-lg shadow-inner">
                            <i class="fa-solid fa-screwdriver-wrench"></i>
                        </div>
                    </div>

                    <!-- Card Total User -->
                    <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Pengguna Terdaftar</p>
                            <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ $totalUser ?? 0 }}</h3>
                        </div>
                        <div
                            class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-lg shadow-inner">
                            <i class="fa-solid fa-users"></i>
                        </div>
                    </div>

                    <!-- Card Kategori -->
                    <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Kategori Alat</p>
                            <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ $totalKategori ?? 0 }}</h3>
                        </div>
                        <div
                            class="w-12 h-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center text-lg shadow-inner">
                            <i class="fa-solid fa-tags"></i>
                        </div>
                    </div>

                    <!-- Card Log Aktivitas -->
                    <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Log Aktivitas</p>
                            <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ $totalLog ?? 'Aman' }}</h3>
                        </div>
                        <div
                            class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-lg shadow-inner">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                        </div>
                    </div>
                </div>
            @endif

            <!-- 2. DASHBOARD KHUSUS PETUGAS -->
            @if(Auth::user()?->role === 'petugas')
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Menunggu Persetujuan</p>
                            <h3 class="text-2xl font-bold text-amber-600 mt-1">{{ $pendingCount ?? 0 }}</h3>
                        </div>
                        <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center text-lg">
                            <i class="fa-solid fa-clipboard-check"></i>
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Sedang Dipinjam</p>
                            <h3 class="text-2xl font-bold text-indigo-600 mt-1">{{ $activePinjamCount ?? 0 }}</h3>
                        </div>
                        <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center text-lg">
                            <i class="fa-solid fa-hand-holding"></i>
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Peminjam</p>
                            <h3 class="text-2xl font-bold text-emerald-600 mt-1">{{ $totalPeminjam ?? 0 }}</h3>
                        </div>
                        <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-lg">
                            <i class="fa-solid fa-list"></i>
                        </div>
                    </div>
                </div>
            @endif

            <!-- 3. DASHBOARD KHUSUS PEMINJAM -->
            @if(Auth::user()?->role === 'peminjam')
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Pinjaman Aktif Saya</p>
                            <h3 class="text-2xl font-bold text-indigo-600 mt-1">{{ $myPinjamanCount ?? 0 }}</h3>
                        </div>
                        <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center text-lg">
                            <i class="fa-solid fa-hand-holding"></i>
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Katalog Alat Tersedia</p>
                            <h3 class="text-2xl font-bold text-emerald-600 mt-1">{{ $katalogCount ?? 0 }}</h3>
                        </div>
                        <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-lg">
                            <i class="fa-solid fa-layer-group"></i>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Quick Access Section / Aksi Cepat -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <h3 class="text-sm font-bold text-slate-800 mb-3"><i class="fa-solid fa-bolt text-amber-500 mr-2"></i> Akses
                    Cepat</h3>
                <div class="flex flex-wrap gap-3">
                    @if(Auth::user()?->role === 'admin')
                        <a href="{{ url('/admin/alat') }}"
                            class="px-4 py-2 bg-slate-50 hover:bg-indigo-50 hover:text-indigo-600 border border-slate-200 rounded-lg text-xs font-semibold text-slate-600 transition">
                            + Kelola Alat Inventaris
                        </a>
                        <a href="{{ url('/admin/user') }}"
                            class="px-4 py-2 bg-slate-50 hover:bg-indigo-50 hover:text-indigo-600 border border-slate-200 rounded-lg text-xs font-semibold text-slate-600 transition">
                            Kelola Data User
                        </a>
                    @elseif(Auth::user()?->role === 'petugas')
                        <a href="{{ url('/petugas/persetujuan') }}"
                            class="px-4 py-2 bg-slate-50 hover:bg-indigo-50 hover:text-indigo-600 border border-slate-200 rounded-lg text-xs font-semibold text-slate-600 transition">
                            Cek Persetujuan Pinjam
                        </a>
                    @else
                        <a href="{{ url('/peminjam/katalog') }}"
                            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-semibold transition">
                            Lihat Katalog & Pinjam Alat
                        </a>
                        <a href="{{ url('/peminjam/pinjaman/' . auth()->id()) }}"
                            class="px-4 py-2 bg-slate-50 hover:bg-indigo-50 hover:text-indigo-600 border border-slate-200 rounded-lg text-xs font-semibold text-slate-600 transition">
                            Status Pinjaman Saya
                        </a>
                    @endif
                </div>
            </div>

        </div>
@endsection