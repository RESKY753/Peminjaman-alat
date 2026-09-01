@extends('Layouts.app')

@section('content')
    <div class="space-y-6" x-data="{ openModal: false, editMode: false }">
        <div x-data="{
            openModal: false,
            editMode: false,
            userId: '',
            username: '',
            email: '',
            telp: '',
            password: '',
            role: 'peminjam'
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
                class="bg-white p-4 sm:p-5 rounded-xl border border-slate-200 shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h2 class="text-lg sm:text-xl font-bold text-slate-800">Kelola Data User</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Tambah, ubah role, atau hapus akun pengguna sistem.</p>
                </div>

                <!-- Tombol Tambah User -->
                <button
                    @click="
                openModal = true; 
                editMode = false; 
                userId = '';
                username = ''; 
                email = ''; 
                telp = ''; 
                password = ''; 
                role = 'peminjam';
"
                    class="w-full sm:w-auto justify-center px-4 py-2.5 sm:py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-semibold flex items-center space-x-2 transition shadow-sm">
                    <i class="fa-solid fa-plus"></i>
                    <span>Tambah User</span>
                </button>
            </div>

            <!-- Tabel Data User (Read) -->
            <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
                <div class="overflow-x-auto w-full">
                    <table class="w-full text-left text-sm text-slate-600 min-w-[640px]">
                        <thead
                            class="bg-slate-50 text-slate-700 border-b border-slate-200 uppercase text-[11px] font-bold tracking-wider">
                            <tr>
                                <th class="px-4 sm:px-6 py-3.5 whitespace-nowrap">User</th>
                                <th class="px-4 sm:px-6 py-3.5 whitespace-nowrap">Telp</th>
                                <th class="px-4 sm:px-6 py-3.5 whitespace-nowrap">Email</th>
                                <th class="px-4 sm:px-6 py-3.5 whitespace-nowrap">Role / Hak Akses</th>
                                <th class="px-4 sm:px-6 py-3.5 whitespace-nowrap">Tanggal Dibuat</th>
                                <th class="px-4 sm:px-6 py-3.5 text-center whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">

                            @forelse ($user as $item)
                                <!-- Row 1: Admin -->
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="px-4 sm:px-6 py-4 flex items-center space-x-3 whitespace-nowrap">
                                        @php
                                            // 1. Ambil 1 huruf pertama dari username (Ubah jadi huruf besar)
                                            $initial = strtoupper(substr($item->username ?? 'U', 0, 1));

                                            // 2. Array variasi warna Tailwind yang bagus dan matching
                                            $colors = [
                                                'bg-indigo-600 text-white',
                                                'bg-emerald-600 text-white',
                                                'bg-amber-500 text-white',
                                                'bg-rose-600 text-white',
                                                'bg-violet-600 text-white',
                                                'bg-cyan-600 text-white',
                                                'bg-teal-600 text-white',
                                                'bg-fuchsia-600 text-white',
                                            ];

                                            // 3. Tentukan warna berdasarkan ID/Username agar konsisten
                                            $colorIndex = ($item->id_user ?? ord($initial)) % count($colors);
                                            $selectedColor = $colors[$colorIndex];
                                        @endphp

                                        <!-- Element Avatar -->
                                        <div
                                            class="w-8 h-8 sm:w-9 sm:h-9 rounded-full {{ $selectedColor }} font-bold flex items-center justify-center text-xs shadow-sm uppercase shrink-0">
                                            {{ $initial }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-800 text-sm">{{ $item->username }}</p>
                                            <span class="text-[11px] text-slate-400">ID User:
                                                #USR-01{{ $item->id_user }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 sm:px-6 py-4 text-slate-600 whitespace-nowrap">{{ $item->telp ?? '-' }}
                                    </td>
                                    <td class="px-4 sm:px-6 py-4 text-slate-600 whitespace-nowrap">{{ $item->email }}</td>
                                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                        @switch($item->role)
                                            @case('admin')
                                                <span
                                                    class="px-2.5 py-1 bg-rose-50 text-rose-700 rounded-md text-xs font-semibold border border-rose-200 uppercase tracking-wider">
                                                    {{ ucfirst($item->role) }}
                                                </span>
                                            @break

                                            @case('petugas')
                                                <span
                                                    class="px-2.5 py-1 bg-emerald-50 text-emerald-700 rounded-md text-xs font-semibold border border-emerald-200 uppercase tracking-wider">
                                                    {{ ucfirst($item->role) }}
                                                </span>
                                            @break

                                            @case('peminjam')
                                                <span
                                                    class="px-2.5 py-1 bg-indigo-50 text-indigo-700 rounded-md text-xs font-semibold border border-indigo-200 uppercase tracking-wider">
                                                    {{ ucfirst($item->role) }}
                                                </span>
                                            @break

                                            @default
                                                <span
                                                    class="px-2.5 py-1 bg-slate-100 text-slate-600 rounded-md text-xs font-semibold border border-slate-200 uppercase tracking-wider">
                                                    {{ ucfirst($item->role ?? 'User') }}
                                                </span>
                                        @endswitch

                                    </td>
                                    <td class="px-4 sm:px-6 py-4 text-xs text-slate-400 whitespace-nowrap">
                                        {{ $item->created_at }}</td>
                                    <td class="px-4 sm:px-6 py-4 text-center whitespace-nowrap">
                                        <div class="flex items-center justify-center space-x-2">
                                            <!-- Tombol Edit di Tabel -->
                                            <button
                                                @click="
                                                openModal = true; 
                                                editMode = true; 
                                                userId = '{{ $item->id_user }}';
                                                username = '{{ $item->username }}'; 
                                                email = '{{ $item->email }}'; 
                                                telp = '{{ $item->telp }}'; 
                                                password = ''; 
                                                role = '{{ $item->role }}';
"
                                                class="p-2 text-amber-500 hover:bg-amber-50 rounded-lg transition">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                            <!-- Form Hapus -->
                                            <form id="delete-form-{{ $item->id_user }}"
                                                action="/admin/user/delete/{{ $item->id_user }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('POST')
                                                <button type="button"
                                                    onclick="showAlertConfirm('Hapus User?', 'Apakah kamu yakin ingin menghapus {{ $item->username }}?', function() { document.getElementById('delete-form-{{ $item->id_user }}').submit(); })"
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
                                        <td colspan="6" class="px-6 py-6 text-center text-slate-400 text-xs">
                                            Data tidak ada
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- MODAL POPUP FORM (Create & Edit User) -->
                <div x-show="openModal"
                    class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-3 sm:p-4"
                    x-cloak>
                    <div
                        class="bg-white rounded-2xl max-w-md w-full shadow-2xl overflow-hidden transform transition-all my-auto">

                        <!-- Modal Header -->
                        <div class="px-5 sm:px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                            <h3 class="font-bold text-slate-800 text-sm sm:text-base"
                                x-text="editMode ? 'Ubah Data User' : 'Tambah User Baru'"></h3>
                            <button @click="openModal = false" class="text-slate-400 hover:text-slate-600 p-1">
                                <i class="fa-solid fa-xmark text-lg"></i>
                            </button>
                        </div>

                        <!-- Modal Form (Action Otomatis Switch Tambah / Edit) -->
                        <form
                            :action="editMode ? '{{ url('/admin/user/update', '') }}/' + userId :
                                '{{ url('/admin/user/store') }}'"
                            method="POST" class="p-5 sm:p-6 space-y-4">
                            @csrf

                            <!-- Directive _method PUT hanya aktif saat editMode = true -->
                            <template x-if="editMode">
                                <input type="hidden" name="_method" value="PUT">
                            </template>

                            <!-- Username -->
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Username</label>
                                <input type="text" name="username" x-model="username" placeholder="Masukkan username..."
                                    required
                                    class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Email</label>
                                <input type="email" name="email" x-model="email" placeholder="contoh@gmail.com" required
                                    class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            </div>

                            <!-- Telp -->
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Telp</label>
                                <input type="tel" name="telp" x-model="telp" placeholder="08xxxxxxx" required
                                    maxlength="12" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 12)"
                                    class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            </div>

                            <!-- Password -->
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Password</label>
                                <input type="password" name="password" x-model="password" placeholder="••••••••"
                                    :required="!editMode"
                                    class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <p class="text-[10px] text-slate-400 mt-1" x-show="editMode">*Kosongkan password jika tidak
                                    ingin
                                    mengubahnya.</p>
                            </div>

                            <!-- Role -->
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Role / Hak Akses</label>
                                <select name="role" x-model="role"
                                    class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white">
                                    <option value="peminjam">Peminjam</option>
                                    <option value="petugas">Petugas</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>

                            <!-- Footer Modal Buttons -->
                            <div class="pt-4 flex justify-end space-x-2 border-t border-slate-100">
                                <button type="button" @click="openModal = false"
                                    class="px-4 py-2 bg-slate-100 text-slate-600 rounded-lg text-xs font-semibold hover:bg-slate-200 transition">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-xs font-semibold hover:bg-indigo-700 transition"
                                    x-text="editMode ? 'Simpan Perubahan' : 'Tambah User'">
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @endsection
