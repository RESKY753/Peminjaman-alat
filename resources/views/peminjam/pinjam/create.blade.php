@extends('Layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto space-y-6">
        <div class="bg-white p-5 rounded-xl border border-slate-200">
            <h2 class="text-xl font-bold text-slate-800">Form Pengajuan Peminjaman</h2>
            <p class="text-xs text-slate-500">Lengkapi data di bawah ini untuk mengajukan peminjaman alat.</p>
        </div>

        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm space-y-4">
            <!-- Informasi Alat yang Dipilih -->
            <div class="p-4 bg-slate-50 rounded-lg border border-slate-100 flex items-center space-x-4">
                <div class="p-3 bg-indigo-100 text-indigo-600 rounded-lg"><i class="fa-solid fa-laptop text-xl"></i></div>
                <div>
                    <h4 class="font-bold text-slate-800">Laptop Asus ROG Strix</h4>
                    <p class="text-xs text-slate-500">Kondisi: Baik | Stok Tersedia: 3</p>
                </div>
            </div>

            <form class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Tanggal Rencana Kembali</label>
                    <input type="date"
                        class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div class="pt-2 flex justify-end space-x-2">
                    <button type="button"
                        class="px-4 py-2 bg-slate-100 text-slate-600 rounded-lg text-xs font-semibold hover:bg-slate-200 transition">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-xs font-semibold hover:bg-indigo-700 transition">Kirim
                        Pengajuan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
