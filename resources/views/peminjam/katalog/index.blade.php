@extends('Layouts.app')

@section('content')
    <div class="space-y-6">
        <!-- Header & Filter Search -->
        <div
            class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm space-y-4 md:space-y-0 md:flex md:items-center md:justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-800">Katalog Alat & Barang</h2>
                <p class="text-xs text-slate-500 mt-0.5">Pilih alat yang tersedia untuk diajukan peminjaman.</p>
            </div>

            <!-- Filter & Search Bar -->
            <div class="flex flex-col sm:flex-row gap-2">
                <!-- Filter Kategori -->
                <select
                    class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs font-medium text-slate-600 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">Semua Kategori</option>
                    <option value="elektronik">Elektronik</option>
                    <option value="kamera">Kamera & Foto</option>
                    <option value="perkakas">Perkakas</option>
                </select>

                <!-- Input Search -->
                <div class="relative">
                    <input type="text" placeholder="Cari nama alat..."
                        class="w-full sm:w-60 pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-slate-400 text-xs"></i>
                </div>
            </div>
        </div>

        <!-- Grid Card Daftar Barang -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">

            <!-- Item Card 1 (Stok Ada) -->
            @foreach ($alat as $item)
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
                                <h3 class="font-bold text-slate-800 text-sm">{{ $item->nama_alat }}</h3>
                                <p class="text-xs text-slate-500 line-clamp-2">{{ $item->spesifikasi }}</p>
                                <div class="pt-2 flex items-center justify-between text-xs">
                                    <span
                                        class="px-2 py-0.5 bg-emerald-50 text-emerald-600 font-semibold rounded capitalize">
                                        {{ str_replace('_', ' ', $item->kondisi) }}
                                    </span>
                                    <span class="font-medium text-slate-600">Stok: <strong
                                            class="text-slate-800">{{ $item->stok }}</strong></span>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 pt-0">
                            <a href="{{ url("/peminjam/katalog/{$item->id_alat}/create") }}">
                                <button
                                    class="w-full py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-semibold transition flex items-center justify-center space-x-1">
                                    <i class="fa-solid fa-hand-holding-hand"></i>
                                    <span>Pinjam Barang Ini</span>
                                </button>
                            </a>
                        </div>
                    </div>
                @else
                    <!-- CARD ALAT (STOK HABIS - TARUH DI BAWAH) -->
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
                                <h3 class="font-bold text-slate-800 text-sm">{{ $item->nama_alat }}</h3>
                                <p class="text-xs text-slate-500 line-clamp-2">{{ $item->spesifikasi }}</p>
                                <div class="pt-2 flex items-center justify-between text-xs">
                                    <span class="px-2 py-0.5 bg-amber-50 text-amber-600 font-semibold rounded capitalize">
                                        {{ str_replace('_', ' ', $item->kondisi) }}
                                    </span>
                                    <span class="font-medium text-rose-500">Stok: <strong>0</strong></span>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 pt-0">
                            <button disabled
                                class="w-full py-2 bg-slate-200 text-slate-400 rounded-lg text-xs font-semibold cursor-not-allowed flex items-center justify-center space-x-1">
                                <i class="fa-solid fa-ban"></i>
                                <span>Tidak Dapat Dipinjam</span>
                            </button>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection
