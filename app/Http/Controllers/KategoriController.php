<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\LogAktivitas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategori = Kategori::all();
        return view('admin.kategori.index', compact('kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $kategori = $request->validate(
            [
                'nama_kategori' => 'required',
                'keterangan' => 'required',
            ],
            [
                'nama_keterangan.required' => 'nama wajib diisi!',
                'keterangan.required' => 'keterangan wajib diisi!',
            ],
        );

        Kategori::create($kategori);

        $user = Auth::user();

        // 2. Catat log aktivitas (sekarang $user sudah terdefinisi)
        LogAktivitas::catat('Menambahkan kategori', $user->username . ', Menambahkan kategori:'. $request->nama_kategori);
        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kategori $kategori)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kategori $kategori)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $kategori = $request->validate([
            'nama_kategori' => 'required',
            'keterangan' => 'required',
        ]);

        Kategori::find($id)->update($kategori);

        $user = Auth::user();

        // 2. Catat log aktivitas (sekarang $user sudah terdefinisi)
        LogAktivitas::catat('Mengubah kategori', $user->username . ', Mengubah kategori:'. ' KTG-0'.$id);

        return redirect()->back()->with('success', 'Kategori berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $kategori, $id)
    {
        Kategori::find($id)->delete();

        $user = Auth::user();

        // 2. Catat log aktivitas (sekarang $user sudah terdefinisi)
        LogAktivitas::catat('Menghapus kategori', $user->username . ', Menghapus kategori:'. ' KTG-0'.$id);

        return redirect()->back()->with('success', 'Kategori berhasil dihapus');
    }
}
