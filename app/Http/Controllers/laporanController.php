<?php

namespace App\Http\Controllers;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

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

        header('Content-Type: application/vnd.ms-excel');
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
            echo '<td>' . ($item->username ?? ($item->user->username ?? '-')) . '</td>';
            echo '<td>' . ($item->nama_alat ?? ($item->alat->nama_alat ?? '-')) . '</td>';
            echo '<td>' . $item->jumlah . ' Unit</td>';
            echo '<td>' . $item->tanggal_pinjam . '</td>';
            echo '<td>' . ($item->tanggal_kembali ?? '-') . '</td>';
            echo '<td>' . strtoupper(str_replace('_', ' ', $item->status)) . '</td>';
            echo '</tr>';
        }
        echo '</table>';
        exit();
    }

    public function cetakPdf(Request $request)
    {
        //query pada model Peminjaman sekaligus memuat relasi 'user' dan 'alat' (Eager Loading) agar query database lebih ringan
        $query = Peminjaman::with(['user', 'alat'])
            // Mengecek apakah input 'tgl_mulai' diisi oleh user; jika ada isinya, jalankan filter di dalamnya
            ->when($request->tgl_mulai, function ($q) use ($request) {
                //Memfilter data yang kolom 'tanggal_pinjam'-nya lebih besar atau sama dengan 'tgl_mulai' (hanya membandingkan tanggal, jam diabaikan)
                $q->whereDate('tanggal_pinjam', '>=', $request->tgl_mulai);
            })
            //Mengecek apakah input 'tgl_selesai' diisi oleh user; jika ada isinya, jalankan filter berikutnya
            ->when($request->tgl_selesai, function ($q) use ($request) {
                // Memfilter data yang kolom 'tanggal_pinjam'-nya lebih kecil atau sama dengan 'tgl_selesai'
                $q->whereDate('tanggal_pinjam', '<=', $request->tgl_selesai);
            })
            //Mengurutkan data hasil filter berdasarkan 'tanggal_pinjam' dari yang terbaru ke terlama (descending)
            ->orderBy('tanggal_pinjam', 'desc');

        // Mengeksekusi seluruh rangkaian query di atas dan mengambil semua baris datanya (tanpa dibatasi pagination)
        $laporan = $query->get();

        //Merender file view 'resources/views/petugas/laporan_pdf.blade.php' menjadi format PDF sambil mengirim variabel data
        $pdf = Pdf::loadView('petugas.laporan_pdf', [
            'laporan' => $laporan, // Mengirimkan hasil data peminjaman ke tampilan PDF
            'tgl_mulai' => $request->tgl_mulai, // Mengirimkan tanggal mulai untuk ditampilkan di teks periode kop laporan
            'tgl_selesai' => $request->tgl_selesai, // Mengirimkan tanggal selesai untuk ditampilkan di teks periode kop laporan
        ])
            //Mengatur ukuran kertas menjadi A4 dengan posisi mendatar (landscape) agar tabel yang kolomnya lebar tidak terpotong
            ->setPaper('a4', 'landscape');

        // 10. Menampilkan preview file PDF langsung di tab browser (bukan langsung terunduh), sehingga user bisa cek dulu sebelum print
        return $pdf->stream('Laporan-Peminjaman-Alat.pdf');
    }
}
