<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\HistoriPinjaman;
use App\Models\LogAktivitas;
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
    public function indexAdmin()
    {
        return view('admin.katalog.index');
    }

    function indexPersetujuan()
    {
        $persetujuan = DB::table('peminjaman')
            ->join('users', 'peminjaman.id_user', '=', 'users.id_user')
            ->join('alat', 'peminjaman.id_alat', '=', 'alat.id_alat')
            ->select('peminjaman.id_peminjaman', 'peminjaman.jumlah','peminjaman.jaminan' , 'users.username', 'alat.nama_alat', 'peminjaman.tanggal_pinjam', 'peminjaman.tanggal_kembali', 'peminjaman.status')
            ->whereIn('status', ['ajukan peminjaman', 'dipinjam', 'ajukan kembali'])
            ->orderBy('peminjaman.tanggal_kembali', 'asc')
            ->get();
        return view('petugas.persetujuan.index', compact('persetujuan'));
    }

    function indexDaftarPeminjam()
    {
        $riwayat = DB::table('peminjaman')
            ->join('users', 'peminjaman.id_user', '=', 'users.id_user')
            ->join('alat', 'peminjaman.id_alat', '=', 'alat.id_alat')
            ->select('peminjaman.id_peminjaman', 'peminjaman.jumlah', 'users.username', 'alat.nama_alat', 'peminjaman.tanggal_pinjam', 'peminjaman.tanggal_kembali', 'peminjaman.status')
            ->whereIn('status', ['ditolak', 'dikembalikan'])
            ->orderBy('peminjaman.tanggal_kembali', 'asc')
            ->get();
        return view('petugas.daftarPeminjam', compact('riwayat'));
    }

    public function laporan(Request $request)
    {
        // 1. Inisialisasi query Eloquent dari model Peminjaman
        // Menggunakan Eager Loading 'with(['user', 'alat'])' agar query lebih efisien (mencegah N+1 Problem)
        $query = Peminjaman::with(['user', 'alat']);

        // 2. LOGIKA FILTER TANGGAL

        // Opsi A: Jika KEDUA tanggal (tgl_mulai & tgl_selesai) diisi oleh user
        if ($request->filled('tgl_mulai') && $request->filled('tgl_selesai')) {
            // Menggunakan whereBetween untuk mengambil data di dalam rentang tanggal tersebut
            // Menambahkan '00:00:00' dan '23:59:59' agar mencakup seluruh jam dari hari awal sampai hari akhir
            $query->whereBetween('tanggal_pinjam', [$request->tgl_mulai . ' 00:00:00', $request->tgl_selesai . ' 23:59:59']);

            // Opsi B: Jika HANYA 'tgl_mulai' yang diisi
        } elseif ($request->filled('tgl_mulai')) {
            // Ambil data yang tanggal pinjamnya dari tanggal tersebut ke depan (>=)
            $query->whereDate('tanggal_pinjam', '>=', $request->tgl_mulai);

            // Opsi C: Jika HANYA 'tgl_selesai' yang diisi
        } elseif ($request->filled('tgl_selesai')) {
            // Ambil data yang tanggal pinjamnya dari tanggal tersebut ke belakang (<=)
            $query->whereDate('tanggal_pinjam', '<=', $request->tgl_selesai);
        }

        // 3. Eksekusi query dengan urutan data terbaru berdasarkan 'id_peminjaman'
        $laporan = $query->latest('id_peminjaman')->get();

        // 4. Kirimkan data $laporan ke tampilan Blade
        return view('petugas.laporan.index', compact('laporan'));
    }
    public function riwayat()
    {
        return view('peminjam.pinjaman');
    }
    public function riwayatAdmin()
    {
        return view('admin.pinjaman');
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
    public function createAdmin($id)
    {
        $alat = Alat::join('kategori', 'alat.id_kategori', '=', 'kategori.id_kategori')
            ->select('alat.id_alat', 'alat.nama_alat', 'alat.foto', 'alat.spesifikasi', 'alat.stok', 'alat.kondisi', 'kategori.nama_kategori')
            ->where('alat.id_alat', $id) // Where dipanggil DULUAN untuk memfilter ID
            ->first(); // Executed paling akhir untuk ambil 1 data

        return view('admin.pinjam.create', compact('alat'));
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
            'jaminan' => 'required',
            'tanggal_pinjam' => 'required',
            'tanggal_kembali' => 'required',
        ]);

        // if ($alat->stok < $request->jumlah) {
        //     return redirect()->back()->with('error', 'Stok alat tidak mencukupi.');
        // }

        // $alat->update([
        //     'stok' => $alat->stok - $request->jumlah,
        // ]);

        Peminjaman::create([
            'id_alat' => $request->id_alat,
            'id_user' => $id_user,
            'jumlah' => $request->jumlah,
            'jaminan' => $request->jaminan,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
        ]);
        $user = Auth::user();

        // 2. Catat log aktivitas (sekarang $user sudah terdefinisi)
        LogAktivitas::catat('Mengajukan peminjaman', $user->username . ', Mengajukan Peminjaman:'. ' ALT-0'.$request->id_alat);
        

        return redirect('/peminjam/katalog')->with('success', 'Pengajuan berhasil ditambahkan');
    }
    public function storeAdmin(Request $request)
    {
        $id_user = Auth::id();

        $request->validate([
            'id_alat' => 'required',
            'jumlah' => 'required',
            'tanggal_pinjam' => 'required',
            'tanggal_kembali' => 'required',
        ]);


        Peminjaman::create([
            'id_alat' => $request->id_alat,
            'id_user' => $id_user,
            'jumlah' => $request->jumlah,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
        ]);
        $user = Auth::user();

        // 2. Catat log aktivitas (sekarang $user sudah terdefinisi)
        LogAktivitas::catat('Mengajukan peminjaman', $user->username . ', Mengajukan Peminjaman:'.' ALT-0'. $request->id_alat);

        return redirect('/admin/katalog')->with('success', 'Pengajuan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function pinjamanSaya($id)
    {
        $pinjamanSaya = DB::table('peminjaman')->join('alat', 'peminjaman.id_alat', '=', 'alat.id_alat')->select('alat.nama_alat', 'alat.foto', 'peminjaman.id_peminjaman', 'peminjaman.status', 'peminjaman.jumlah', 'peminjaman.tanggal_pinjam', 'peminjaman.tanggal_kembali')->whereNotIn('peminjaman.status', ['dikembalikan', 'ditolak'])->where('id_user', $id)->get();

        return view('peminjam.pinjaman', compact('pinjamanSaya'));
    }
    public function pinjamanSayaAdmin($id)
    {
        $pinjamanSaya = DB::table('peminjaman')->join('alat', 'peminjaman.id_alat', '=', 'alat.id_alat')->select('alat.nama_alat', 'alat.foto', 'peminjaman.id_peminjaman', 'peminjaman.status', 'peminjaman.jumlah', 'peminjaman.tanggal_pinjam', 'peminjaman.tanggal_kembali')->whereNotIn('peminjaman.status', ['dikembalikan', 'ditolak'])->where('id_user', $id)->get();

        return view('admin.pinjaman', compact('pinjamanSaya'));
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
    public function updatePersetujuan(Request $request, $id)
    {
        // 1. Ambil data peminjaman
        $peminjaman = Peminjaman::findOrFail($id);

        $statusLama = $peminjaman->status;
        $statusBaru = $request->status;

        // 2. Ambil data alat terkait
        $alat = Alat::findOrFail($peminjaman->id_alat);

        // 3. Logika Kelola Stok

        // JIKA DISETUJUI PINJAM (ajukan peminjaman -> dipinjam)
        if ($statusBaru == 'dipinjam' && $statusLama == 'ajukan peminjaman') {
            // Cek kecukupan stok sebelum dikurangi

            if ($alat->stok < $peminjaman->jumlah) {
                $user = Auth::user();

                // 2. Catat log aktivitas (sekarang $user sudah terdefinisi)
                LogAktivitas::catat('Menolak Peminjaman', $user->username . ', Menolak peminjaman karena stok habis'. $id);
                return redirect()->back()->with('error', 'Stok alat tidak mencukupi untuk disetujui!');
            }

            $user = Auth::user();

            // 2. Catat log aktivitas (sekarang $user sudah terdefinisi)
            LogAktivitas::catat('Menyetujui Peminjaman', $user->username . ', Menyetujui peminjaman:'. $id);

            // KURANGI STOK
            $alat->decrement('stok', $peminjaman->jumlah);

            // JIKA DISETUJUI PENGEMBALIAN (ajukan kembali / ajukan pengembalian -> dikembalikan)
        } elseif ($statusBaru == 'dikembalikan' && in_array($statusLama, ['ajukan kembali', 'ajukan pengembalian'])) {
            // TAMBAH KEMBALI STOK
            $alat->increment('stok', $peminjaman->jumlah);
            //tambah data di tabel histori
            HistoriPinjaman::create([
                'id_peminjaman' => $peminjaman->id_peminjaman,
                'status_akhir' => $statusBaru,
                'creted_at' => now(),
            ]);

            $user = Auth::user();

            // 2. Catat log aktivitas (sekarang $user sudah terdefinisi)
            LogAktivitas::catat('Menyetujui pengembalian', $user->username . ', Menyetujui pengembalian:'. $id);
        }else{
               $user = Auth::user();

            // 2. Catat log aktivitas (sekarang $user sudah terdefinisi)
            LogAktivitas::catat('Menolak peminjaman', $user->username . ', Menolak peminjaman:'. $id);

             HistoriPinjaman::create([
                'id_peminjaman' => $peminjaman->id_peminjaman,
                'status_akhir' => 'ditolak',
                'creted_at' => now(),
            ]);
        }

        // 4. Update status peminjaman di database
        $peminjaman->update([
            'status' => $statusBaru,
        ]);

        return redirect()->back()->with('success', 'Status peminjaman dan stok berhasil diperbarui!');
    }

    function updatePeminjaman(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update([
            'status' => $request->status,
        ]);

        $user = Auth::user();

        // 2. Catat log aktivitas (sekarang $user sudah terdefinisi)
        LogAktivitas::catat('Mengajukan pengmbalian', $user->username . ', Mengajukan pengembalian:'. $id);

        return redirect()->back()->with('success', 'Berhasil mengajukan pengembalian');
    }
    function updatePeminjamanAdmin(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update([
            'status' => $request->status,
        ]);

        $user = Auth::user();

        // 2. Catat log aktivitas (sekarang $user sudah terdefinisi)
        LogAktivitas::catat('Mengajukan pengmbalian', $user->username . ', Mengajukan pengembalian:'. $id);

        return redirect()->back()->with('success', 'Berhasil mengajukan pengembalian');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Peminjaman $peminjaman)
    {
        //
    }
}
