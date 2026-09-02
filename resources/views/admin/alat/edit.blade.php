@extends('Layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto space-y-6">
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-800">Ubah Data Alat</h2>
                <p class="text-xs text-slate-500 mt-0.5">Perbarui rincian informasi untuk {{ $alat->nama_alat }}.</p>
            </div>
            <a href="{{ url('/admin/alat') }}"
                class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg text-xs font-semibold transition">
                <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <form action="{{ url('/admin/alat/update/' . $alat->id_alat) }}" method="POST" enctype="multipart/form-data"
                class="space-y-4">
                @csrf
                @method('PUT')

                <!-- Nama Alat -->
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Nama Alat</label>
                    <input type="text" value="{{ $alat->nama_alat }}" name="nama_alat" required
                        class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <!-- Kategori & Stok -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Kategori</label>
                        <select name="id_kategori" required
                            class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white">
                            <option value="">Pilih Kategori</option>
                            @foreach ($kategori as $data)
                                <option value="{{ $data->id_kategori }}"
                                    {{ $alat->id_kategori == $data->id_kategori ? 'selected' : '' }}>
                                    {{ ucfirst($data->nama_kategori) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Jumlah Stok</label>
                        <input type="number" min="0" value="{{ $alat->stok }}" name="stok" required
                            class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>

                <!-- Kondisi Alat -->
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Kondisi Alat</label>
                    <select name="kondisi" required
                        class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white">
                        <option value="baru" {{ $alat->kondisi == 'baru' ? 'selected' : '' }}>Baru</option>
                        <option value="rusak_ringan" {{ $alat->kondisi == 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan
                        </option>
                        <option value="rusak_berat" {{ $alat->kondisi == 'rusak_berat' ? 'selected' : '' }}>Rusak Berat
                        </option>
                    </select>
                </div>

                <!-- Spesifikasi -->
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Spesifikasi</label>
                    <textarea rows="3" name="spesifikasi" required
                        class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ $alat->spesifikasi }}</textarea>
                </div>

                <!-- Upload Foto -->
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Upload Foto Alat</label>
                    <input type="file" name="foto"
                        class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    <p class="text-[10px] text-slate-400 mt-1">*Kosongkan jika tidak ingin mengubah foto alat.</p>
                </div>

                <!-- Submit Button -->
                <div class="pt-4 flex justify-end space-x-2 border-t border-slate-100">
                    <a href="{{ url('/admin/alat') }}"
                        class="px-4 py-2 bg-slate-100 text-slate-600 rounded-lg text-xs font-semibold hover:bg-slate-200 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-xs font-semibold hover:bg-indigo-700 transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
