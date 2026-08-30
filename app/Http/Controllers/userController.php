<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
            }

            return redirect()->to('/');
        }

        // Jika Gagal
        return back()->with('error', 'Email/Username atau Password salah!')->withInput();
    }

    function indexUser()
    {
        $user = User::all();

        return view('admin.user.index', compact('user'));
    }

    function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required',
            'email' => 'required',
            'telp' => 'required',
            'password' => 'required',
            'role' => 'required',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::create($validated);
        return redirect()->back()->with('success', 'User berhasil diitambahkan');
    }

    function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required',
            'telp' => 'required',
            'password' => 'nullable|min:6',
            'role' => 'required',
            'updated_at' => now(),
        ]);

        $user = ([
            'username' => $request->username,
            'email' => $request->email,
            'telp' => $request->telp,
            'role' => $request->role,
            'updated_at' => $request->updated_at,
        ]);

        if ($request->filled('password')) {
            $user['password'] = Hash::make($request->password);
        }
        User::find($id)
        ->update($user);
        return redirect()->back()->with('success','User berhasil diubah');
    }

    function destroy(Request $request, $id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect()->back()->with('success', 'User berhasil dihapus');
    }
}
