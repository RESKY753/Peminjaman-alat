<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Tanda petik pada 'ditolak' sudah diperbaiki & DEFAULT diubah ke 'pending'
        DB::statement("ALTER TABLE peminjaman MODIFY COLUMN status ENUM('pending', 'dipinjam', 'dikembalikan', 'ditolak') NOT NULL DEFAULT 'pending'");
    }

    public function down(): void
    {
        // Sesuaikan dengan isi enum lama kamu sebelum ditambah
        DB::statement("ALTER TABLE peminjaman MODIFY COLUMN status ENUM('pending', 'dipinjam', 'dikembalikan') NOT NULL DEFAULT 'pending'");
    }
};
