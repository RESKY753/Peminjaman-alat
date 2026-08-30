@extends('Layouts.app')

@section('content')
    <div class="space-y-6">

        <!-- CSS Khusus Mode Cetak (Sembunyikan Form & Header pas di-print) -->
        <style>
            @media print {

                aside,
                header,
                .no-print {
                    display: none !important;
                }

                body {
                    background-color: white !important;
                }

                .print-area {
                    border: none !important;
                    box-shadow: none !important;
                    padding: 0 !important;
                }
            }
        </style>

        <!-- Title Header (Hidden saat Cetak) -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 no-print">
            <h2 class="text-xl font-bold text-slate-800">Cetak Laporan Peminjaman</h2>
            <p class="text-xs text-slate-500">Filter berdasarkan rentang tanggal untuk pratinjau dan mengunduh/mencetak
                laporan PDF.</p>
        </div>

        <!-- Form Filter Tanggal & Tombol Aksi (Hidden saat Cetak) -->
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm no-print">
            <form class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-2">Tanggal Mulai</label>
                    <input type="date" name="tgl_mulai"
                        class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-2">Tanggal Selesai</label>
                    <input type="date" name="tgl_selesai"
                        class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <button type="submit"
                        class="w-full py-2 bg-slate-800 text-white rounded-lg text-xs font-semibold hover:bg-slate-700 transition flex items-center justify-center space-x-2">
                        <i class="fa-solid fa-filter"></i>
                        <span>Filter Data</span>
                    </button>
                </div>
                <div>
                    <button type="button" onclick="window.print()"
                        class="w-full py-2 bg-indigo-600 text-white rounded-lg text-xs font-semibold hover:bg-indigo-700 transition flex items-center justify-center space-x-2 shadow-sm shadow-indigo-100">
                        <i class="fa-solid fa-print"></i>
                        <span>Cetak / Save PDF</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Area Tabel Laporan (Tercetak di Kertas/PDF) -->
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm print-area space-y-4">

            <!-- Kop Laporan (Muncul Utama saat Diprint) -->
            <div class="text-center border-b pb-4 border-slate-200 space-y-1">
                <h1 class="text-xl font-bold uppercase tracking-wider text-slate-800">Laporan Peminjaman Alat</h1>
                <p class="text-xs text-slate-500">Sistem Informasi Inventory & Peminjaman Alat</p>
                <p class="text-[11px] text-slate-400">Periode: <span class="font-semibold text-slate-700">Semua Data</span>
                </p>
            </div>

            <!-- Tabel Pratinjau Data Laporan -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600 border-collapse">
                    <thead>
                        <tr
                            class="bg-slate-100 text-slate-700 border-b border-slate-200 uppercase text-[10px] font-bold tracking-wider">
                            <th class="px-4 py-3 border">No</th>
                            <th class="px-4 py-3 border">Nama Peminjam</th>
                            <th class="px-4 py-3 border">Nama Barang / Alat</th>
                            <th class="px-4 py-3 border">Tgl Pinjam</th>
                            <th class="px-4 py-3 border">Tgl Kembali</th>
                            <th class="px-4 py-3 border text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">

                        <!-- Contoh Baris 1 -->
                        <tr>
                            <td class="px-4 py-3 border font-medium text-slate-800">1</td>
                            <td class="px-4 py-3 border font-semibold text-slate-800">Ahmad Siswa</td>
                            <td class="px-4 py-3 border">Proyektor Epson EB-X400</td>
                            <td class="px-4 py-3 border">25 Ags 2026, 08:00 WIB</td>
                            <td class="px-4 py-3 border">27 Ags 2026, 14:00 WIB</td>
                            <td class="px-4 py-3 border text-center">
                                <span
                                    class="px-2 py-0.5 bg-emerald-50 text-emerald-600 rounded text-[10px] font-bold border border-emerald-100">
                                    Selesai
                                </span>
                            </td>
                        </tr>

                        <!-- Contoh Baris 2 -->
                        <tr>
                            <td class="px-4 py-3 border font-medium text-slate-800">2</td>
                            <td class="px-4 py-3 border font-semibold text-slate-800">Budi Santoso</td>
                            <td class="px-4 py-3 border">Kamera DSLR Canon EOS 600D</td>
                            <td class="px-4 py-3 border">27 Ags 2026, 09:30 WIB</td>
                            <td class="px-4 py-3 border text-slate-400">-</td>
                            <td class="px-4 py-3 border text-center">
                                <span
                                    class="px-2 py-0.5 bg-indigo-50 text-indigo-600 rounded text-[10px] font-bold border border-indigo-100">
                                    Dipinjam
                                </span>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

            <!-- Tanda Tangan / Legitimasi Petugas (Muncul saat cetak) -->
            <div class="hidden print:flex justify-end pt-8">
                <div class="text-center text-xs space-y-12">
                    <p>Petugas Penanggung Jawab,</p>
                    <p class="font-bold underline text-slate-800">( {{ auth()->user()->username ?? 'Nama Petugas' }} )</p>
                </div>
            </div>

        </div>

    </div>
@endsection
