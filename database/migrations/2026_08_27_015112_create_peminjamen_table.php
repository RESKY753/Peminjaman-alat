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
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id('id_peminjaman');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_alat');

            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('id_alat')->references('id_alat')->on('alat')->onDelete('cascade');
            $table->enum('status', ['ajukan peminjaman', 'dipinjam', 'ajukan kembali', 'dikembalikan', 'ditolak']);
            $table->enum('jaminan', ['tidak ada jaminan', 'KTP', 'SIM']);
            $table->integer('jumlah')->nullable();
            $table->timestamp('tanggal_pinjam')->useCurrent();
            $table->timestamp('tanggal_kembali')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
