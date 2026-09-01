<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            // Tambahkan kolom baru di sini
            // Pakai nullable() agar record lama yang sudah ada tidak error karena bernilai NULL
            $table->integer('jumlah')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            // Hapus kolom jika migration di-rollback
            $table->dropColumn('alasan_pinjam');
        });
    }
};
