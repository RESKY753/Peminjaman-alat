<?php

namespace App\Http\Controllers;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    // Tampilkan laporan dengan Pagination 10 data
    public function index(Request $request)
    {
        $query = Peminjaman::with(['user', 'alat']);

        // Filter berdasarkan tanggal jika ada
        if ($request->filled('tgl_mulai') && $request->filled('tgl_selesai')) {
            $query->whereBetween('tanggal_pinjam', [$request->tgl_mulai, $request->tgl_selesai]);
        }

        // Gunakan pagination 10 data per halaman
        $laporan = $query->latest('id_peminjaman')->paginate(10)->withQueryString();

        return view('petugas.laporan.index', compact('laporan'));
    }

    // Fungsi untuk Download ke Excel (Tanpa lib ribet, format tabel HTML)
    public function exportExcel(Request $request)
    {
        $query = Peminjaman::with(['user', 'alat']);

        if ($request->filled('tgl_mulai') && $request->filled('tgl_selesai')) {
            $query->whereBetween('tanggal_pinjam', [$request->tgl_mulai, $request->tgl_selesai]);
        }

        $laporan = $query->latest('id_peminjaman')->get(); // Ambil semua data sesuai filter untuk excel

        $filename = 'Laporan-Peminjaman-' . date('Y-m-d') . '.xls';

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        
        // Render tabel sederhana untuk file excel
        echo '<table border="1">';
        echo '<tr>
                <th>No</th>
                <th>Nama Peminjam</th>
                <th>Nama Barang / Alat</th>
                <th>Jumlah</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
              </tr>';
        
        foreach ($laporan as $index => $item) {
            echo '<tr>';
            echo '<td>' . ($index + 1) . '</td>';
            echo '<td>' . ($item->username ?? $item->user->username ?? '-') . '</td>';
            echo '<td>' . ($item->nama_alat ?? $item->alat->nama_alat ?? '-') . '</td>';
            echo '<td>' . $item->jumlah . ' Unit</td>';
            echo '<td>' . $item->tanggal_pinjam . '</td>';
            echo '<td>' . ($item->tanggal_kembali ?? '-') . '</td>';
            echo '<td>' . strtoupper(str_replace('_', ' ', $item->status)) . '</td>';
            echo '</tr>';
        }
        echo '</table>';
        exit;
    }
}