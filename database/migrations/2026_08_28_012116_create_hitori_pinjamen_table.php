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
            $table->foreignId('id_peminjaman')->constrained('peminjaman', 'id_peminjaman')->onDelete('restrict');
            $table->foreignId('id_user')->constrained('users', 'id_user')->onDelete('restrict');

            // Data Khusus Riwayat (Yang tidak ada / berubah dari tabel peminjaman awal)
            $table->timestamp('tanggal_dikembalikan'); // Waktu riil dikembalikan
            $table->enum('status_akhir', ['dikembalikan', 'denda', 'hilang'])->default('dikembalikan');
            $table->text('catatan_petugas')->nullable(); // Misal: "Lensa kamera agak kotor saat dikembalikan"

            $table->timestamps();
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
