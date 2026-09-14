<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('histori_pinjaman', function (Blueprint $table) {
            $table->id('id_histori');

            // Relasi Utama
            $table->foreignId('id_peminjaman')->constrained('peminjaman', 'id_peminjaman')->onDelete('cascade');
            // Data Khusus Riwayat (Yang tidak ada / berubah dari tabel peminjaman awal)
            $table->enum('status_akhir', ['dikembalikan', 'ditolak']);

            $table->timestamp('creted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histori_pinjaman');
    }
};
