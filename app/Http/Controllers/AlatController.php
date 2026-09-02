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
    public function index(Request $request)
    {
        $query = Alat::with('kategori');

        // Filter Pencarian Nama Alat
        if ($request->filled('search')) {
            $query->where('nama_alat', 'like', '%' . $request->search . '%');
        }

        // Paginasi 15 data per halaman
        $alat = $query->latest('id_alat')->paginate(15)->withQueryString();

        return view('admin.alat.index', compact('alat'));
    }
    /**
     * Show the form for creating a new resource.
     */

    public function indexKatalog(Request $request)
    {
        $kategori = Kategori::all();

        $query = Alat::with('kategori');

        // Filter Kategori
        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }

        // Filter Pencarian Nama Alat
        if ($request->filled('search')) {
            $query->where('nama_alat', 'like', '%' . $request->search . '%');
        }

        // Urutkan stok > 0 di atas, stok 0 di paling bawah
        $alat = $query->orderByRaw('stok = 0 ASC')->orderBy('id_alat', 'DESC')->paginate(12)->withQueryString();

        return view('peminjam.katalog.index', compact('alat', 'kategori'));
    }

    public function create()
    {
        $kategori = Kategori::all();
        return view('admin.alat.create', compact('kategori'));
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

        return redirect('/admin/alat')->with('success', 'Alat berhasil ditambahkan');
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
    public function edit($id)
    {
        $kategori = Kategori::all();
        $alat = Alat::findOrFail($id);
        return view('admin.alat.edit', compact('alat', 'kategori'));
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

        return redirect('admin/alat')->with('success', 'Alat berhasil diubah');
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
