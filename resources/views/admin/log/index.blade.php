@extends('Layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="bg-white p-5 rounded-xl border border-slate-200 flex justify-between items-center">
            <div>
                <h2 class="text-xl font-bold text-slate-800">Log Aktivitas Sistem</h2>
                <p class="text-xs text-slate-500">Catatan riwayat aksi seluruh pengguna di dalam aplikasi.</p>
            </div>
            <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-xs font-semibold">
                Total Log: {{ $total }} Aktivitas
            </span>
        </div>

        <!-- Timeline Log -->
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
            <div
                class="relative pl-6 space-y-6 before:absolute before:left-2 before:top-2 before:bottom-2 before:w-0.5 before:bg-slate-200">

                @foreach ($logAktivitas as $item)
                                    @php
                    // Ambil role dari relasi user, pastikan aman pakai nullsafe operator (?)
                    $roleUser = $item->user->role ?? 'default';

                    // Tentukan warna bullet indikator otomatis berdasarkan role
                    $dotColor = match ($roleUser) {
                        'petugas' => 'bg-emerald-500',
                        'peminjam' => 'bg-indigo-500',
                        default => 'bg-rose-500',
                    };
                                    @endphp

                                    <!-- Item Log -->
                                    <div class="relative mb-4">
                                        <!-- Gunakan variabel $dotColor di sini agar warnanya dinamis -->
                                        <div
                                            class="absolute -left-[21px] top-1.5 w-3 h-3 rounded-full {{ $dotColor }} ring-4 ring-white">
                                        </div>

                                        <div class="flex justify-between items-start">
                                            <div>
                                                <!-- Diubah menjadi $item->user->username dan $item->user->role -->
                                                <p class="text-sm font-bold text-slate-800">
                                                    {{ $item->user->username ?? 'User Tidak Ditemukan' }}
                                                    <span class="font-normal text-slate-500">({{ $item->user->role ?? '-' }})</span>
                                                </p>

                                                <p class="text-xs text-slate-600 mt-0.5">
                                                    <span class="font-semibold text-slate-700">{{ $item->keterangan }}</span>
                                                </p>
                                            </div>

                                            <span class="text-xs text-slate-400">{{ $item->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
