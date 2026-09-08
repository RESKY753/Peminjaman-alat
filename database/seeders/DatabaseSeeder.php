<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // ==========================================
        // 1. SEEDER TABEL KATEGORI (Induk Pertama)
        // ==========================================
        $kategoriList = ['Elektronik', 'Kamera & Audio', 'Peralatan Olahraga', 'Fasilitas Kelas', 'Peralatan Bengkel'];
        $kategoriIds = [];

        foreach ($kategoriList as $namaKategori) {
            $kategoriIds[] = DB::table('kategori')->insertGetId([
                'nama_kategori' => $namaKategori,
                'keterangan' => 'Kategori untuk ' . $namaKategori,
                'created_at' => now(),
                'updated_at' => now(),
                'status_kategori' => now(),
            ]);
        }

        // ==========================================
        // 2. SEEDER TABEL USERS (Induk Kedua)
        // ==========================================
        DB::table('users')->insertOrIgnore([
            [
                'username' => 'petugas1',
                'telp' => 6281234567890,
                'email' => 'petugas@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'petugas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'admin1',
                'telp' => 6281234567891,
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        for ($u = 1; $u <= 5; $u++) {
            DB::table('users')->insert([
                'username' => $faker->userName(),
                'telp' => '628' . $faker->numerify('##########'),
                'email' => $faker->unique()->safeEmail(),
                'password' => Hash::make('password'),
                'role' => 'peminjam',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $userIds = DB::table('users')->pluck('id_user')->toArray();
        $peminjamIds = DB::table('users')->where('role', 'peminjam')->pluck('id_user')->toArray();
        $petugasIds = DB::table('users')
            ->whereIn('role', ['admin', 'petugas'])
            ->pluck('id_user')
            ->toArray();

        // ==========================================
        // 3. SEEDER TABEL ALAT (Butuh id_kategori)
        // ==========================================
        $daftarAlat = ['Proyektor Epson', 'Kamera Canon 60D', 'Sound System Portable', 'Microphone Wireless', 'Bola Basket', 'Laptop Asus Core i5', 'Tripod Takara', 'Kabel Roll 15m', 'Terminal Listrik', 'Router WiFi'];

        $alatIds = [];
        foreach ($daftarAlat as $namaAlat) {
            $alatIds[] = DB::table('alat')->insertGetId([
                'id_kategori' => $faker->randomElement($kategoriIds),
                'nama_alat' => $namaAlat,
                'foto' => 'default.jpg',
                'spesifikasi' => 'Spesifikasi standar untuk ' . $namaAlat,
                'kondisi' => $faker->randomElement(['baru', 'rusak_ringan', 'rusak_berat']),
                'stok' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
                'status_alat' => now(),
            ]);
        }

        // ==========================================
        // 4. SEEDER TABEL PEMINJAMAN (Butuh id_user & id_alat)
        // ==========================================
        $statusOptions = ['ajukan peminjaman', 'dipinjam', 'ajukan kembali', 'dikembalikan', 'ditolak'];

        for ($i = 1; $i <= 20; $i++) {
            $tglPinjam = $faker->dateTimeBetween('-1 month', 'now');
            $tglKembali = Carbon::instance($tglPinjam)->addDays(rand(3, 7));
            $status = $faker->randomElement($statusOptions);
            $peminjamId = $faker->randomElement($peminjamIds);

            $peminjamanId = DB::table('peminjaman')->insertGetId([
                'id_user' => $peminjamId,
                'id_alat' => $faker->randomElement($alatIds),
                'status' => $status,
                'jumlah' => rand(1, 3),
                'tanggal_pinjam' => $tglPinjam,
                'tanggal_kembali' => $tglKembali,
            ]);

            // ==========================================
            // 5. SEEDER TABEL HISTORI_PINJAMAN (Jika Selesai/Dikembalikan)
            // ==========================================
            if (in_array($status, ['dikembalikan', 'selesai'])) {
                DB::table('histori_pinjaman')->insert([
                    'id_peminjaman' => $peminjamanId,
                    'id_user' => $peminjamId,
                    'tanggal_dikembalikan' => $tglKembali,
                    'status_akhir' => $faker->randomElement(['dikembalikan', 'denda', 'hilang']),
                    'catatan_petugas' => 'Pengembalian dikonfirmasi oleh petugas.',
                    'created_at' => $tglKembali,
                    'updated_at' => $tglKembali,
                ]);
            }

            // ==========================================
            // 6. SEEDER TABEL LOG_AKTIVITAS (Catat Aksi)
            // ==========================================
            $aktivitasList = ['Mengajukan peminjaman alat', 'Menyetujui peminjaman alat', 'Mengajukan pengembalian alat', 'Mengonfirmasi pengembalian alat', 'Menolak peminjaman alat'];

            DB::table('log_aktivitas')->insert([
                'id_user' => $faker->randomElement($userIds),
                'aktifitas' => $faker->randomElement($aktivitasList),
                'keterangan' => 'Transaksi Peminjaman ID #' . $peminjamanId,
                'created_at' => $tglPinjam,
                'updated_at' => $tglPinjam,
            ]);
        }
    }
}
