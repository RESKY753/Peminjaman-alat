<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('peminjam.katalog.index');
    }
    public function riwayat()
    {
        return view('peminjam.pinjaman');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $alat = Alat::find($id)->join('kategori', 'alat.id_kategori', '=', 'kategori.id_kategori')->select('alat.id_alat', 'alat.nama_alat', 'alat.foto', 'alat.spesifikasi', 'alat.stok', 'alat.kondisi', 'kategori.nama_kategori')->first();
        return view('peminjam.pinjam.create', compact('alat'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $id_user = Auth::id();
        $request->validate([
            'id_alat' => 'required',
            'jumlah' => 'required',
            'tanggal_pinjam' => now(),
            'tanggal_kembali' => now(),
        ]);

        Alat::create([$request->id_alat, $id_user, $request->jumlah ,$request->tanggal_pinjam, $request->tanggal_kembali]);
        return redirect()->url('/peminjam/katalog')->with('success','Pengajuan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function pinjamanSaya($id)
    {
        $pinjaman = Peminjaman::find($id)->join('peminjaman.id_alat', '=', 'alat.id_alat')->select('alat.nama_alat', 'peminjaman.status', 'peminjaman.tanggal_pinjam', 'peminjaman.tanggal_kembali')->get();

        return view('peminjam.pinjaman', compact('pinjaman'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Peminjaman $peminjaman)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Peminjaman $peminjaman)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Peminjaman $peminjaman)
    {
        //
    }
}
