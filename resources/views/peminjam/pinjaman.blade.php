@extends('Layouts.app')

@section('content')
    @if (session('success'))
        <div
            class="my-4 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-sm p-4 rounded-xl flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-200">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif
    <div class="space-y-6">
        <!-- Header Page -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-800">Pinjaman Saya</h2>
                <p class="text-xs text-slate-500 mt-0.5">Daftar alat yang sedang Anda pinjam beserta riwayatnya.</p>
            </div>
            <a href="{{ url('/peminjam/katalog') }}"
                class="px-3.5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-semibold transition flex items-center space-x-1.5 shadow-sm">
                <i class="fa-solid fa-plus"></i>
                <span>Pinjam Alat Lagi</span>
            </a>
        </div>

        <!-- Cards Grid Peminjaman -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse ($pinjamanSaya as $item)
                @php
                    $alat = $item->alat ?? $item;
                    $namaAlat = $alat->nama_alat ?? ($item->nama_alat ?? '-');
                    $fotoAlat = $alat->foto ?? ($item->foto ?? null);
                    $kondisiAlat = strtolower($alat->kondisi ?? ($item->kondisi ?? 'baik'));
                    $status = strtolower($item->status ?? 'ajukan peminjaman');
                    $idPeminjaman = $item->id_peminjaman ?? $item->id;
                @endphp

                <!-- Card Item Pinjaman -->
                <div
                    class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition flex flex-col justify-between space-y-4">
                    <div class="space-y-3">

                        <!-- Top Header Card (Foto/Icon + Status) -->
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-center space-x-3">
                                @if ($fotoAlat)
                                    <img src="{{ asset('uploads/alat/' . $fotoAlat) }}" alt="{{ $namaAlat }}"
                                        class="w-12 h-12 rounded-lg object-cover border border-slate-200 bg-slate-50 shrink-0">
                                @else
                                    <div
                                        class="w-12 h-12 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0 border border-indigo-100">
                                        <i class="fa-solid fa-toolbox text-lg"></i>
                                    </div>
                                @endif
                                <div>
                                    <h3 class="font-bold text-slate-800 text-sm line-clamp-1" title="{{ $namaAlat }}">
                                        {{ $namaAlat }}
                                    </h3>
                                    <span class="text-[11px] text-slate-400">ID Pinjam: #PJ-0{{ $idPeminjaman }}</span>
                                </div>
                            </div>

                            <!-- SWITCH CASE: BADGE STATUS -->
                            @switch($status)
                                @case('ajukan peminjaman')
                                    <span
                                        class="px-2.5 py-1 rounded-md text-[11px] font-bold border uppercase tracking-wider bg-amber-50 text-amber-600 border-amber-100 shrink-0">
                                        Ajukan Peminjaman
                                    </span>
                                @break

                                @case('dipinjam')
                                    <span
                                        class="px-2.5 py-1 rounded-md text-[11px] font-bold border uppercase tracking-wider bg-indigo-50 text-indigo-600 border-indigo-100 shrink-0">
                                        Dipinjam
                                    </span>
                                @break

                                @case('ajukan kembali')
                                @case('ajukan pengembalian')
                                    <span
                                        class="px-2.5 py-1 rounded-md text-[11px] font-bold border uppercase tracking-wider bg-sky-50 text-sky-600 border-sky-100 shrink-0">
                                        Pengembalian
                                    </span>
                                @break

                                @case('dikembalikan')
                                @case('selesai')
                                    <span
                                        class="px-2.5 py-1 rounded-md text-[11px] font-bold border uppercase tracking-wider bg-emerald-50 text-emerald-600 border-emerald-100 shrink-0">
                                        Dikembalikan
                                    </span>
                                @break

                                @case('ditolak')
                                    <span
                                        class="px-2.5 py-1 rounded-md text-[11px] font-bold border uppercase tracking-wider bg-rose-50 text-rose-600 border-rose-100 shrink-0">
                                        Ditolak
                                    </span>
                                @break

                                @default
                                    <span
                                        class="px-2.5 py-1 rounded-md text-[11px] font-bold border uppercase tracking-wider bg-slate-50 text-slate-600 border-slate-200 shrink-0">
                                        {{ str_replace('_', ' ', $item->status) }}
                                    </span>
                            @endswitch
                        </div>

                        <!-- Panel Detail Informasi Tanggal & Kondisi -->
                        <div
                            class="bg-slate-50/80 p-3.5 rounded-lg text-xs space-y-2 text-slate-600 border border-slate-100">
                            <div class="flex justify-between items-center">
                                <span>Jumlah Pinjam:</span>
                                <span class="font-bold text-slate-800">{{ $item->jumlah }} Unit</span>
                            </div>

                            <!-- SWITCH CASE: BADGE KONDISI BARANG -->
                            <div class="flex justify-between items-center">
                                <span>Kondisi Barang:</span>
                                @switch($kondisiAlat)
                                    @case('baru')
                                    @case('baik')
                                        <span
                                            class="px-2 py-0.5 text-[10px] font-bold rounded uppercase border bg-emerald-50 text-emerald-600 border-emerald-100">
                                            {{ str_replace('_', ' ', $kondisiAlat) }}
                                        </span>
                                    @break

                                    @case('rusak_ringan')
                                        <span
                                            class="px-2 py-0.5 text-[10px] font-bold rounded uppercase border bg-amber-50 text-amber-600 border-amber-100">
                                            {{ str_replace('_', ' ', $kondisiAlat) }}
                                        </span>
                                    @break

                                    @case('rusak_berat')
                                        <span
                                            class="px-2 py-0.5 text-[10px] font-bold rounded uppercase border bg-rose-50 text-rose-600 border-rose-100">
                                            {{ str_replace('_', ' ', $kondisiAlat) }}
                                        </span>
                                    @break

                                    @default
                                        <span
                                            class="px-2 py-0.5 text-[10px] font-bold rounded uppercase border bg-slate-50 text-slate-600 border-slate-100">
                                            {{ str_replace('_', ' ', $kondisiAlat) }}
                                        </span>
                                @endswitch
                            </div>

                            <!-- TANGGAL + HARI -->
                            <div class="pt-1 border-t border-slate-200/60 space-y-1">
                                <div class="flex justify-between items-center">
                                    <span>Tgl Pinjam:</span>
                                    <span class="font-semibold text-slate-700">
                                        {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->translatedFormat('l, d M Y') }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span>Batas Kembali:</span>
                                    <span class="font-semibold text-rose-600">
                                        {{ \Carbon\Carbon::parse($item->tanggal_kembali)->translatedFormat('l, d M Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SWITCH CASE: TOMBOL AKSI -->
                    <div>
                        @switch($status)
                            {{-- Jika status DIPINJAM: Munculkan tombol aktif untuk Mengajukan Pengembalian --}}
                            @case('dipinjam')
                                <form action="{{ url('/peminjam/pinjaman/update/' . $idPeminjaman) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="ajukan kembali">
                                    <button type="submit" onclick="return confirm('Ajukan pengembalian untuk alat ini?')"
                                        class="w-full py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-semibold transition flex items-center justify-center space-x-1.5 shadow-sm">
                                        <i class="fa-solid fa-rotate-left"></i>
                                        <span>Kembalikan Alat Ini</span>
                                    </button>
                                </form>
                            @break

                            {{-- Jika status AJUKAN PEMINJAMAN / AJUKAN PENGEMBALIAN: Tampilkan Menunggu Persetujuan --}}
                            @case('ajukan peminjaman')
                            @case('ajukan kembali')

                            @case('ajukan pengembalian')
                                <button disabled
                                    class="w-full py-2 bg-slate-100 text-amber-600 rounded-lg text-xs font-semibold cursor-not-allowed border border-amber-200 flex items-center justify-center space-x-1.5">
                                    <i class="fa-solid fa-clock"></i>
                                    <span>Menunggu Persetujuan</span>
                                </button>
                            @break

                            {{-- Jika status DITOLAK --}}
                            @case('ditolak')
                                <button disabled
                                    class="w-full py-2 bg-rose-50 text-rose-500 rounded-lg text-xs font-semibold cursor-not-allowed border border-rose-200 flex items-center justify-center space-x-1.5">
                                    <i class="fa-solid fa-xmark"></i>
                                    <span>Peminjaman Ditolak</span>
                                </button>
                            @break

                            {{-- Jika status DIKEMBALIKAN / SELESAI --}}

                            @default
                                <button disabled
                                    class="w-full py-2 bg-emerald-50 text-emerald-500 border border-emerald-200/60 rounded-lg text-xs font-semibold cursor-not-allowed flex items-center justify-center space-x-1.5 opacity-80">
                                    <i class="fa-solid fa-circle-check"></i>
                                    <span>Peminjaman Selesai</span>
                                </button>
                        @endswitch
                    </div>

                </div>
                @empty
                    <div
                        class="col-span-full bg-white rounded-xl border border-slate-200 p-10 text-center text-slate-500 shadow-sm">
                        <i class="fa-solid fa-box-open text-4xl mb-3 text-slate-300"></i>
                        <h3 class="font-bold text-slate-700 text-sm">Belum Ada Pinjaman</h3>
                        <p class="text-xs text-slate-400 mt-1">Anda belum melakukan pengajuan peminjaman alat apapun.</p>
                    </div>
                @endforelse
            </div>
        </div>
    @endsection
