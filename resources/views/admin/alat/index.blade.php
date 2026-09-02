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
            class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-xl font-bold text-slate-800">Kelola Data Alat</h2>
                <p class="text-xs text-slate-500 mt-0.5">Tambah, ubah, dan hapus data inventaris alat yang dapat dipinjam.
                </p>
            </div>

            <a href="{{ url('/admin/alat/create') }}"
                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-semibold transition flex items-center space-x-2 shadow-sm shadow-indigo-100">
                <i class="fa-solid fa-plus"></i>
                <span>Tambah Alat Baru</span>
            </a>
        </div>

        <!-- BARIS PENCARIAN NAMA ALAT -->
        <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
            <form method="GET" action="{{ url('/admin/alat') }}" class="flex items-center space-x-2">
                <div class="relative flex-1">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari berdasarkan nama alat..."
                        class="w-full pl-9 pr-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-slate-400 text-xs"></i>
                </div>

                <button type="submit"
                    class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-lg text-xs font-semibold transition flex items-center space-x-1.5">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <span>Cari</span>
                </button>

                @if (request('search'))
                    <a href="{{ url('/admin/alat') }}"
                        class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg text-xs font-semibold transition">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- Tabel Data Alat (Read) -->
        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead
                        class="bg-slate-50 text-slate-700 border-b border-slate-200 uppercase text-[11px] font-bold tracking-wider">
                        <tr>
                            <th class="px-6 py-3.5">Gambar & Nama Alat</th>
                            <th class="px-6 py-3.5">Kategori</th>
                            <th class="px-6 py-3.5">Spesifikasi</th>
                            <th class="px-6 py-3.5">Kondisi</th>
                            <th class="px-6 py-3.5">Stok</th>
                            <th class="px-6 py-3.5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">

                        @forelse ($alat as $item)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="px-6 py-4 flex items-center space-x-3">
                                    <img src="{{ asset('uploads/alat/' . $item->foto) }}" alt="{{ $item->nama_alat }}"
                                        class="w-12 h-12 rounded-lg object-cover border border-slate-200 bg-slate-100">
                                    <div>
                                        <p class="font-bold text-slate-800 text-sm">{{ $item->nama_alat }}</p>
                                        <span class="text-[11px] text-slate-400">ID Alat: #ALT-0{{ $item->id_alat }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-medium text-slate-700">
                                    {{ ucfirst($item->nama_kategori ?? ($item->kategori->nama_kategori ?? '-')) }}
                                </td>
                                <td class="px-6 py-4 text-xs text-slate-500 max-w-xs truncate">{{ $item->spesifikasi }}
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2.5 py-1 bg-emerald-50 text-emerald-600 rounded-md text-xs font-semibold border border-emerald-100 uppercase">
                                        {{ str_replace('_', ' ', $item->kondisi ?? $item->Kondisi) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 font-bold text-slate-800">{{ $item->stok }}</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <!-- Tombol Edit Ke Halaman Baru -->
                                        <a href="{{ url('/admin/alat/edit/' . $item->id_alat) }}"
                                            class="p-2 text-amber-500 hover:bg-amber-50 rounded-lg transition"
                                            title="Edit Data">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>

                                        <!-- Form Hapus -->
                                        <form action="/admin/alat/delete/{{ $item->id_alat }}" method="POST"
                                            onsubmit="return confirm('Apakah kamu yakin ingin menghapus alat ini?')"
                                            class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="p-2 text-rose-500 hover:bg-rose-50 rounded-lg transition"
                                                title="Hapus Data">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="hover:bg-slate-50/80 transition">
                                <td colspan="6" class="px-6 py-6 text-center text-xs text-slate-400">Tidak ada data alat
                                    tersimpan.</td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

            <!-- AREA PAGINATION LINK (15 Data Per Halaman) -->
            @if (method_exists($alat, 'hasPages') && $alat->hasPages())
                <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                    {{ $alat->links() }}
                </div>
            @endif
        </div>

    </div>
@endsection
