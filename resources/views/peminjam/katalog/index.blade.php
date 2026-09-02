@extends('Layouts.app')

@section('content')
    <div class="space-y-6">
        <!-- Header & Filter Search -->
        <div
            class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold text-slate-800">Katalog Alat & Barang</h2>
                <p class="text-xs text-slate-500 mt-0.5">Pilih alat yang tersedia untuk diajukan peminjaman.</p>
            </div>

            <!-- Form Filter & Search Bar -->
            <form method="GET" action="{{ url('/peminjam/katalog') }}" class="flex flex-col sm:flex-row gap-2">
                <!-- Filter Kategori -->
                <select name="kategori" onchange="this.form.submit()"
                    class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs font-medium text-slate-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white">
                    <option value="">Semua Kategori</option>
                    @foreach ($kategori as $kat)
                        <option value="{{ $kat->id_kategori }}" @selected(request('kategori') == $kat->id_kategori)>
                            {{ ucfirst($kat->nama_kategori) }}
                        </option>
                    @endforeach
                </select>

                <!-- Input Search -->
                <div class="flex items-center space-x-2">
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

                    @if (request('search') || request('kategori'))
                        <a href="{{ url('/peminjam/katalog') }}"
                            class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg text-xs font-semibold transition">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Grid Card Daftar Barang -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
            @forelse ($alat as $item)
                @if ($item->stok > 0)
                    <!-- CARD ALAT (ADA STOK) -->
                    <div
                        class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-md transition flex flex-col justify-between">
                        <div>
                            <div class="relative h-44 bg-slate-100 overflow-hidden">
                                <img src="{{ asset('uploads/alat/' . $item->foto) }}" alt="{{ $item->nama_alat }}"
                                    class="w-full h-full object-cover">
                                <span
                                    class="absolute top-2 right-2 px-2.5 py-1 bg-white/90 backdrop-blur-md text-xs font-bold text-indigo-600 rounded-md shadow-sm">
                                    {{ $item->kategori->nama_kategori ?? '-' }}
                                </span>
                            </div>
                            <div class="p-4 space-y-2">
                                <h3 class="font-bold text-slate-800 text-sm line-clamp-1">{{ $item->nama_alat }}</h3>
                                <p class="text-xs text-slate-500 line-clamp-2 h-8">{{ $item->spesifikasi }}</p>
                                <div class="pt-2 flex items-center justify-between text-xs border-t border-slate-50">
                                    <span
                                        class="px-2 py-0.5 bg-emerald-50 text-emerald-600 font-semibold rounded capitalize border border-emerald-100">
                                        {{ str_replace('_', ' ', $item->kondisi) }}
                                    </span>
                                    <span class="font-medium text-slate-600">Stok: <strong
                                            class="text-slate-800">{{ $item->stok }}</strong></span>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 pt-0">
                            <a href="{{ url("/peminjam/katalog/{$item->id_alat}/create") }}" class="block">
                                <button
                                    class="w-full py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-semibold transition flex items-center justify-center space-x-1.5 shadow-sm shadow-indigo-100">
                                    <i class="fa-solid fa-hand-holding-hand"></i>
                                    <span>Pinjam Barang Ini</span>
                                </button>
                            </a>
                        </div>
                    </div>
                @else
                    <!-- CARD ALAT (STOK HABIS) -->
                    <div
                        class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm opacity-75 flex flex-col justify-between">
                        <div>
                            <div class="relative h-44 bg-slate-100 overflow-hidden">
                                <img src="{{ asset('uploads/alat/' . $item->foto) }}" alt="{{ $item->nama_alat }}"
                                    class="w-full h-full object-cover grayscale">
                                <span
                                    class="absolute top-2 right-2 px-2.5 py-1 bg-rose-600 text-white text-xs font-bold rounded-md shadow-sm">
                                    Stok Habis
                                </span>
                            </div>
                            <div class="p-4 space-y-2">
                                <h3 class="font-bold text-slate-800 text-sm line-clamp-1">{{ $item->nama_alat }}</h3>
                                <p class="text-xs text-slate-500 line-clamp-2 h-8">{{ $item->spesifikasi }}</p>
                                <div class="pt-2 flex items-center justify-between text-xs border-t border-slate-50">
                                    <span
                                        class="px-2 py-0.5 bg-amber-50 text-amber-600 font-semibold rounded capitalize border border-amber-100">
                                        {{ str_replace('_', ' ', $item->kondisi) }}
                                    </span>
                                    <span class="font-medium text-rose-500">Stok: <strong>0</strong></span>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 pt-0">
                            <button disabled
                                class="w-full py-2 bg-slate-100 text-slate-400 rounded-lg text-xs font-semibold cursor-not-allowed flex items-center justify-center space-x-1.5 border border-slate-200">
                                <i class="fa-solid fa-ban"></i>
                                <span>Tidak Dapat Dipinjam</span>
                            </button>
                        </div>
                    </div>
                @endif
            @empty
                <div class="col-span-full bg-white rounded-xl border border-slate-200 p-8 text-center text-slate-500">
                    <i class="fa-solid fa-box-open text-3xl mb-2 text-slate-300"></i>
                    <p class="text-xs font-medium">Data alat tidak ditemukan atau katalog kosong.</p>
                </div>
            @endforelse
        </div>

        <!-- AREA PAGINATION LINK (Di luar grid) -->
        @if (method_exists($alat, 'hasPages') && $alat->hasPages())
            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                {{ $alat->links() }}
            </div>
        @endif
    </div>
@endsection
