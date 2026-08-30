@extends('Layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="bg-white p-5 rounded-xl border border-slate-200">
            <h2 class="text-xl font-bold text-slate-800">Persetujuan Peminjaman</h2>
            <p class="text-xs text-slate-500">Konfirmasi pengajuan peminjaman alat dari peminjam.</p>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-slate-700 border-b border-slate-200 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3">Nama Peminjam</th>
                        <th class="px-6 py-3">Alat</th>
                        <th class="px-6 py-3">Tgl Pinjam</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3 text-center">Aksi Konfirmasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 font-bold text-slate-800">Siswa Ahmad</td>
                        <td class="px-6 py-4">Kamera Canon EOS 600D</td>
                        <td class="px-6 py-4 text-slate-500">27 Ags 2026, 09:00 WIB</td>
                        <td class="px-6 py-4">
                            <span
                                class="px-2.5 py-1 bg-amber-50 text-amber-600 rounded-md text-xs font-semibold">Pending</span>
                        </td>
                        <td class="px-6 py-4 text-center space-x-2">
                            <button
                                class="px-3 py-1.5 bg-emerald-600 text-white rounded-lg text-xs font-semibold hover:bg-emerald-700 transition">
                                <i class="fa-solid fa-check mr-1"></i> Setujui
                            </button>
                            <button
                                class="px-3 py-1.5 bg-rose-600 text-white rounded-lg text-xs font-semibold hover:bg-rose-700 transition">
                                <i class="fa-solid fa-xmark mr-1"></i> Tolak
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
