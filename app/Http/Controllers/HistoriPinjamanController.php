<?php

namespace App\Http\Controllers;

use App\Models\HistoriPinjaman;
use Illuminate\Http\Request;

class HistoriPinjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $histori = HistoriPinjaman::with(['peminjaman.alat'])
            ->whereHas('peminjaman', function ($query) use ($id) {
                $query->where('id_user', $id);
            })
            ->whereIn('status_akhir', ['dikembalikan', 'ditolak'])
            ->orderBy('creted_at','desc')
            ->get();
        return view('peminjam.histori.index', compact('histori'));
    }
    public function indexAdmin($id)
    {
        $histori = HistoriPinjaman::with(['peminjaman.alat'])
            ->whereHas('peminjaman', function ($query) use ($id) {
                $query->where('id_user', $id);
            })
            ->whereIn('status_akhir', ['dikembalikan', 'ditolak'])
            ->orderBy('creted_at','desc')
            ->get();
        return view('admin.histori.index', compact('histori'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(HistoriPinjaman $hitoriPinjaman)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HistoriPinjaman $hitoriPinjaman)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HistoriPinjaman $hitoriPinjaman)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HistoriPinjaman $hitoriPinjaman)
    {
        //
    }
}
