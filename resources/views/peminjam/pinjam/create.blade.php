@extends('Layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto space-y-6">
        <!-- Header Page -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm">
            <h2 class="text-xl font-bold text-slate-800">Form Pengajuan Peminjaman</h2>
            <p class="text-xs text-slate-500 mt-0.5">Lengkapi data di bawah ini untuk mengajukan peminjaman alat inventaris.
            </p>
        </div>

        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm space-y-5">

            <!-- Informasi Detail Alat -->
            <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 flex items-start sm:items-center space-x-4">
                @if ($alat->foto)
                    <img src="{{ asset('uploads/alat/' . $alat->foto) }}" alt="{{ $alat->nama_alat }}"
                        class="w-16 h-16 rounded-lg object-cover border border-slate-200 bg-white shrink-0">
                @else
                    <div
                        class="w-16 h-16 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-toolbox text-2xl"></i>
                    </div>
                @endif

                <div class="space-y-1 flex-1">
                    <div class="flex items-center justify-between">
                        <h4 class="font-bold text-slate-800 text-base">{{ $alat->nama_alat }}</h4>
                        <span
                            class="px-2 py-0.5 bg-indigo-50 text-indigo-600 border border-indigo-100 rounded text-[10px] font-bold uppercase">
                            {{ $alat->kategori->nama_kategori ?? '-' }}
                        </span>
                    </div>

                    <div class="flex flex-wrap items-center gap-3 text-xs text-slate-500">
                        <span><i class="fa-solid fa-[#10B981] fa-circle-info text-slate-400 mr-1"></i>Kondisi: <b
                                class="text-slate-700 capitalize">{{ str_replace('_', ' ', $alat->kondisi) }}</b></span>
                        <span>•</span>
                        <span><i class="fa-solid fa-boxes-stacked text-slate-400 mr-1"></i>Stok Tersedia: <b
                                class="text-indigo-600 font-bold">{{ $alat->stok }}</b> unit</span>
                    </div>

                    @if ($alat->spesifikasi)
                        <p class="text-[11px] text-slate-400 line-clamp-1 mt-0.5">Spesifikasi: {{ $alat->spesifikasi }}</p>
                    @endif
                </div>
            </div>
            <!-- Menampilkan pesan error stok (Session Alert) -->
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Menampilkan pesan error dari Validasi Input -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <!-- Form Pengajuan -->
            <form action="{{ url('/peminjam/pinjam/store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="id_alat" value="{{ $alat->id_alat }}">
                <input type="hidden" name="tanggal_pinjam" value="{{ now()->toDateString() }}">

                <!-- Input Jumlah Pinjam -->
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Jumlah Pinjam</label>
                    <input type="number" name="jumlah" min="1" max="{{ $alat->stok }}" value="1" required
                        class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="Masukkan jumlah yang ingin dipinjam">
                    <p class="text-[10px] text-slate-400 mt-1">*Maksimal peminjaman {{ $alat->stok }} unit sesuai
                        ketersediaan stok.</p>
                </div>

                <!-- Input Tanggal Rencana Kembali -->
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Tanggal Rencana Kembali</label>
                    <input type="date" name="tanggal_kembali" min="{{ date('Y-m-d') }}" required
                        class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <!-- Action Buttons -->
                <div class="pt-3 flex justify-end space-x-2 border-t border-slate-100">
                    <a href="{{ url('/peminjam/katalog') }}"
                        class="px-4 py-2 bg-slate-100 text-slate-600 rounded-lg text-xs font-semibold hover:bg-slate-200 transition inline-flex items-center">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-xs font-semibold hover:bg-indigo-700 transition flex items-center space-x-1 shadow-sm shadow-indigo-100">
                        <i class="fa-solid fa-paper-plane mr-1"></i>
                        <span>Kirim Pengajuan</span>
                    </button>
                </div>
            </form>

        </div>
    </div>
@endsection
