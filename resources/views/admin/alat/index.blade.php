{{-- @dd(Auth::user()->role) --}}
@extends('Layouts.app')

@section('content')
    <!-- Deklarasikan semua variabel x-model AlpineJS di sini -->
    <div class="space-y-6" x-data="{
        openModal: false,
        editMode: false,
        alatId: '',
        nama_alat: '',
        id_kategori: '',
        stok: '',
        kondisi: 'baru',
        spesifikasi: ''
    }">

        <!-- Header Page & Tombol Tambah -->
        @if (session('success'))
            <div
                class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-sm p-4 rounded-xl flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-200"><i
                        class="fas fa-times"></i></button>
            </div>
        @endif
        <div
            class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-xl font-bold text-slate-800">Kelola Data Alat</h2>
                <p class="text-xs text-slate-500 mt-0.5">Tambah, ubah, dan hapus data inventaris alat yang dapat dipinjam.
                </p>
            </div>

            <!-- Tombol Tambah Alat (Reset nilai modal) -->
            <button
                @click="
                        openModal = true; 
                        editMode = false; 
                        alatId = ''; 
                        nama_alat = ''; 
                        id_kategori = ''; 
                        stok = ''; 
                        kondisi = 'baru'; 
                        spesifikasi = '';
                    "
                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-semibold transition flex items-center space-x-2 shadow-sm shadow-indigo-100">
                <i class="fa-solid fa-plus"></i>
                <span>Tambah Alat Baru</span>
            </button>
        </div>

        <!-- Tabel Data Alat (Read) -->
        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead
                        class="bg-slate-50 text-slate-700 border-b border-slate-200 uppercase text-[11px] font-bold tracking-wider">
                        <tr>
                            <th class="px-6 py-3.5">Gambar & Nama Alat</th>
                            <th class="px-6 py-3.5">Kategori</th>
                            <th class="px-6 py-3.5">Spesifikasi</th>
                            <th class="px-6 py-3.5">Kondisi</th>
                            <th class="px-6 py-3.5">Stok</th>
                            <th class="px-6 py-3.5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">

                        @forelse ($alat as $item)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="px-6 py-4 flex items-center space-x-3">
                                    <img src="{{ asset('uploads/alat/' . $item->foto) }}" alt="{{ $item->nama_alat }}"
                                        class="w-12 h-12 rounded-lg object-cover border border-slate-200 bg-slate-100">
                                    <div>
                                        <p class="font-bold text-slate-800 text-sm">{{ $item->nama_alat }}</p>
                                        <span class="text-[11px] text-slate-400">ID Alat: #ALT-0{{ $item->id_alat }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-medium text-slate-700">
                                    {{ ucfirst($item->nama_kategori ?? ($item->kategori->nama_kategori ?? '-')) }}
                                </td>
                                <td class="px-6 py-4 text-xs text-slate-500 max-w-xs truncate">{{ $item->spesifikasi }}</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2.5 py-1 bg-emerald-50 text-emerald-600 rounded-md text-xs font-semibold border border-emerald-100 uppercase">
                                        {{ str_replace('_', ' ', $item->kondisi ?? $item->Kondisi) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 font-bold text-slate-800">{{ $item->stok }}</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <!-- Tombol Edit -->
                                        <button
                                            @click="
                                                        openModal = true; 
                                                        editMode = true; 
                                                        alatId = '{{ $item->id_alat }}'; 
                                                        nama_alat = '{{ addslashes($item->nama_alat) }}'; 
                                                        id_kategori = '{{ $item->id_kategori }}'; 
                                                        stok = '{{ $item->stok }}'; 
                                                        kondisi = '{{ $item->kondisi ?? $item->Kondisi }}'; 
                                                        spesifikasi = '{{ addslashes($item->spesifikasi) }}';
                                                    "
                                            class="p-2 text-amber-500 hover:bg-amber-50 rounded-lg transition"
                                            title="Edit Data">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>

                                        <!-- Form Hapus (Delete) -->
                                        <form id="delete-form-{{ $item->id_alat }}"
                                            action="/admin/alat/delete/{{ $item->id_alat }}" method="POST" class="inline">
                                            @csrf
                                            @method('post')
                                            <button type="button"
                                                onclick="hapus('delete-form-{{ $item->id_alat }}', '{{ addslashes($item->nama_alat) }}')"
                                                class="p-2 text-rose-500 hover:bg-rose-50 rounded-lg transition"
                                                title="Hapus Data">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="hover:bg-slate-50/80 transition">
                                <td colspan="6" class="px-6 py-6 text-center text-xs text-slate-400">Tidak ada data alat
                                    tersimpan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- MODAL POPUP FORM (Create & Edit) -->
        <div x-show="openModal"
            class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4"
            x-cloak>
            <div class="bg-white rounded-2xl max-w-lg w-full shadow-2xl overflow-hidden transform transition-all">

                <!-- Modal Header -->
                <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                    <h3 class="font-bold text-slate-800" x-text="editMode ? 'Ubah Data Alat' : 'Tambah Alat Baru'"></h3>
                    <button @click="openModal = false" class="text-slate-400 hover:text-slate-600">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <!-- Modal Form -->
                <form class="p-6 space-y-4"
                    :action="editMode ? '{{ url('/admin/alat/update', '') }}/' + alatId : '{{ url('/admin/alat/store') }}'"
                    method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Token Method PUT Saat Edit -->
                    <template x-if="editMode">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <!-- Nama Alat -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Nama Alat</label>
                        <input type="text" placeholder="Masukkan nama alat..." name="nama_alat" x-model="nama_alat"
                            required
                            class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <!-- Kategori & Stok (Grid 2 Kolom) -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Kategori</label>
                            <select name="id_kategori" x-model="id_kategori" required
                                class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white">
                                <option value="">Pilih Kategori</option>
                                @foreach ($kategori as $data)
                                    <option value="{{ $data->id_kategori }}">{{ ucfirst($data->nama_kategori) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Jumlah Stok</label>
                            <input type="number" min="0" placeholder="Contoh: 5" name="stok" x-model="stok"
                                class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                    </div>

                    <!-- Kondisi Alat -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Kondisi Alat</label>
                        <select name="kondisi" x-model="kondisi" required
                            class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white">
                            <option value="baru">Baru</option>
                            <option value="rusak_ringan">Rusak Ringan</option>
                            <option value="rusak_berat">Rusak Berat</option>
                        </select>
                    </div>

                    <!-- Spesifikasi -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Spesifikasi</label>
                        <textarea rows="3" placeholder="Tuliskan spesifikasi detail alat..." name="spesifikasi" x-model="spesifikasi"
                            required
                            class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                    </div>

                    <!-- Upload Foto -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Upload Foto Alat</label>
                        <input type="file" name="foto" :required="!editMode"
                            class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        <p class="text-[10px] text-slate-400 mt-1" x-show="editMode">*Kosongkan jika tidak ingin mengubah
                            foto alat.</p>
                    </div>

                    <!-- Footer Modal Buttons -->
                    <div class="pt-4 flex justify-end space-x-2 border-t border-slate-100">
                        <button type="button" @click="openModal = false"
                            class="px-4 py-2 bg-slate-100 text-slate-600 rounded-lg text-xs font-semibold hover:bg-slate-200 transition">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-xs font-semibold hover:bg-indigo-700 transition"
                            x-text="editMode ? 'Simpan Perubahan' : 'Tambah Alat'">
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
@endsection
