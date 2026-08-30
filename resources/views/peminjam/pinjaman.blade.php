@extends('Layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="bg-white p-5 rounded-xl border border-slate-200">
            <h2 class="text-xl font-bold text-slate-800">Pinjaman Saya</h2>
            <p class="text-xs text-slate-500">Daftar alat yang sedang Anda pinjam beserta riwayatnya.</p>
        </div>

        <!-- Cards Layout untuk Peminjam -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Item Card Pinjaman -->
            <div class="bg-white p-5 rounded-xl border border-slate-200 space-y-4 shadow-sm">
                <div class="flex justify-between items-start">
                    <div>
                        <span
                            class="px-2.5 py-1 bg-indigo-50 text-indigo-600 rounded-md text-xs font-semibold">Dipinjam</span>
                        <h3 class="font-bold text-slate-800 text-lg mt-2">Laptop Asus ROG Strix</h3>
                    </div>
                    <i class="fa-solid fa-laptop text-2xl text-slate-300"></i>
                </div>

                <div class="bg-slate-50 p-3 rounded-lg text-xs space-y-1 text-slate-600">
                    <div class="flex justify-between">
                        <span>Tanggal Pinjam:</span>
                        <span class="font-semibold">27 Ags 2026</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Batas Kembalikan:</span>
                        <span class="font-semibold text-rose-600">30 Ags 2026</span>
                    </div>
                </div>

                <button
                    class="w-full py-2 bg-slate-900 text-white rounded-lg text-xs font-semibold hover:bg-slate-800 transition">
                    Kembalikan Alat Ini
                </button>
            </div>
        </div>
    </div>
@endsection
