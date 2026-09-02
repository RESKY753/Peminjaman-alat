@extends('Layouts.app')

@section('content')
    <div class="space-y-6">

        <!-- Flash Message Success -->
        @if (session('success'))
            <div
                class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-sm p-4 rounded-xl flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <!-- Header Page & Tombol Ke Halaman Tambah -->
        <div
            class="bg-white p-4 sm:p-5 rounded-xl border border-slate-200 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-lg sm:text-xl font-bold text-slate-800">Kelola Data User</h2>
                <p class="text-xs text-slate-500 mt-0.5">Tambah, ubah role, atau hapus akun pengguna sistem.</p>
            </div>

            <a href="{{ url('/admin/user/create') }}"
                class="w-full sm:w-auto justify-center px-4 py-2.5 sm:py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-semibold flex items-center space-x-2 transition shadow-sm">
                <i class="fa-solid fa-plus"></i>
                <span>Tambah User Baru</span>
            </a>
        </div>

        <!-- BARIS FILTER & PENCARIAN -->
        <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
            <form method="GET" action="{{ url('/admin/user') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-3">

                <!-- Input Cari Nama / Email -->
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari username atau email..."
                        class="w-full pl-9 pr-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-slate-400 text-xs"></i>
                </div>

                <!-- Select Filter Role -->
                <div>
                    <select name="role"
                        class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white">
                        <option value="">-- Semua Role --</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="petugas" {{ request('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                        <option value="peminjam" {{ request('role') == 'peminjam' ? 'selected' : '' }}>Peminjam</option>
                    </select>
                </div>

                <!-- Tombol Action Filter -->
                <div class="flex items-center space-x-2">
                    <button type="submit"
                        class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-lg text-xs font-semibold transition flex items-center space-x-1.5">
                        <i class="fa-solid fa-filter"></i>
                        <span>Filter</span>
                    </button>

                    @if (request('search') || request('role'))
                        <a href="{{ url('/admin/user') }}"
                            class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg text-xs font-semibold transition">
                            Reset
                        </a>
                    @endif
                </div>

            </form>
        </div>

        <!-- Tabel Data User (Read) -->
        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
            <div class="overflow-x-auto w-full">
                <table class="w-full text-left text-sm text-slate-600 min-w-[640px]">
                    <thead
                        class="bg-slate-50 text-slate-700 border-b border-slate-200 uppercase text-[11px] font-bold tracking-wider">
                        <tr>
                            <th class="px-4 sm:px-6 py-3.5 whitespace-nowrap">User</th>
                            <th class="px-4 sm:px-6 py-3.5 whitespace-nowrap">Telp</th>
                            <th class="px-4 sm:px-6 py-3.5 whitespace-nowrap">Email</th>
                            <th class="px-4 sm:px-6 py-3.5 whitespace-nowrap">Role / Hak Akses</th>
                            <th class="px-4 sm:px-6 py-3.5 whitespace-nowrap">Tanggal Dibuat</th>
                            <th class="px-4 sm:px-6 py-3.5 text-center whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">

                        @forelse ($user as $item)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="px-4 sm:px-6 py-4 flex items-center space-x-3 whitespace-nowrap">
                                    @php
                                        $initial = strtoupper(substr($item->username ?? 'U', 0, 1));
                                        $colors = [
                                            'bg-indigo-600 text-white',
                                            'bg-emerald-600 text-white',
                                            'bg-amber-500 text-white',
                                            'bg-rose-600 text-white',
                                            'bg-violet-600 text-white',
                                            'bg-cyan-600 text-white',
                                            'bg-teal-600 text-white',
                                            'bg-fuchsia-600 text-white',
                                        ];
                                        $colorIndex = ($item->id_user ?? ord($initial)) % count($colors);
                                        $selectedColor = $colors[$colorIndex];
                                    @endphp

                                    <div
                                        class="w-8 h-8 sm:w-9 sm:h-9 rounded-full {{ $selectedColor }} font-bold flex items-center justify-center text-xs shadow-sm uppercase shrink-0">
                                        {{ $initial }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 text-sm">{{ $item->username }}</p>
                                        <span class="text-[11px] text-slate-400">ID User:
                                            #USR-01{{ $item->id_user }}</span>
                                    </div>
                                </td>
                                <td class="px-4 sm:px-6 py-4 text-slate-600 whitespace-nowrap">{{ $item->telp ?? '-' }}
                                </td>
                                <td class="px-4 sm:px-6 py-4 text-slate-600 whitespace-nowrap">{{ $item->email }}</td>
                                <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                    @switch($item->role)
                                        @case('admin')
                                            <span
                                                class="px-2.5 py-1 bg-rose-50 text-rose-700 rounded-md text-xs font-semibold border border-rose-200 uppercase tracking-wider">
                                                Admin
                                            </span>
                                        @break

                                        @case('petugas')
                                            <span
                                                class="px-2.5 py-1 bg-emerald-50 text-emerald-700 rounded-md text-xs font-semibold border border-emerald-200 uppercase tracking-wider">
                                                Petugas
                                            </span>
                                        @break

                                        @case('peminjam')
                                            <span
                                                class="px-2.5 py-1 bg-indigo-50 text-indigo-700 rounded-md text-xs font-semibold border border-indigo-200 uppercase tracking-wider">
                                                Peminjam
                                            </span>
                                        @break

                                        @default
                                            <span
                                                class="px-2.5 py-1 bg-slate-100 text-slate-600 rounded-md text-xs font-semibold border border-slate-200 uppercase tracking-wider">
                                                {{ ucfirst($item->role ?? 'User') }}
                                            </span>
                                    @endswitch
                                </td>
                                <td class="px-4 sm:px-6 py-4 text-xs text-slate-400 whitespace-nowrap">
                                    {{ $item->created_at ? $item->created_at->format('Y-m-d H:i') : '-' }}
                                </td>
                                <td class="px-4 sm:px-6 py-4 text-center whitespace-nowrap">
                                    <div class="flex items-center justify-center space-x-2">
                                        <!-- Tombol Edit Ke Halaman Baru -->
                                        <a href="{{ url('/admin/user/edit/' . $item->id_user) }}"
                                            class="p-2 text-amber-500 hover:bg-amber-50 rounded-lg transition"
                                            title="Edit User">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>

                                        <!-- Form Hapus (Instan Tanpa Lag) -->
                                        <form action="/admin/user/delete/{{ $item->id_user }}" method="POST"
                                            onsubmit="return confirm('Apakah kamu yakin ingin menghapus user {{ addslashes($item->username) }}?')"
                                            class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="p-2 text-rose-500 hover:bg-rose-50 rounded-lg transition"
                                                title="Hapus User">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-slate-400 text-xs">
                                        Data user tidak ditemukan.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>

                <!-- AREA PAGINATION LINK (15 Data Per Halaman) -->
                @if (method_exists($user, 'hasPages') && $user->hasPages())
                    <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                        {{ $user->links() }}
                    </div>
                @endif
            </div>

        </div>
    @endsection
