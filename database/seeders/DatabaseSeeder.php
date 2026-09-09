<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Matikan pengecekan foreign key sementara agar truncate aman
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Kosongkan tabel terlebih dahulu
        DB::table('histori_pinjaman')->truncate();
        DB::table('peminjaman')->truncate();
        DB::table('log_aktivitas')->truncate();
        DB::table('alat')->truncate();
        DB::table('kategori')->truncate();
        DB::table('users')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // ==========================================
        // 1. SEEDER USERS (20 Record Data Real)
        // ==========================================
        $namaLengkap = ['Ahmad Fauzi', 'Siti Rahmawati', 'Rizky Pratama', 'Dewi Lestari', 'Muhammad Fajar', 'Nurul Hidayah', 'Dimas Anggara', 'Intan Permata', 'Reza Pahlevi', 'Fitriani', 'Budi Santoso', 'Siti Aminah', 'Eko Prasetyo', 'Sri Wahyuni', 'Joko Widodo', 'Mega Pertiwi', 'Yoga Pratama', 'Putri Indah', 'Fauzan Al-Ghifari', 'Desi Ratnasari'];

        $roles = ['admin', 'petugas', 'peminjam'];
        $usersData = [];

        // Akun Utama untuk Testing
        $usersData[] = [
            'username' => 'Admin Sistem',
            'telp' => '81234567890',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        $usersData[] = [
            'username' => 'Petugas Sarpras',
            'telp' => '81234567891',
            'email' => 'petugas@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'petugas',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        $usersData[] = [
            'username' => 'Resky Aditya',
            'telp' => '81234567892',
            'email' => 'peminjam@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'peminjam',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        // Sisa user data real (total 20)
        for ($i = 3; $i < 20; $i++) {
            $usersData[] = [
                'username' => $namaLengkap[$i],
                'telp' => '81987654' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'email' => strtolower(str_replace(' ', '', $namaLengkap[$i])) . '@gmail.com',
                'password' => Hash::make('password'),
                'role' => $roles[array_rand($roles)],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }
        DB::table('users')->insert($usersData);

        // ==========================================
        // 2. SEEDER KATEGORI (Tepat 10 Record)
        // ==========================================
        $kategoriList = [['nama_kategori' => 'Elektronik', 'ket' => 'Peralatan berbasis elektronik dan kelistrikan'], ['nama_kategori' => 'Jaringan & Komputer', 'ket' => 'Perangkat komputer, laptop, router, dan switch'], ['nama_kategori' => 'Audio Visual', 'ket' => 'Kamera, proyektor, speaker, dan mic'], ['nama_kategori' => 'Perkakas Pertukangan', 'ket' => 'Alat-alat bengkel dan perbaikan fisik'], ['nama_kategori' => 'Alat Ukur', 'ket' => 'Multimeter, jangka sorong, dan alat ukur presisi'], ['nama_kategori' => 'Multimedia Studio', 'ket' => 'Lighting, tripod, dan background foto'], ['nama_kategori' => 'Perlengkapan Olahraga', 'ket' => 'Bola, net, dan perangkat penunjang olahraga'], ['nama_kategori' => 'Peralatan Laboratorium', 'ket' => 'Tabung reaksi, mikroskop, dan alat lab kimia'], ['nama_kategori' => 'Perabot & Furnitur', 'ket' => 'Kursi portabel, meja lipat, dan stand banner'], ['nama_kategori' => 'Keamanan & K3', 'ket' => 'Helm safety, kotak P3K, dan alat pemadam']];

        $kategoriData = [];
        foreach ($kategoriList as $index => $kat) {
            // Kategori ke-10 (index 9) diset non-aktif dengan timestamp, sisanya aktif (null)
            $statusNonaktif = $index === 9 ? Carbon::now() : null;

            $kategoriData[] = [
                'nama_kategori' => $kat['nama_kategori'],
                'keterangan' => $kat['ket'],
                'status_kategori' => $statusNonaktif,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }
        DB::table('kategori')->insert($kategoriData);

        // ==========================================
        // 3. SEEDER ALAT (20 Record Data Real)
        // ==========================================
        $namaAlatReal = ['Laptop Asus ZenBook 14', 'Proyektor Epson EB-S400', 'Multimeter Digital Fluke', 'Kamera DSLR Canon EOS 3000D', 'Bor Listrik Makita', 'Set Obeng Presisi Tekiro', 'Router TP-Link Archer C6', 'Speaker Portable Wireless JBL', 'Mesin Gerinda Tangan Bosch', 'Tripod Kamera Takara', 'Tang Ampere Sanwa', 'Kabel LAN UTP Cat6 (Roll)', 'Toolkit Jaringan Fiber Optic', 'Soundcard Focusrite Scarlett', 'Mikroskop Siswa Binokuler', 'Kotak P3K Lengkap Standar', 'Helm Safety Proyek', 'Solder Listrik Hako', 'Printer Epson L3210', 'Stabilizer Listrik Matsunaga'];

        $spesifikasiReal = ['Core i5 Gen 11, RAM 8GB, SSD 512GB', '3300 Lumens, SVGA Resolution, HDMI/VGA', 'True RMS Digital Multimeter Auto Range', '18 Megapixel, Lensa 18-55mm DC III', 'Daya 450W, Kecepatan 11000 RPM', 'Isi 32 Pcs Mata Obeng Baja Vanadium', 'Dual Band AC1200 Gigabit Wireless Router', 'Bluetooth, USB, Mic Input, Baterai Awet', 'Diameter batu gerinda 4 inch, 570 Watt', 'Tinggi maksimal 1.4 Meter, Beban max 3kg', 'Mengukur arus AC/DC hingga 600A', 'Panjang 300 Meter warna biru high quality', 'Lengkap dengan Cleaver, Stripper, dan Optical Power Meter', 'USB Audio Interface 2-In/2-Out', 'Perbesaran hingga 1000x pencahayaan LED', 'Isi lengkap dengan obat merah, kasa, plester, dan antiseptik', 'Bahan plastik HDPE tahan benturan', 'Temperatur dapat diatur 200-450 derajat celcius', 'Printer All-in-One Print, Scan, Copy sistem tank tinta', 'Kapasitas 1000VA Automatic Voltage Regulator'];

        $kondisiAlat = ['baru', 'rusak_ringan', 'rusak_berat'];
        $alatData = [];

        for ($i = 0; $i < 20; $i++) {
            // Alat ke-20 kita buat nonaktif/maintenance dengan timestamp, sisanya aktif (null)
            $statusAlatNonaktif = $i === 19 ? Carbon::now() : null;

            $alatData[] = [
                'id_kategori' => rand(1, 10),
                'nama_alat' => $namaAlatReal[$i],
                'foto' => 'default.png',
                'spesifikasi' => $spesifikasiReal[$i],
                'kondisi' => $kondisiAlat[array_rand($kondisiAlat)],
                'stok' => rand(3, 15),
                'status_alat' => $statusAlatNonaktif, // Berisi null (tersedia) atau timestamp (nonaktif)
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }
        DB::table('alat')->insert($alatData); // ==========================================
        // 4. SEEDER PEMINJAMAN (20 Record)
        // ==========================================
        $statusPeminjaman = ['ajukan peminjaman', 'dipinjam', 'ajukan kembali', 'dikembalikan', 'ditolak'];
        $jaminanList = ['tidak ada jaminan', 'KTP', 'SIM'];
        $peminjamanData = [];

        for ($i = 1; $i <= 20; $i++) {
            $peminjamanData[] = [
                'id_user' => rand(1, 20),
                'id_alat' => rand(1, 20),
                'status' => $statusPeminjaman[array_rand($statusPeminjaman)],
                'jaminan' => $jaminanList[array_rand($jaminanList)],
                'jumlah' => rand(1, 2),
                'tanggal_pinjam' => Carbon::now()->subDays(rand(1, 7)),
                'tanggal_kembali' => Carbon::now()->addDays(rand(1, 4)),
            ];
        }
        DB::table('peminjaman')->insert($peminjamanData);

        // ==========================================
        // 5. SEEDER LOG AKTIVITAS (20 Record Data Real)
        // ==========================================
        $aktivitasList = ['Login ke Sistem', 'Menambahkan Data Alat Baru', 'Mengajukan Permohonan Peminjaman Alat', 'Menyetujui Status Peminjaman', 'Memperbarui Profil Pengguna'];

        $keteranganList = ['Pengguna berhasil masuk ke dashboard aplikasi.', 'Petugas mencatatkan perangkat baru ke dalam katalog inventaris.', 'Peminjam membuat tiket pengajuan peminjaman barang lab/sarpras.', 'Admin/Petugas melakukan verifikasi dan menyetujui peminjaman.', 'Data informasi kontak dan identitas akun berhasil diperbarui.'];

        $logData = [];
        for ($i = 1; $i <= 20; $i++) {
            $randIndex = array_rand($aktivitasList);
            $logData[] = [
                'id_user' => rand(1, 20),
                'aktifitas' => $aktivitasList[$randIndex],
                'keterangan' => $keteranganList[$randIndex],
                'created_at' => Carbon::now()->subHours(rand(1, 24)),
                'updated_at' => Carbon::now(),
            ];
        }
        DB::table('log_aktivitas')->insert($logData);

        // Histori pinjaman dikosongkan agar terisi otomatis saat pengembalian barang via aplikasi.
    }
}
