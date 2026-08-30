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
            <div
                class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-md transition duration-200 flex flex-col justify-between">
                <div>
                    <!-- Image Wrapper -->
                    <div class="relative h-44 bg-slate-100 overflow-hidden">
                        <img src="https://via.placeholder.com/300x200" alt="Proyektor Epson"
                            class="w-full h-full object-cover">
                        <span
                            class="absolute top-2 right-2 px-2.5 py-1 bg-white/90 backdrop-blur-md text-xs font-bold text-indigo-600 rounded-md shadow-sm">
                            Elektronik
                        </span>
                    </div>

                    <!-- Detail Barang -->
                    <div class="p-4 space-y-2">
                        <div class="flex justify-between items-start">
                            <h3 class="font-bold text-slate-800 text-sm leading-snug">Proyektor Epson EB-X400</h3>
                        </div>

                        <p class="text-xs text-slate-500 line-clamp-2">
                            HDMI, VGA, 3300 Lumens, cocok untuk presentasi dan acara.
                        </p>

                        <!-- Badges Kondisi & Stok -->
                        <div class="pt-2 flex items-center justify-between text-xs">
                            <span class="px-2 py-0.5 bg-emerald-50 text-emerald-600 font-semibold rounded">
                                <i class="fa-solid fa-sparkles mr-1"></i> Baru
                            </span>
                            <span class="font-medium text-slate-600">
                                Stok: <strong class="text-slate-800">5 Unit</strong>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Tombol Aksi Pinjam -->
                <div class="p-4 pt-0">
                    <button
                        class="w-full py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-semibold transition flex items-center justify-center space-x-1.5 shadow-sm shadow-indigo-100">
                        <i class="fa-solid fa-hand-holding-hand"></i>
                        <span>Pinjam Barang Ini</span>
                    </button>
                </div>
            </div>

            <!-- Item Card 2 (Stok Habis / Disabled) -->
            <div
                class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm opacity-75 flex flex-col justify-between">
                <div>
                    <div class="relative h-44 bg-slate-100 overflow-hidden">
                        <img src="https://via.placeholder.com/300x200" alt="Kamera Canon"
                            class="w-full h-full object-cover grayscale">
                        <span
                            class="absolute top-2 right-2 px-2.5 py-1 bg-rose-600 text-white text-xs font-bold rounded-md shadow-sm">
                            Stok Habis
                        </span>
                    </div>

                    <div class="p-4 space-y-2">
                        <h3 class="font-bold text-slate-800 text-sm leading-snug">Kamera DSLR Canon EOS 600D</h3>
                        <p class="text-xs text-slate-500 line-clamp-2">
                            Lensa Kit 18-55mm IS II, Baterai + Charger + Bag.
                        </p>

                        <div class="pt-2 flex items-center justify-between text-xs">
                            <span class="px-2 py-0.5 bg-amber-50 text-amber-600 font-semibold rounded">
                                Rusak Ringan
                            </span>
                            <span class="font-medium text-rose-500">
                                Stok: <strong>0 Unit</strong>
                            </span>
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

        </div>
    </div>
@endsection
