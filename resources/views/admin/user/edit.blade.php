@extends('Layouts.app')

@section('content')
    <div class="max-w-xl mx-auto space-y-6">
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-800">Ubah Data User</h2>
                <p class="text-xs text-slate-500 mt-0.5">Perbarui rincian akun untuk {{ $user->username }}.</p>
            </div>
            <a href="{{ url('/admin/user') }}"
                class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg text-xs font-semibold transition">
                <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
            <form action="{{ url('/admin/user/update/' . $user->id_user) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <!-- Username -->
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Username</label>
                    <input type="text" name="username" value="{{ old('username', $user->username) }}"
                        class="w-full px-3 py-2 border @error('username') border-rose-500 @else border-slate-200 @enderror rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('username')
                        <p class="text-[11px] text-rose-500 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                        class="w-full px-3 py-2 border @error('email') border-rose-500 @else border-slate-200 @enderror rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('email')
                        <p class="text-[11px] text-rose-500 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Telp -->
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Telp</label>
                    <input type="tel" name="telp" value="{{ old('telp', $user->telp) }}" maxlength="12"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 12)"
                        class="w-full px-3 py-2 border @error('telp') border-rose-500 @else border-slate-200 @enderror rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @error('telp')
                        <p class="text-[11px] text-rose-500 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Password</label>
                    <input type="password" name="password" placeholder="••••••••"
                        class="w-full px-3 py-2 border @error('password') border-rose-500 @else border-slate-200 @enderror rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <p class="text-[10px] text-slate-400 mt-1">*Kosongkan password jika tidak ingin mengubahnya.</p>
                    @error('password')
                        <p class="text-[11px] text-rose-500 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role / Hak Akses -->
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Role / Hak Akses</label>
                    <select name="role"
                        class="w-full px-3 py-2 border @error('role') border-rose-500 @else border-slate-200 @enderror rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white">
                        <option value="">-- Pilih Role --</option>
                        <option value="peminjam" @selected(old('role', $user->role) == 'peminjam')>Peminjam</option>
                        <option value="petugas" @selected(old('role', $user->role) == 'petugas')>Petugas</option>
                        <option value="admin" @selected(old('role', $user->role) == 'admin')>Admin</option>
                    </select>
                    @error('role')
                        <p class="text-[11px] text-rose-500 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Footer Buttons -->
                <div class="pt-4 flex justify-end space-x-2 border-t border-slate-100">
                    <a href="{{ url('/admin/user') }}"
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
