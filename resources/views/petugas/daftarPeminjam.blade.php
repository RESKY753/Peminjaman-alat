@extends('Layouts.app')

@section('content')
    <div class="space-y-6">

        <!-- Header Page -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-800">Daftar Riwayat Peminjaman</h2>
                <p class="text-xs text-slate-500 mt-0.5">Arsip transaksi peminjaman yang telah selesai atau ditolak.</p>
            </div>
        </div>

        <!-- Tabel Data Riwayat -->
        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead
                        class="bg-slate-50 text-slate-700 border-b border-slate-200 uppercase text-[11px] font-bold tracking-wider">
                        <tr>
                            <th class="px-6 py-3.5">No</th>
                            <th class="px-6 py-3.5">Nama Peminjam</th>
                            <th class="px-6 py-3.5">Alat & Jumlah</th>
                            <th class="px-6 py-3.5">Tgl Pinjam</th>
                            <th class="px-6 py-3.5">Tgl Selesai/Ditolak</th>
                            <th class="px-6 py-3.5 text-center">Status Akhir</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">

                        @forelse ($riwayat as $index => $item)
                            @php
                                $status = strtolower($item->status ?? '');
                            @endphp
                            <tr class="hover:bg-slate-50/80 transition">
                                <!-- Nomor Urut -->
                                <td class="px-6 py-4 font-medium text-slate-500">
                                    {{ $index + 1 }}
                                </td>

                                <!-- Nama Peminjam -->
                                <td class="px-6 py-4 font-bold text-slate-800">
                                    {{ $item->username ?? ($item->user->username ?? '-') }}
                                </td>

                                <!-- Nama Alat & Jumlah -->
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-slate-700">
                                        {{ $item->nama_alat ?? ($item->alat->nama_alat ?? '-') }}</p>
                                    <span class="text-xs text-slate-400">Jumlah: {{ $item->jumlah }} Unit</span>
                                </td>

                                <!-- Tanggal Pinjam -->
                                <td class="px-6 py-4 text-xs text-slate-600">
                                    {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                                </td>

                                <!-- Tanggal Selesai -->
                                <td class="px-6 py-4 text-xs text-slate-600">
                                    {{ $item->tanggal_kembali ? \Carbon\Carbon::parse($item->tanggal_kembali)->locale('id')->isoFormat('dddd, D MMMM YYYY') : '-' }}
                                </td>

                                <!-- Badge Status (Hanya Selesai / Ditolak) -->
                                <td class="px-6 py-4 text-center">
                                    @if (in_array($status, ['dikembalikan', 'selesai']))
                                        <span
                                            class="px-2.5 py-1 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-md text-xs font-semibold uppercase">
                                            <i class="fa-solid fa-check-circle mr-1"></i> Selesai
                                        </span>
                                    @elseif ($status == 'ditolak')
                                        <span
                                            class="px-2.5 py-1 bg-rose-50 text-rose-600 border border-rose-100 rounded-md text-xs font-semibold uppercase">
                                            <i class="fa-solid fa-times-circle mr-1"></i> Ditolak
                                        </span>
                                    @else
                                        <span
                                            class="px-2.5 py-1 bg-slate-50 text-slate-600 border border-slate-200 rounded-md text-xs font-semibold uppercase">
                                            {{ $item->status }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-xs text-slate-400">
                                    Belum ada riwayat peminjaman yang selesai atau ditolak.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
