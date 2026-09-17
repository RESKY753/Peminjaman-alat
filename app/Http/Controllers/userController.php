<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\HistoriPinjaman;
use App\Models\Kategori;
use App\Models\LogAktivitas;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException; // WAJIB DI-IMPORT UNTUK TANGKAP ERROR RESTRICT

class userController extends Controller
{
    function indexDashboard()
    {
        $totalAlat = Alat::count();
        $totalUser = User::count();
        $totalKategori = Kategori::count();
        $totalLog = LogAktivitas::count();

        // Data tambahan jika diperlukan
        $myPinjamanCount = Peminjaman::where('id_user', Auth::user()->id_user)
            ->whereNotIn('status', ['dikembalikan', 'ditolak'])
            ->count();
        $katalogCount = Alat::where('stok', '>', 0)->count();

        $pendingCount = Peminjaman::whereNotIn('status', ['dikembalikan', 'dipinjam', 'ditolak'])->count();
        $activePinjamCount = Peminjaman::where('status', ['dipinjam'])->count();
        $totalPeminjam = Peminjaman::whereNotIn('status', ['ditolak', 'dikembalikan'])->count();

        return view('Layouts.dashboard', compact('totalAlat', 'totalUser', 'totalKategori', 'totalLog', 'myPinjamanCount', 'katalogCount', 'pendingCount','activePinjamCount', 'totalPeminjam'));
        return view('Layouts.dashboard');
    }
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
            $request->session()->regenerate();
            $user = Auth::user();

            LogAktivitas::catat('Login', 'User ' . $user->username . ' berhasil login' . $user->id_user);

            // cek sudah ada sesion apa belum
            if (Auth::check()) {
                return redirect()->route('dashboard');
            }

            //jika tidak ada session kode ini akan dijalankan
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

                $user = Auth::user();

                // 2. Catat log aktivitas (sekarang $user sudah terdefinisi)
                LogAktivitas::catat('Mencari nama pengguna', 'User ' . $user->username . ' berhasil mencari nama pengguna');
            });
        }

        // 2. Filter Berdasarkan Role
        if ($request->filled('role')) {
            $query->where('role', $request->role);

            $user = Auth::user();

            // 2. Catat log aktivitas (sekarang $user sudah terdefinisi)
            LogAktivitas::catat('Mencari pengguna berdasarkan role', 'User ' . $user->username . ' berhasil mencari role');
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
                'password' => 'nullable|min:6|required',
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
                'password.required' => 'Password harus diisi!',
                'role.required' => 'Role / Hak akses wajib dipilih!',
            ],
        );

        User::create($validated);

        $user = Auth::user();

        // 2. Catat log aktivitas (sekarang $user sudah terdefinisi)
        LogAktivitas::catat('Menambahkan user', 'User ' . $user->username . ' Menambahkan User: ' . $request->username);

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

        $user = Auth::user();

        // 2. Catat log aktivitas (sekarang $user sudah terdefinisi)
        LogAktivitas::catat('Mengubah data user', 'User ' . $user->username . ' Mengubah data user:' . $id);

        return redirect('/admin/user')->with('success', 'User berhasil diubah');
    }

    public function destroy($id)
    {
        try {
            // 1. Cari user yang mau dihapus & simpan namanya sebelum hilang
            $targetUser = User::findOrFail($id);
            $namaTarget = $targetUser->username;

            // 2. Eksekusi hapus user
            $targetUser->delete();

            // 3. Ambil data admin yang sedang login
            $admin = Auth::user();

            // 4. Catat ke log aktivitas (Hanya jalan kalau hapus BERHASIL)
            LogAktivitas::catat('Menghapus User', 'Admin ' . $admin->username . ' menghapus user ' . $id);

            return redirect()->back()->with('success', 'User berhasil dihapus.');
        } catch (QueryException $e) {
            // 5. TANGKAP ERROR RESTRICT DI SINI (SQLSTATE 23000)
            if ($e->getCode() == '23000') {
                return redirect()->back()->with('error', 'User tidak bisa dihapus karena masih memiliki riwayat transaksi atau log aktivitas!');
            }

            // Kalau ada error database lainnya
            return redirect()->back()->with('error', 'Gagal menghapus user dari database.');
        }
    }

    function logout(Request $request)
    {
        $user = Auth::user();

        // 2. Catat log aktivitas (sekarang $user sudah terdefinisi)
        LogAktivitas::catat('Logout', $user->username . ' logout' . $user->id_user);
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
