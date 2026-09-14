@extends('Layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto space-y-6">
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-800">Tambah Alat Baru</h2>
                <p class="text-xs text-slate-500 mt-0.5">Isi formulir di bawah ini untuk menambahkan data inventaris baru.
                </p>
            </div>
            <a href="{{ url('/admin/alat') }}"
                class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg text-xs font-semibold transition">
                <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <form action="{{ url('/admin/alat/store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Nama Alat</label>
                    <input type="text" placeholder="Masukkan nama alat..." name="nama_alat"
                        value="{{ old('nama_alat') }}" required
                        class="w-full px-3 py-2 border @error('nama_alat') border-rose-500 ring-1 ring-rose-500 @else border-slate-200 @enderror rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('nama_alat')
                        <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Kategori & Stok -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Kategori</label>
                        <select name="id_kategori" required
                            class="w-full px-3 py-2 border @error('id_kategori') border-rose-500 @else border-slate-200 @enderror rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white">
                            <option value="">Pilih Kategori</option>
                            @foreach ($kategori as $data)
                                <option value="{{ $data->id_kategori }}"
                                    {{ old('id_kategori') == $data->id_kategori ? 'selected' : '' }}>
                                    {{ ucfirst($data->nama_kategori) }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_kategori')
                            <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Jumlah Stok</label>
                        <input type="number" min="0" placeholder="Contoh: 5" name="stok"
                            value="{{ old('stok') }}" required
                            class="w-full px-3 py-2 border @error('stok') border-rose-500 @else border-slate-200 @enderror rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @error('stok')
                            <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Kondisi Alat -->
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Kondisi Alat</label>
                    <select name="kondisi" required
                        class="w-full px-3 py-2 border @error('kondisi') border-rose-500 @else border-slate-200 @enderror rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white">
                        <option value="baru" {{ old('kondisi') == 'baru' ? 'selected' : '' }}>Baru</option>
                        <option value="rusak_ringan" {{ old('kondisi') == 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan
                        </option>
                        <option value="rusak_berat" {{ old('kondisi') == 'rusak_berat' ? 'selected' : '' }}>Rusak Berat
                        </option>
                    </select>
                    @error('kondisi')
                        <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Spesifikasi -->
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Spesifikasi</label>
                    <textarea rows="3" placeholder="Tuliskan spesifikasi detail alat..." name="spesifikasi" required
                        class="w-full px-3 py-2 border @error('spesifikasi') border-rose-500 @else border-slate-200 @enderror rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('spesifikasi') }}</textarea>
                    @error('spesifikasi')
                        <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Upload Foto -->
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Upload Foto Alat</label>
                    <input type="file" name="foto" required
                        class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    @error('foto')
                        <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Submit Button -->
                <div class="pt-4 flex justify-end space-x-2 border-t border-slate-100">
                    <a href="{{ url('/admin/alat') }}"
                        class="px-4 py-2 bg-slate-100 text-slate-600 rounded-lg text-xs font-semibold hover:bg-slate-200 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-xs font-semibold hover:bg-indigo-700 transition">
                        Simpan Alat
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
