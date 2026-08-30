@extends('Layouts.app')

@section('content')
    <div class="space-y-6" x-data="{ openModal: false, editMode: false, namaKategori: '', keterangan: '' }">

        <!-- Header Page & Tombol Tambah -->
        <div
            class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-xl font-bold text-slate-800">Kelola Kategori Alat</h2>
                <p class="text-xs text-slate-500 mt-0.5">Pengelompokan jenis alat untuk memudahkan pencarian katalog.</p>
            </div>

            <!-- Button Trigger Modal Tambah -->
            <button @click="openModal = true; editMode = false; namaKategori = ''; keterangan = ''"
                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-semibold transition flex items-center space-x-2 shadow-sm shadow-indigo-100">
                <i class="fa-solid fa-plus"></i>
                <span>Tambah Kategori</span>
            </button>
        </div>

        <!-- Tabel Data Kategori -->
        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead
                        class="bg-slate-50 text-slate-700 border-b border-slate-200 uppercase text-[11px] font-bold tracking-wider">
                        <tr>
                            <th class="px-6 py-3.5">ID</th>
                            <th class="px-6 py-3.5">Nama Kategori</th>
                            <th class="px-6 py-3.5">Keterangan</th>
                            <th class="px-6 py-3.5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">

                        <!-- Row 1 -->
                        @forelse ($kategori as $kat)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="px-6 py-4 font-bold text-slate-400 text-xs">#KTG-0{{ $kat->id_kategori }}</td>
                                <td class="px-6 py-4 font-bold text-slate-800">{{ ucfirst($kat->nama_kategori) }}</td>
                                <td class="px-6 py-4 text-xs text-slate-500">{{ $kat->keterangan }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <button
                                            @click="openModal = true; editMode = true; kategoriId = '{{ $kat->id_kategori }}'; namaKategori = '{{ $kat->nama_kategori }}'; keterangan = '{{ $kat->keterangan }}'"
                                            class="p-2 text-amber-500 hover:bg-amber-50 rounded-lg transition"
                                            title="Edit Kategori">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <form id="delete-form-{{ $kat->id_kategori }}"
                                            action="/admin/kategori/delete/{{ $kat->id_kategori }}" method="POST" class="inline">
                                            @csrf
                                            @method('POST')
                                            <button type="button"
                                                onclick="showAlertConfirm('Hapus User?', 'Apakah kamu yakin ingin menghapus {{ $kat->nama_kategori }}?', function() { document.getElementById('delete-form-{{ $kat->id_kategori }}').submit(); })"
                                                class="p-2 text-rose-500 hover:bg-rose-50 rounded-lg transition"
                                                title="Hapus User">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="px-6 py-4 font-bold text-slate-400 text-xs">Data tidak ada</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- MODAL POPUP FORM (Create & Edit Kategori) -->
        <div x-show="openModal"
            class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4"
            x-cloak>
            <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl overflow-hidden transform transition-all">

                <!-- Modal Header -->
                <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                    <h3 class="font-bold text-slate-800" x-text="editMode ? 'Ubah Data Kategori' : 'Tambah Kategori Baru'">
                    </h3>
                    <button @click="openModal = false" class="text-slate-400 hover:text-slate-600">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <!-- Modal Form -->
                <form
                    :action="editMode ? '{{ url('/admin/kategori/update', '') }}/' + kategoriId :
                        '{{ url('/admin/kategori/store') }}'"
                    method="POST" class="p-6 space-y-4">
                    @csrf

                    <template x-if="editMode">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <!-- Nama Kategori -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Nama Kategori</label>
                        <input type="text" name="nama_kategori" x-model="namaKategori" required
                            placeholder="Contoh: Elektronik, Perkakas..." 
                            class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            {{-- @error('nama_kategori')
                                <div class="text-danger small mt-1 fw-bold">{{ $message }}</div>
                            @enderror --}}
                    </div>

                    <!-- Keterangan / Deskripsi -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Keterangan (Opsional)</label>
                        <textarea rows="3" name="keterangan" x-model="keterangan" required
                            placeholder="Penjelasan singkat mengenai kategori ini..."
                            class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                            {{-- @error('keterangan')
                                <div class="text-danger small mt-1 fw-bold">{{ $message }}</div>
                            @enderror --}}
                    </div>

                    <!-- Footer Modal Buttons -->
                    <div class="pt-4 flex justify-end space-x-2 border-t border-slate-100">
                        <button type="button" @click="openModal = false"
                            class="px-4 py-2 bg-slate-100 text-slate-600 rounded-lg text-xs font-semibold hover:bg-slate-200 transition">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-xs font-semibold hover:bg-indigo-700 transition"
                            x-text="editMode ? 'Simpan Perubahan' : 'Tambah Kategori'">
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection
