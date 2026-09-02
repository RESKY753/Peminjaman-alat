<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\table;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('peminjam.katalog.index');
    }

    function indexPersetujuan(){
        return view('petugas.persetujuan.index');
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
        $alat = Alat::join('kategori', 'alat.id_kategori', '=', 'kategori.id_kategori')
            ->select('alat.id_alat', 'alat.nama_alat', 'alat.foto', 'alat.spesifikasi', 'alat.stok', 'alat.kondisi', 'kategori.nama_kategori')
            ->where('alat.id_alat', $id) // Where dipanggil DULUAN untuk memfilter ID
            ->first(); // Executed paling akhir untuk ambil 1 data

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
            'tanggal_pinjam' => 'required',
            'tanggal_kembali' => 'required',
        ]);

        $alat = Alat::findOrFail($request->id_alat);

        if ($alat->stok < $request->jumlah) {
            return redirect()->back()->with('error', 'Stok alat tidak mencukupi.');
        }

        $alat->update([
            'stok' => $alat->stok - $request->jumlah,
        ]);

        Peminjaman::create([
            'id_alat' => $request->id_alat,
            'id_user' => $id_user,
            'jumlah' => $request->jumlah,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
        ]);

        return redirect('/peminjam/katalog')->with('success', 'Pengajuan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function pinjamanSaya($id)
    {
        $pinjamanSaya = DB::table('peminjaman')->join('alat', 'peminjaman.id_alat', '=', 'alat.id_alat')->select('alat.nama_alat', 'alat.foto', 'peminjaman.id_peminjaman', 'peminjaman.status', 'peminjaman.jumlah', 'peminjaman.tanggal_pinjam', 'peminjaman.tanggal_kembali')->where('id_user', $id)->get();

        return view('peminjam.pinjaman', compact('pinjamanSaya'));
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
