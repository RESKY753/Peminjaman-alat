@extends('Layouts.app')

@section('content')
    <div class="space-y-6" x-data="{ openModal: false, editMode: false, namaKategori: '', keterangan: '' }">

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
                            <th class="px-6 py-3.5">Status</th>
                            <th class="px-6 py-3.5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">

                        <!-- Row 1 -->
                        @forelse ($kategori as $kat)
                            @php
                                $isFalse = strtolower($kat->status_aktif) === 'false';
                            @endphp
                            <tr
                                class="transition {{ $isFalse ? 'bg-slate-100/80 text-slate-400' : 'hover:bg-slate-50/80' }}">
                                <td class="px-6 py-4 font-bold text-slate-400 text-xs">#KTG-0{{ $kat->id_kategori }}</td>
                                <td class="px-6 py-4 font-bold text-slate-800">{{ ucfirst($kat->nama_kategori) }}</td>
                                <td class="px-6 py-4 text-xs text-slate-500">{{ $kat->keterangan }}
                                </td>
                                <td class="px-6 py-4">
                                    @if ($isFalse)
                                        <span
                                            class="px-2.5 py-1 bg-rose-100 text-rose-700 rounded-md text-xs font-bold border border-rose-300 uppercase tracking-wider">
                                            Nonaktif
                                        </span>
                                    @else
                                        <span
                                            class="px-2.5 py-1 bg-emerald-50 text-emerald-700 rounded-md text-xs font-semibold border border-emerald-200 uppercase tracking-wider">
                                            Aktif
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <button
                                            @click="openModal = true; editMode = true; kategoriId = '{{ $kat->id_kategori }}'; namaKategori = '{{ $kat->nama_kategori }}'; keterangan = '{{ $kat->keterangan }}'"
                                            class="p-2 text-amber-500 hover:bg-amber-50 rounded-lg transition"
                                            title="Edit Kategori">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <!-- Form Toggle Nonaktif / Pulihkan -->
                                        @if ($isFalse)
                                            <form action="{{ url('/admin/kategori/pulihkan/' . $kat->id_kategori) }}"
                                                method="POST"
                                                onsubmit="return confirm('Apakah kamu yakin ingin memulihkan kategori ini?')"
                                                class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="px-2.5 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-600 rounded-lg text-xs font-semibold transition flex items-center space-x-1"
                                                    title="Pulihkan Alat">
                                                    <i class="fa-solid fa-rotate-left"></i>
                                                    <span>Pulihkan</span>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ url('/admin/kategori/nonaktif/' . $kat->id_kategori) }}"
                                                method="POST"
                                                onsubmit="return confirm('Apakah kamu yakin ingin menonaktifkan kategori ini?')"
                                                class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="p-2 text-rose-500 hover:bg-rose-50 rounded-lg transition"
                                                    title="Nonaktifkan Alat">
                                                    <i class="fa-solid fa-ban"></i>
                                                </button>
                                            </form>
                                        @endif
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
                            oninvalid="this.setCustomValidity('Nama kategori wajib diisi!')"
                            oninput="this.setCustomValidity('')" placeholder="Contoh: Elektronik, Perkakas..."
                            class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        {{-- @error('nama_kategori')
                                <div class="text-danger small mt-1 fw-bold">{{ $message }}</div>
                            @enderror --}}
                    </div>

                    <!-- Keterangan / Deskripsi -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Keterangan (Opsional)</label>
                        <textarea rows="3" name="keterangan" x-model="keterangan" required
                            oninvalid="this.setCustomValidity('Keterangan wajib diisi!')" oninput="this.setCustomValidity('')"
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
