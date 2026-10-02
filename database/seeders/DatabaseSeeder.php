<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Kategori (20 Data)
        for ($i = 1; $i <= 20; $i++) {
            DB::table('kategori')->insert([
                'id_kategori' => $i,
                'nama_kategori' => 'Kategori '.$i,
                'keterangan' => 'Keterangan untuk kategori ke-'.$i,
                'status_aktif' => 'true',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 2. Alat (20 Data)
        $kondisiList = ['baru', 'rusak_ringan', 'rusak_berat'];
        for ($i = 1; $i <= 20; $i++) {
            DB::table('alat')->insert([
                'id_alat' => $i,
                'id_kategori' => rand(1, 20),
                'nama_alat' => 'Alat Prakttek '.$i,
                'foto' => 'default.jpg',
                'spesifikasi' => 'Spesifikasi standar alat nomor '.$i,
                'kondisi' => $kondisiList[array_rand($kondisiList)],
                'stok' => rand(2, 15),
                'status_alat' => 'true',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 3. Users (20 Data)
        for ($i = 1; $i <= 20; $i++) {
            DB::table('users')->insert([
                'id_user' => $i,
                'username' => $i == 1 ? 'admin_sistem' : ($i == 2 ? 'petugas_lab' : 'user_'.$i),
                'telp' => '62812345678'.str_pad($i, 2, '0', STR_PAD_LEFT),
                'email' => 'user'.$i.'@mail.com',
                'password' => Hash::make('password123'),
                'role' => $i == 1 ? 'admin' : ($i == 2 ? 'petugas' : 'peminjam'),
                'status_aktif' => 'true',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 4. Peminjaman (20 Data)
        $statusPeminjaman = ['ajukan peminjaman', 'dipinjam', 'ajukan kembali', 'dikembalikan', 'ditolak', 'pengembalian ditolak'];
        $jaminanList = ['tidak ada jaminan', 'KTP', 'SIM'];
        for ($i = 1; $i <= 20; $i++) {
            DB::table('peminjaman')->insert([
                'id_peminjaman' => $i,
                'id_user' => rand(3, 20),
                'id_alat' => rand(1, 20),
                'status' => $statusPeminjaman[array_rand($statusPeminjaman)],
                'jaminan' => $jaminanList[array_rand($jaminanList)],
                'jumlah' => rand(1, 3),
                'tanggal_pinjam' => now()->subDays(rand(1, 10)),
                'tanggal_kembali' => now()->addDays(rand(1, 5)),
            ]);
        }

        // 5. Log Aktivitas (Dikosongkan sesuai permintaan)

        // 6. Histori Pinjaman (20 Data) - DIPERBAIKI (Tanpa updated_at)
        $statusAkhir = ['dikembalikan', 'ditolak'];
        for ($i = 1; $i <= 20; $i++) {
            DB::table('histori_pinjaman')->insert([
                'id_histori' => $i,
                'id_peminjaman' => $i,
                'status_akhir' => $statusAkhir[array_rand($statusAkhir)],
                'created_at' => now(), // Cuma pakai created_at saja sesuai kolom yang ada di database
            ]);
        }
    }
}
