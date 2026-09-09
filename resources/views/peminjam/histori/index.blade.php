@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">

        <!-- Header Halaman -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-slate-800">Histori Peminjaman</h1>
                <p class="text-xs text-slate-500 mt-0.5">Daftar riwayat alat yang sudah dikembalikan atau ditolak oleh
                    petugas.</p>
            </div>
        </div>

        <!-- Tabel / Daftar Histori -->
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="bg-slate-50 border-b border-slate-200 text-slate-500 text-[11px] font-semibold uppercase tracking-wider">
                            <th class="py-3.5 px-6">No</th>
                            <th class="py-3.5 px-6">Nama Alat</th>
                            <th class="py-3.5 px-6">Jumlah</th>
                            <th class="py-3.5 px-6">Tanggal Pinjam</th>
                            <th class="py-3.5 px-6">Tanggal Kembali</th>
                            <th class="py-3.5 px-6">Status Akhir</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs text-slate-700">

                        <!-- CONTOH 1 DATA DUMMY (STATUS: DIKEMBALIKAN / SELESAI) -->
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-4 px-6 font-medium text-slate-500">1</td>
                            <td class="py-4 px-6 font-semibold text-slate-800 flex items-center space-x-3">
                                <div
                                    class="w-9 h-9 rounded-lg bg-slate-100 border border-slate-200 overflow-hidden flex-shrink-0">
                                    <img src="{{ asset('images/default.png') }}" alt="Foto"
                                        class="w-full h-full object-cover">
                                </div>
                                <span>Laptop Asus ZenBook 14</span>
                            </td>
                            <td class="py-4 px-6">1 Unit</td>
                            <td class="py-4 px-6 text-slate-500">05 Sep 2026</td>
                            <td class="py-4 px-6 text-slate-500">05 Sep 2026</td>
                            <td class="py-4 px-6">
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                    <i class="fa-solid fa-circle-check mr-1.5 text-[9px]"></i> Selesai (Dikembalikan)
                                </span>
                            </td>
                        </tr>

                        <!-- CONTOH 1 DATA DUMMY TAMBAHAN (STATUS: DITOLAK - OPSIONAL) -->
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-4 px-6 font-medium text-slate-500">2</td>
                            <td class="py-4 px-6 font-semibold text-slate-800 flex items-center space-x-3">
                                <div
                                    class="w-9 h-9 rounded-lg bg-slate-100 border border-slate-200 overflow-hidden flex-shrink-0">
                                    <img src="{{ asset('images/default.png') }}" alt="Foto"
                                        class="w-full h-full object-cover">
                                </div>
                                <span>Proyektor Epson EB-S400</span>
                            </td>
                            <td class="py-4 px-6">1 Unit</td>
                            <td class="py-4 px-6 text-slate-500">06 Sep 2026</td>
                            <td class="py-4 px-6 text-slate-500">06 Sep 2026</td>
                            <td class="py-4 px-6">
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-semibold bg-rose-50 text-rose-600 border border-rose-200">
                                    <i class="fa-solid fa-circle-xmark mr-1.5 text-[9px]"></i> Ditolak
                                </span>
                            </td>
                        </tr>

                        {{--
                        BLOK FOREACH ASLI YANG DIKOMEN SEMENTARA
                        @forelse($histori as $index => $item)
                        ...
                        @empty
                        ...
                        @endforelse
                        --}}

                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection