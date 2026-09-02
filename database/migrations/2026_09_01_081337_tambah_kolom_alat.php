<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('alat', function (Blueprint $table) {
            // Tambahkan kolom baru di sini
            // Pakai nullable() agar record lama yang sudah ada tidak error karena bernilai NULL
            $table->timestamp('status_alat')->nullable()->after('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alat', function (Blueprint $table) {
            // Hapus kolom jika migration di-rollback
            $table->dropColumn('status_alat');
        });
    }
};
