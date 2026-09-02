<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class userController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function proseslogin(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $email = $request->email;
        $password = $request->password;

        // 2. Deteksi apakah input berupa email atau username
        $fieldType = filter_var($email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $fieldType => $email,
            'password' => $password,
        ];

        // 3. Coba Autentikasi
        if (Auth::attempt($credentials)) {
            // KODE KUNCI: Regenerasi session agar tersimpan resmi di server
            $request->session()->regenerate();

            // Direct berdasarkan role
            $role = Auth::user()->role;

            if ($role === 'admin') {
                return redirect()->route('dashboardadmin');
            } elseif ($role === 'peminjam') {
                return redirect()->route('dp');
            } elseif ($role === 'petugas') {
                return redirect()->route('dpetugas');
            }
            return redirect()->to('/');
        }

        // Jika Gagal
        return back()->with('error', 'Email/Username atau Password salah!')->withInput();
    }

    function indexUser(Request $request)
    {
        $query = User::query();

        // 1. Filter Berdasarkan Pencarian Username / Email
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('username', 'like', '%' . $request->search . '%')->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // 2. Filter Berdasarkan Role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // 3. Batasi 15 Data Per Halaman & Simpan Query Parameter saat Pindah Halaman
        $user = $query->latest('id_user')->paginate(15)->withQueryString();

        return view('admin.user.index', compact('user'));
    }

    function create()
    {
        return view('admin.user.create');
    }

    function store(Request $request)
    {
        $validated = $request->validate(
            [
                'username' => 'required',
                'email' => ['required', 'email', Rule::unique('users', 'email')],
                'telp' => 'required',
                'password' => 'nullable|min:6',
                'role' => 'required',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username.required' => 'Username wajib diisi!',
                'email.unique' => 'Email sudah terdaftar, gunakan email lain!',
                'email.required' => 'Alamat email wajib diisi!',
                'email.email' => 'Format email tidak valid!',
                'telp.required' => 'Nomor telepon wajib diisi!',
                'password.min' => 'Password minimal harus 6 karakter!',
                'role.required' => 'Role / Hak akses wajib dipilih!',
            ],
        );

        User::create($validated);
        return redirect('admin/user')->with('success', 'User berhasil diitambahkan');
    }

    function edit($id)
    {
        $user = User::findOrFail($id);

        return view('admin.user.edit', compact('user'));
    }

    function update(Request $request, $id)
    {
        $request->validate(
            [
                'username' => 'required',
                'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($id, 'id_user')],
                'telp' => 'required',
                'password' => 'nullable|min:6',
                'role' => 'required',
                'updated_at' => now(),
            ],
            [
                'username.required' => 'Username wajib diisi!',
                'email.unique' => 'Email sudah terdaftar, gunakan email lain!',
                'email.required' => 'Alamat email wajib diisi!',
                'email.email' => 'Format email tidak valid!',
                'telp.required' => 'Nomor telepon wajib diisi!',
                'password.min' => 'Password minimal harus 6 karakter!',
                'role.required' => 'Role / Hak akses wajib dipilih!',
            ],
        );

        $user = [
            'username' => $request->username,
            'email' => $request->email,
            'telp' => $request->telp,
            'role' => $request->role,
            'updated_at' => $request->updated_at,
        ];

        if ($request->filled('password')) {
            $user['password'] = Hash::make($request->password);
        }
        User::find($id)->update($user);
        return redirect('/admin/user')->with('success', 'User berhasil diubah');
    }

    function destroy(Request $request, $id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect()->back()->with('success', 'User berhasil dihapus');
    }

    function logout(Request $request)
    {
        // 1. Logout dari guard admin
        Auth::logout();

        // 2. Hapus semua data session biar bersih
        $request->session()->invalidate();

        // 3. Bikin token session baru buat keamanan (mencegah CSRF attack)
        $request->session()->regenerateToken();

        // 4. Lempar balik ke halaman login
        return redirect('/')->with('success', 'Berhasil keluar, sampai jumpa lagi!');
    }
}
