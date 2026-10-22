# 🛠️ Web SPK Peminjaman Alat

Aplikasi web pengelolaan dan peminjaman alat berbasis **Laravel** yang dirancang untuk mempermudah pencatatan, verifikasi persetujuan, serta rekapitulasi riwayat peminjaman secara digital dan efisien menggantikan pencatatan manual di buku.

---

## 🛠️ Tech Stack

- **Framework:** Laravel (PHP 8.2+)
- **Database:** MySQL
- **Frontend / Styling:** Blade, Tailwind CSS / Bootstrap, FontAwesome
- **Version Control:** Git & GitHub

---

## ⚡ Fitur Utama

- **Katalog & Stok Alat Real-time:** Menampilkan daftar alat yang siap dipinjam dengan validasi stok dinamis (`max:stok`).
- **Pengajuan Peminjaman & Pengembalian:** Formulir digital bagi peminjam dengan pilihan jaminan (KTP/SIM/Tanpa Jaminan).
- **Verifikasi & Modal Penolakan:** Fitur persetujuan/penolakan peminjaman oleh admin/petugas dilengkapi input alasan penolakan dan pengembalian stok otomatis.
- **Riwayat & Audit Log Aktivitas:** Pencatatan histori transaksi peminjaman serta rekam jejak aksi pengguna (_log activity_) di dalam sistem.
- **Laporan & Rekapitulasi:** Rekap data peminjaman yang dapat difilter berdasarkan rentang waktu.

---

## 🔑 Akses Akun Uji Coba (Login per Role)

Berikut adalah daftar akun untuk pengujian sistem berdasarkan tingkatan _role_:

| Role         | Username / Email | Password      | Hak Akses Utama                                              |
| :----------- | :--------------- | :------------ | :----------------------------------------------------------- |
| **Admin**    | `admin_sistem`   | `password123` | Kelola User, Kategori, Master Alat, Log Aktivitas, & Laporan |
| **Petugas**  | `petugas_lab`    | `password123` | Konfirmasi Peminjaman/Pengembalian & Kelola Stok Alat        |
| **Peminjam** | `user_10`        | `password123` | Cari Alat, Ajukan Peminjaman, & Cek Riwayat Peminjaman Saya  |

---

## 🚀 Cara Menjalankan Project (Local Development)

### 1. Clone Repository

```bash
git clone https://github.com/RESKY753/Peminjaman-alat
cd Peminjaman-alat
```

### 2. Install Dependency

```Bash
composer install
npm install && npm run build
```

### 3. Konfigurasi Environment

Salin file .env.example menjadi .env:

```Bash
cp .env.example .env
Sesuaikan konfigurasi database pada file .env:

Cuplikan kode
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database_kamu
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate App Key & Database Migration

```Bash
php artisan key:generate
php artisan migrate
```

### 5. Jalankan Server Lokal

```Bash
php artisan serve
Akses aplikasi melalui browser di [http://127.0.0.1:8000](http://127.0.0.1:8000).
```

---

### Pengembang

---

### Developer: Muhamad Resky Aditya (@RESKY753) — Siswa XII RPL 2 SMK Sangkuriang 1 Cimahi
