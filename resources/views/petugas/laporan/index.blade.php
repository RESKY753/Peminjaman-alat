@extends('Layouts.app')

@section('content')
    <div class="space-y-6">

        <!-- CSS Khusus Mode Cetak (Sembunyikan Form & Navbar saat Cetak / Save PDF) -->
        <style>
            @media print {

                /* Sembunyikan elemen navigasi dan tombol filter saat dialog print dibuka */
                aside,
                header,
                nav,
                .no-print {
                    display: none !important;
                }

                /* Ubah background halaman menjadi putih bersih */
                body {
                    background-color: white !important;
                }

                /* Hilangkan border dan shadow pada container cetak */
                .print-area {
                    border: none !important;
                    box-shadow: none !important;
                    padding: 0 !important;
                }
            }
        </style>

        <!-- Title Header (Sembunyi saat Cetak) -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 no-print">
            <h2 class="text-xl font-bold text-slate-800">Cetak Laporan Peminjaman</h2>
            <p class="text-xs text-slate-500">Filter berdasarkan rentang tanggal untuk pratinjau dan mengunduh/mencetak
                laporan PDF.</p>
        </div>

        <!-- Form Filter Tanggal & Tombol Aksi (Sembunyi saat Cetak) -->
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm no-print">
            <form method="GET" action="{{ url('/petugas/laporan') }}"
                class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">

                <!-- Input Tanggal Mulai -->
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-2">Tanggal Mulai</label>
                    <input type="date" name="tgl_mulai" value="{{ request('tgl_mulai') }}"
                        class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <!-- Input Tanggal Selesai -->
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-2">Tanggal Selesai</label>
                    <input type="date" name="tgl_selesai" value="{{ request('tgl_selesai') }}"
                        class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <!-- Tombol Submit Filter -->
                <div>
                    <button type="submit"
                        class="w-full py-2 bg-slate-800 text-white rounded-lg text-xs font-semibold hover:bg-slate-700 transition flex items-center justify-center space-x-2">
                        <i class="fa-solid fa-filter"></i>
                        <span>Filter Data</span>
                    </button>
                </div>

                <!-- Tombol Reset Filter -->
                @if (request('tgl_mulai') || request('tgl_selesai'))
                    <div>
                        <a href="{{ url('/petugas/laporan') }}"
                            class="w-full py-2 bg-slate-100 text-slate-600 rounded-lg text-xs font-semibold hover:bg-slate-200 transition flex items-center justify-center space-x-1">
                            <i class="fa-solid fa-rotate-left"></i>
                            <span>Reset</span>
                        </a>
                    </div>
                @endif

                <!-- Tombol Print -->
                <div>
                    <button type="button" onclick="window.print()"
                        class="w-full py-2 bg-indigo-600 text-white rounded-lg text-xs font-semibold hover:bg-indigo-700 transition flex items-center justify-center space-x-2 shadow-sm shadow-indigo-100">
                        <i class="fa-solid fa-print"></i>
                        <span>Cetak / Save PDF</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Area Tabel Laporan (Area Utama yang Akan Tercetak di Kertas/PDF) -->
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm print-area space-y-4">

            <!-- Kop Laporan -->
            <div class="text-center border-b pb-4 border-slate-200 space-y-1">
                <h1 class="text-xl font-bold uppercase tracking-wider text-slate-800">Laporan Peminjaman Alat</h1>
                <p class="text-xs text-slate-500">Sistem Informasi Inventory & Peminjaman Alat</p>

                <!-- Status Keterangan Periode Filter Tanggal -->
                <p class="text-[11px] text-slate-400">
                    Periode:
                    <span class="font-semibold text-slate-700">
                        @if (request('tgl_mulai') && request('tgl_selesai'))
                            {{ \Carbon\Carbon::parse(request('tgl_mulai'))->locale('id')->isoFormat('D MMMM YYYY') }} -
                            {{ \Carbon\Carbon::parse(request('tgl_selesai'))->locale('id')->isoFormat('D MMMM YYYY') }}
                        @elseif (request('tgl_mulai'))
                            Mulai {{ \Carbon\Carbon::parse(request('tgl_mulai'))->locale('id')->isoFormat('D MMMM YYYY') }}
                        @elseif (request('tgl_selesai'))
                            Sampai
                            {{ \Carbon\Carbon::parse(request('tgl_selesai'))->locale('id')->isoFormat('D MMMM YYYY') }}
                        @else
                            Semua Data
                        @endif
                    </span>
                </p>
            </div>

            <!-- Tabel Data Laporan -->
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

                        @forelse ($laporan as $index => $item)
                            <tr>
                                <!-- Nomor Urut -->
                                <td class="px-4 py-3 border font-medium text-slate-800">{{ $index + 1 }}</td>

                                <!-- Nama User Peminjam -->
                                <td class="px-4 py-3 border font-semibold text-slate-800">
                                    {{ $item->username ?? ($item->user->username ?? '-') }}
                                </td>

                                <!-- Nama Alat & Jumlah -->
                                <td class="px-4 py-3 border">
                                    {{ $item->nama_alat ?? ($item->alat->nama_alat ?? '-') }} ({{ $item->jumlah }} Unit)
                                </td>

                                <!-- Format Tanggal Pinjam -->
                                <td class="px-4 py-3 border">
                                    {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->locale('id')->isoFormat('D MMM YYYY, HH:mm') }}
                                    WIB
                                </td>

                                <!-- Format Tanggal Kembali -->
                                <td class="px-4 py-3 border">
                                    {{ $item->tanggal_kembali ? \Carbon\Carbon::parse($item->tanggal_kembali)->locale('id')->isoFormat('D MMM YYYY, HH:mm') . ' WIB' : '-' }}
                                </td>

                                <!-- Badge Status -->
                                <td class="px-4 py-3 border text-center uppercase font-bold text-[10px]">
                                    {{ str_replace('_', ' ', $item->status) }}
                                </td>
                            </tr>
                        @empty
                            <!-- Tampilan jika tidak ada data ditemukan -->
                            <tr>
                                <td colspan="6" class="px-4 py-6 border text-center text-slate-400">
                                    Data laporan tidak ditemukan pada rentang tanggal ini.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

            <!-- Kolom Tanda Tangan (Muncul hanya saat Print) -->
            <div class="hidden print:flex justify-end pt-8">
                <div class="text-center text-xs space-y-12">
                    <p>Petugas Penanggung Jawab,</p>
                    <p class="font-bold underline text-slate-800">( {{ auth()->user()->username ?? 'Nama Petugas' }} )</p>
                </div>
            </div>

        </div>

    </div>
@endsection
