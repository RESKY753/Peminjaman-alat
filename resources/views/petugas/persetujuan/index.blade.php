@extends('Layouts.app')

@section('content')
    <div class="space-y-6">

        <!-- Flash Message Success -->
        @if (session('success'))
            <div
                class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-sm p-4 rounded-xl flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif
        <!-- Flash Message Success -->
        @if (session('error'))
            <div
                class="bg-danger-500/10 border border-danger-500/30 text-danger-400 text-sm p-4 rounded-xl flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-danger-400 hover:text-danger-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <!-- Header Page -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-800">Persetujuan Peminjaman</h2>
                <p class="text-xs text-slate-500 mt-0.5">Konfirmasi pengajuan peminjaman & pengembalian alat.</p>
            </div>
        </div>

        <!-- Tabel Data Persetujuan -->
        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead
                        class="bg-slate-50 text-slate-700 border-b border-slate-200 uppercase text-[11px] font-bold tracking-wider">
                        <tr>
                            <th class="px-6 py-3.5">Nama Peminjam</th>
                            <th class="px-6 py-3.5">Alat & Jumlah</th>
                            <th class="px-6 py-3.5">Tgl Pinjam</th>
                            <th class="px-6 py-3.5">Batas Kembali</th>
                            <th class="px-6 py-3.5">Status</th>
                            <th class="px-6 py-3.5 text-center">Aksi Konfirmasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">

                        @forelse ($persetujuan as $item)
                            @php
                                $status = strtolower($item->status ?? 'ajukan peminjaman');
                                $idPeminjaman = $item->id_peminjaman ?? $item->id;
                            @endphp
                            <tr class="hover:bg-slate-50/80 transition">
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

                                <!-- Batas Kembali -->
                                <td class="px-6 py-4 text-xs font-semibold text-rose-600">
                                    {{ \Carbon\Carbon::parse($item->tanggal_kembali)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                                </td>

                                <!-- Badge Status -->
                                <td class="px-6 py-4">
                                    @switch($status)
                                        @case('ajukan peminjaman')
                                            <span
                                                class="px-2.5 py-1 bg-amber-50 text-amber-600 border border-amber-100 rounded-md text-xs font-semibold uppercase">
                                                Ajukan Peminjaman
                                            </span>
                                        @break

                                        @case('dipinjam')
                                            <span
                                                class="px-2.5 py-1 bg-indigo-50 text-indigo-600 border border-indigo-100 rounded-md text-xs font-semibold uppercase">
                                                Dipinjam
                                            </span>
                                        @break

                                        @case('ajukan kembali')
                                        @case('ajukan pengembalian')
                                            <span
                                                class="px-2.5 py-1 bg-sky-50 text-sky-600 border border-sky-100 rounded-md text-xs font-semibold uppercase">
                                                Ajukan Kembali
                                            </span>
                                        @break

                                        @case('dikembalikan')
                                        @case('selesai')
                                            <span
                                                class="px-2.5 py-1 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-md text-xs font-semibold uppercase">
                                                Dikembalikan
                                            </span>
                                        @break

                                        @case('ditolak')
                                            <span
                                                class="px-2.5 py-1 bg-rose-50 text-rose-600 border border-rose-100 rounded-md text-xs font-semibold uppercase">
                                                Ditolak
                                            </span>
                                        @break

                                        @default
                                            <span
                                                class="px-2.5 py-1 bg-slate-50 text-slate-600 border border-slate-200 rounded-md text-xs font-semibold uppercase">
                                                {{ $item->status }}
                                            </span>
                                    @endswitch
                                </td>

                                <!-- Aksi Konfirmasi (LOGIKA TOMBOL BARU) -->
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center space-x-2">

                                        @switch($status)
                                            {{-- 1. Status 'ajukan peminjaman': Setuju (dipinjam) & Tolak (ditolak) --}}
                                            @case('ajukan peminjaman')
                                                <!-- Form Setujui -> value dipinjam -->
                                                <form action="{{ url('/petugas/persetujuan/update/' . $idPeminjaman) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="dipinjam">
                                                    <button type="submit" onclick="return confirm('Setujui peminjaman alat ini?')"
                                                        class="px-3 py-1.5 bg-indigo-600 text-white rounded-lg text-xs font-semibold hover:bg-indigo-700 transition flex items-center space-x-1 shadow-sm">
                                                        <i class="fa-solid fa-check"></i>
                                                        <span>Setujui</span>
                                                    </button>
                                                </form>

                                                <!-- Form Tolak -> value ditolak -->
                                                <form action="{{ url('/petugas/persetujuan/update/' . $idPeminjaman) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="ditolak">
                                                    <button type="submit" onclick="return confirm('Tolak peminjaman alat ini?')"
                                                        class="px-3 py-1.5 bg-rose-600 text-white rounded-lg text-xs font-semibold hover:bg-rose-700 transition flex items-center space-x-1 shadow-sm">
                                                        <i class="fa-solid fa-xmark"></i>
                                                        <span>Tolak</span>
                                                    </button>
                                                </form>
                                            @break

                                            {{-- 2. Status 'dipinjam': Kosong / Tidak ada tombol aksi --}}
                                            @case('dipinjam')
                                                <span class="text-xs text-slate-400 font-medium italic">- Sedang Dipinjam -</span>
                                            @break

                                            {{-- 3. Status 'ajukan kembali' / 'ajukan pengembalian': Setujui -> value dikembalikan --}}
                                            @case('ajukan kembali')
                                            @case('ajukan pengembalian')
                                                <form action="{{ url('/petugas/persetujuan/update/' . $idPeminjaman) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="dikembalikan">
                                                    <button type="submit"
                                                        onclick="return confirm('Konfirmasi pengembalian alat ini?')"
                                                        class="px-3.5 py-1.5 bg-emerald-600 text-white rounded-lg text-xs font-semibold hover:bg-emerald-700 transition flex items-center space-x-1.5 shadow-sm">
                                                        <i class="fa-solid fa-circle-check"></i>
                                                        <span>Setujui Pengembalian</span>
                                                    </button>
                                                </form>
                                            @break

                                            {{-- 4. Status Lain (dikembalikan/ditolak/selesai): Tampilan netral --}}

                                            @default
                                                <span class="text-xs text-slate-400 font-medium italic">- Selesai -</span>
                                        @endswitch

                                    </div>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-xs text-slate-400">
                                        Belum ada pengajuan peminjaman untuk dikonfirmasi.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endsection
