<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AlatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alat = Alat::join('kategori', 'alat.id_kategori', '=', 'kategori.id_kategori')->get();
        $kategori = Kategori::all();

        return view('admin.alat.index', compact('alat', 'kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function indexKatalog()
    {
        // Mengambil SEMUA alat, urutkan stok > 0 dulu di atas, stok 0 di paling bawah
        $alat = Alat::with('kategori')
            ->orderByRaw('stok = 0 ASC') // Stok 0 akan ditaruh di urutan paling akhir
            ->orderBy('nama_alat', 'ASC') // Urutkan nama alat A-Z (opsional agar rapi)
            ->get();

        $stok = $alat->count();

        return view('peminjam.katalog.index', compact('alat', 'stok'));
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //1.validasi
        $request->validate([
            'nama_alat' => 'required',
            'id_kategori' => 'required',
            'stok' => 'required|min:1',
            'kondisi' => 'required',
            'spesifikasi' => 'required',
            'foto' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        // 2. Proses Upload Foto
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');

            // Buat nama file yang unik berdasarkan timestamp agar tidak saling menimpa
            $namaFoto = time() . '_' . $file->getClientOriginalName();

            // Simpan file ke dalam folder 'public/uploads/alat'
            $file->move(public_path('uploads/alat'), $namaFoto);
        }

        // 3. Simpan ke Database
        Alat::create([
            'nama_alat' => $request->nama_alat,
            'id_kategori' => $request->id_kategori,
            'stok' => $request->stok,
            'kondisi' => $request->kondisi,
            'spesifikasi' => $request->spesifikasi,
            'foto' => $namaFoto, // Simpan hanya nama filenya saja
        ]);

        return redirect()->back()->with('success', 'Alat berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Alat $alat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Alat $alat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // 1. Validasi
        $request->validate([
            'nama_alat' => 'required',
            'id_kategori' => 'required',
            'stok' => 'required|integer|min:0', // Pakai integer|min:0 agar stok 0 diizinkan
            'kondisi' => 'required',
            'spesifikasi' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Pakai nullable
        ]);

        // 2. Cari data alat
        $alat = Alat::findOrFail($id);

        $namaFoto = $alat->foto; // Default pakai foto lama

        // 3. Jika foto baru diunggah, hapus foto lama dan simpan yang baru
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada dan filenya eksis
            if ($alat->foto) {
                $fotoLama = public_path('uploads/alat/' . $alat->foto);
                if (File::exists($fotoLama)) {
                    File::delete($fotoLama);
                }
            }

            // Upload foto baru
            $file = $request->file('foto');
            $namaFoto = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/alat'), $namaFoto);
        }

        // 4. Update data ke database
        $alat->update([
            'nama_alat' => $request->nama_alat,
            'id_kategori' => $request->id_kategori,
            'stok' => $request->stok,
            'kondisi' => $request->kondisi,
            'spesifikasi' => $request->spesifikasi,
            'foto' => $namaFoto,
        ]);

        return redirect()->back()->with('success', 'Alat berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alat $alat, $id)
    {
        Alat::find($id)->delete();

        return redirect()->back()->with('success', 'Alat berhasil dihapus');
    }
}
