{{-- @dd(Auth::user()->role) --}}
@extends('Layouts.app')

@section('content')
    <div class="space-y-6" x-data="{ openModal: false, editMode: false }">

        <!-- Header Page & Tombol Tambah -->
        <div
            class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-xl font-bold text-slate-800">Kelola Data Alat</h2>
                <p class="text-xs text-slate-500 mt-0.5">Tambah, ubah, dan hapus data inventaris alat yang dapat dipinjam.
                </p>
            </div>

            <!-- Button Trigger Modal Tambah -->
            <button @click="openModal = true; editMode = false"
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

                        <!-- Baris Data 1 -->
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="px-6 py-4 flex items-center space-x-3">
                                <img src="https://via.placeholder.com/80"
                                    class="w-12 h-12 rounded-lg object-cover border border-slate-200 bg-slate-100"
                                    alt="Foto Alat">
                                <div>
                                    <p class="font-bold text-slate-800 text-sm">Proyektor Epson EB-X400</p>
                                    <span class="text-[11px] text-slate-400">ID Alat: #ALT-01</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-medium text-slate-700">Elektronik</td>
                            <td class="px-6 py-4 text-xs text-slate-500 max-w-xs truncate">HDMI, VGA, 3300 Lumens, Remote
                                Control Included</td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2.5 py-1 bg-emerald-50 text-emerald-600 rounded-md text-xs font-semibold border border-emerald-100">Baru</span>
                            </td>
                            <td class="px-6 py-4 font-bold text-slate-800">5 Unit</td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <!-- Tombol Edit -->
                                    <button @click="openModal = true; editMode = true"
                                        class="p-2 text-amber-500 hover:bg-amber-50 rounded-lg transition"
                                        title="Edit Data">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <!-- Tombol Hapus (Delete) -->
                                    <button class="p-2 text-rose-500 hover:bg-rose-50 rounded-lg transition"
                                        title="Hapus Data">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Baris Data 2 -->
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="px-6 py-4 flex items-center space-x-3">
                                <img src="https://via.placeholder.com/80"
                                    class="w-12 h-12 rounded-lg object-cover border border-slate-200 bg-slate-100"
                                    alt="Foto Alat">
                                <div>
                                    <p class="font-bold text-slate-800 text-sm">Kamera DSLR Canon EOS 600D</p>
                                    <span class="text-[11px] text-slate-400">ID Alat: #ALT-02</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-medium text-slate-700">Kamera & Foto</td>
                            <td class="px-6 py-4 text-xs text-slate-500 max-w-xs truncate">Lensa Kit 18-55mm IS II, Baterai,
                                Charger</td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2.5 py-1 bg-amber-50 text-amber-600 rounded-md text-xs font-semibold border border-amber-100">Rusak
                                    Ringan</span>
                            </td>
                            <td class="px-6 py-4 font-bold text-slate-800">2 Unit</td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <button @click="openModal = true; editMode = true"
                                        class="p-2 text-amber-500 hover:bg-amber-50 rounded-lg transition">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <button class="p-2 text-rose-500 hover:bg-rose-50 rounded-lg transition">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>

        <!-- MODAL POPUP FORM (Create & Edit) -->
        <!-- Catatan: Memakai library AlpineJS ringan untuk toggle Buka/Tutup modal -->
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

                <!-- Modal Form (Create / Update) -->
                <form class="p-6 space-y-4">

                    <!-- Nama Alat -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Nama Alat</label>
                        <input type="text" placeholder="Masukkan nama alat..."
                            class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <!-- Kategori & Stok (Grid 2 Kolom) -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Kategori</label>
                            <select
                                class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="">Pilih Kategori</option>
                                <option value="1">Elektronik</option>
                                <option value="2">Kamera & Foto</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Jumlah Stok</label>
                            <input type="number" min="1" placeholder="Contoh: 5"
                                class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                    </div>

                    <!-- Kondisi Alat -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Kondisi Alat</label>
                        <select
                            class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="baru">Baru</option>
                            <option value="rusak_ringan">Rusak Ringan</option>
                            <option value="rusak_berat">Rusak Berat</option>
                        </select>
                    </div>

                    <!-- Spesifikasi -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Spesifikasi</label>
                        <textarea rows="3" placeholder="Tuliskan spesifikasi detail alat..."
                            class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                    </div>

                    <!-- Upload Foto -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Upload Foto Alat</label>
                        <input type="file"
                            class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
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

    <!-- Masukkan Script AlpineJS di bawah untuk mengaktifkan fungsi Pop-up Modal -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection
