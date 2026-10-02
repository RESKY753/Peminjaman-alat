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
                    $spesifikasiAlat = $alat->spesifikasi ?? ($item->spesifikasi ?? 'Tidak ada spesifikasi khusus');
                    $kondisiAlat = strtolower($alat->kondisi ?? ($item->kondisi ?? 'baik'));
                    $status = strtolower($item->status ?? 'ajukan peminjaman');
                    $idPeminjaman = $item->id_peminjaman ?? $item->id;
                @endphp

                <!-- Card Item Pinjaman -->
                <div
                    class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition flex flex-col justify-between space-y-4">
                    <div class="space-y-4">

                        <!-- Top Header Card: Foto & Info Utama -->
                        <div class="flex items-start space-x-3.5">
                            @if ($fotoAlat)
                                <img src="{{ asset('uploads/alat/' . $fotoAlat) }}" alt="{{ $namaAlat }}"
                                    class="w-14 h-14 rounded-xl object-cover border border-slate-200 bg-slate-50 shrink-0">
                            @else
                                <div
                                    class="w-14 h-14 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0 border border-indigo-100">
                                    <i class="fa-solid fa-toolbox text-xl"></i>
                                </div>
                            @endif

                            <div class="flex-1 min-w-0">
                                <h3 class="font-bold text-slate-800 text-sm truncate" title="{{ $namaAlat }}">
                                    {{ $namaAlat }}
                                </h3>
                                <p class="text-[11px] text-slate-400">ID Pinjam: #PJ-0{{ $idPeminjaman }}</p>
                                <p class="text-xs text-slate-500 line-clamp-1 mt-0.5" title="{{ $spesifikasiAlat }}">
                                    {{ $spesifikasiAlat }}
                                </p>
                            </div>
                        </div>

                        <!-- Badge Status -->
                        <div>
                            @switch($status)
                                @case('ajukan peminjaman')
                                    <span
                                        class="inline-block px-3 py-1 rounded-lg text-[11px] font-bold border uppercase tracking-wider bg-amber-50 text-amber-600 border-amber-200">
                                        <i class="fa-solid fa-clock mr-1"></i> Ajukan Peminjaman
                                    </span>
                                @break

                                @case('dipinjam')
                                    <span
                                        class="inline-block px-3 py-1 rounded-lg text-[11px] font-bold border uppercase tracking-wider bg-indigo-50 text-indigo-600 border-indigo-200">
                                        <i class="fa-solid fa-box-archive mr-1"></i> Dipinjam
                                    </span>
                                @break

                                @case('ajukan kembali')
                                @case('ajukan pengembalian')
                                    <span
                                        class="inline-block px-3 py-1 rounded-lg text-[11px] font-bold border uppercase tracking-wider bg-sky-50 text-sky-600 border-sky-200">
                                        <i class="fa-solid fa-rotate mr-1"></i> Menunggu Konfirmasi Pengembalian
                                    </span>
                                @break

                                @case('dikembalikan')
                                @case('selesai')
                                    <span
                                        class="inline-block px-3 py-1 rounded-lg text-[11px] font-bold border uppercase tracking-wider bg-emerald-50 text-emerald-600 border-emerald-200">
                                        <i class="fa-solid fa-circle-check mr-1"></i> Dikembalikan
                                    </span>
                                @break

                                @case('ditolak')
                                    <span
                                        class="inline-block px-3 py-1 rounded-lg text-[11px] font-bold border uppercase tracking-wider bg-rose-50 text-rose-600 border-rose-200">
                                        <i class="fa-solid fa-ban mr-1"></i> Ditolak
                                    </span>
                                @break

                                @case('pengembalian ditolak')
                                    <span
                                        class="inline-block px-3 py-1 rounded-lg text-[11px] font-bold border uppercase tracking-wider bg-rose-50 text-rose-600 border-rose-200">
                                        <i class="fa-solid fa-triangle-exclamation mr-1"></i> Pengembalian Ditolak
                                    </span>
                                @break

                                @default
                                    <span
                                        class="inline-block px-3 py-1 rounded-lg text-[11px] font-bold border uppercase tracking-wider bg-slate-50 text-slate-600 border-slate-200">
                                        {{ str_replace('_', ' ', $item->status) }}
                                    </span>
                            @endswitch
                        </div>

                        <!-- Panel Detail Informasi Tanggal & Kondisi -->
                        <div class="bg-slate-50 p-3.5 rounded-xl text-xs space-y-2 text-slate-600 border border-slate-100">
                            <div class="flex justify-between items-center">
                                <span class="text-slate-500">Jumlah Pinjam:</span>
                                <span class="font-bold text-slate-800">{{ $item->jumlah }} Unit</span>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-slate-500">Kondisi Barang:</span>
                                @switch($kondisiAlat)
                                    @case('baru')
                                    @case('baik')
                                        <span
                                            class="px-2 py-0.5 text-[10px] font-bold rounded-md uppercase border bg-emerald-50 text-emerald-600 border-emerald-200">
                                            {{ str_replace('_', ' ', $kondisiAlat) }}
                                        </span>
                                    @break

                                    @case('rusak_ringan')
                                        <span
                                            class="px-2 py-0.5 text-[10px] font-bold rounded-md uppercase border bg-amber-50 text-amber-600 border-amber-200">
                                            {{ str_replace('_', ' ', $kondisiAlat) }}
                                        </span>
                                    @break

                                    @case('rusak_berat')
                                        <span
                                            class="px-2 py-0.5 text-[10px] font-bold rounded-md uppercase border bg-rose-50 text-rose-600 border-rose-200">
                                            {{ str_replace('_', ' ', $kondisiAlat) }}
                                        </span>
                                    @break

                                    @default
                                        <span
                                            class="px-2 py-0.5 text-[10px] font-bold rounded-md uppercase border bg-slate-50 text-slate-600 border-slate-200">
                                            {{ str_replace('_', ' ', $kondisiAlat) }}
                                        </span>
                                @endswitch
                            </div>

                            <div class="pt-2 border-t border-slate-200/60 space-y-1.5">
                                <div class="flex justify-between items-center">
                                    <span class="text-slate-500">Tgl Pinjam:</span>
                                    <span class="font-semibold text-slate-700">
                                        {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->translatedFormat('d M Y') }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-slate-500">Batas Kembali:</span>
                                    <span class="font-semibold text-rose-600">
                                        {{ \Carbon\Carbon::parse($item->tanggal_kembali)->translatedFormat('d M Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- KOTAK ALASAN PENOLAKAN (Hanya muncul jika status ditolak / pengembalian ditolak dan ada isinya) --}}
                        @if (($status == 'ditolak' || $status == 'pengembalian ditolak') && !empty($item->alasan))
                            <div
                                class="bg-rose-50/80 border border-rose-200 p-3 rounded-xl text-xs space-y-1 text-rose-700">
                                <p class="font-bold flex items-center gap-1.5">
                                    <i class="fa-solid fa-circle-exclamation"></i> Alasan Penolakan:
                                </p>
                                <p class="text-rose-600/90 italic pl-5">
                                    "{{ $item->alasan }}"
                                </p>
                            </div>
                        @endif

                    </div>

                    <!-- TOMBOL AKSI DI BAGIAN BAWAH -->
                    <div class="pt-2">
                        @switch($status)
                            @case('dipinjam')
                            @case('pengembalian ditolak')
                                <form action="{{ url('/peminjam/pinjaman/update/' . $idPeminjaman) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="ajukan kembali">
                                    <button type="submit" onclick="return confirm('Ajukan pengembalian ulang untuk alat ini?')"
                                        class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold transition flex items-center justify-center space-x-1.5 shadow-sm">
                                        <i class="fa-solid fa-rotate-left"></i>
                                        <span>Ajukan Pengembalian Ulang</span>
                                    </button>
                                </form>
                            @break

                            @case('ajukan peminjaman')
                            @case('ajukan kembali')

                            @case('ajukan pengembalian')
                                <button disabled
                                    class="w-full py-2.5 bg-slate-100 text-amber-600 rounded-xl text-xs font-semibold cursor-not-allowed border border-amber-200 flex items-center justify-center space-x-1.5">
                                    <i class="fa-solid fa-clock"></i>
                                    <span>Menunggu Persetujuan Petugas</span>
                                </button>
                            @break

                            @case('ditolak')
                                <button disabled
                                    class="w-full py-2.5 bg-rose-50 text-rose-500 rounded-xl text-xs font-semibold cursor-not-allowed border border-rose-200 flex items-center justify-center space-x-1.5">
                                    <i class="fa-solid fa-xmark"></i>
                                    <span>Peminjaman Ditolak</span>
                                </button>
                            @break

                            @default
                                <button disabled
                                    class="w-full py-2.5 bg-emerald-50 text-emerald-600 border border-emerald-200 rounded-xl text-xs font-semibold cursor-not-allowed flex items-center justify-center space-x-1.5 opacity-90">
                                    <i class="fa-solid fa-circle-check"></i>
                                    <span>Peminjaman Selesai</span>
                                </button>
                        @endswitch
                    </div>

                </div>
                @empty
                    <div
                        class="col-span-full bg-white rounded-2xl border border-slate-200 p-12 text-center text-slate-500 shadow-sm">
                        <i class="fa-solid fa-box-open text-4xl mb-3 text-slate-300"></i>
                        <h3 class="font-bold text-slate-700 text-sm">Belum Ada Pinjaman</h3>
                        <p class="text-xs text-slate-400 mt-1">Anda belum melakukan pengajuan peminjaman alat apapun.</p>
                    </div>
                @endforelse
            </div>
        </div>
    @endsection
