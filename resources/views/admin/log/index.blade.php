@extends('Layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="bg-white p-5 rounded-xl border border-slate-200 flex justify-between items-center">
            <div>
                <h2 class="text-xl font-bold text-slate-800">Log Aktivitas Sistem</h2>
                <p class="text-xs text-slate-500">Catatan riwayat aksi seluruh pengguna di dalam aplikasi.</p>
            </div>
            <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-xs font-semibold">
                Total Log: 24 Aktivitas
            </span>
        </div>

        <!-- Timeline Log -->
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
            <div
                class="relative pl-6 space-y-6 before:absolute before:left-2 before:top-2 before:bottom-2 before:w-0.5 before:bg-slate-200">

                <!-- Item Log 1 -->
                <div class="relative">
                    <div class="absolute -left-[21px] top-1.5 w-3 h-3 rounded-full bg-emerald-500 ring-4 ring-white"></div>
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-bold text-slate-800">Admin Utama <span
                                    class="font-normal text-slate-500">(admin@gmail.com)</span></p>
                            <p class="text-xs text-slate-600 mt-0.5">Menambahkan alat baru: <span
                                    class="font-semibold text-slate-700">Proyektor Epson EB-X400</span></p>
                        </div>
                        <span class="text-xs text-slate-400">10 menit yang lalu</span>
                    </div>
                </div>

                <!-- Item Log 2 -->
                <div class="relative">
                    <div class="absolute -left-[21px] top-1.5 w-3 h-3 rounded-full bg-indigo-500 ring-4 ring-white"></div>
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-bold text-slate-800">Petugas Lapangan <span
                                    class="font-normal text-slate-500">(petugas@gmail.com)</span></p>
                            <p class="text-xs text-slate-600 mt-0.5">Menyetujui peminjaman alat ID: <span
                                    class="font-semibold text-slate-700">#PMJ-002</span></p>
                        </div>
                        <span class="text-xs text-slate-400">1 jam yang lalu</span>
                    </div>
                </div>

                <!-- Item Log 3 -->
                <div class="relative">
                    <div class="absolute -left-[21px] top-1.5 w-3 h-3 rounded-full bg-rose-500 ring-4 ring-white"></div>
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-bold text-slate-800">Budi Santoso <span
                                    class="font-normal text-slate-500">(peminjam)</span></p>
                            <p class="text-xs text-slate-600 mt-0.5">Mengajukan peminjaman Kamera Canon EOS 600D</p>
                        </div>
                        <span class="text-xs text-slate-400">3 jam yang lalu</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
