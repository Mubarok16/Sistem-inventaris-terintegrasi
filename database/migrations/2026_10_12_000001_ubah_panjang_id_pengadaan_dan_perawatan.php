<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengadaan_barang', function (Blueprint $table) {
            // Primary key lama tetap dipertahankan; hanya panjang VARCHAR diubah.
            $table->string('id_pengadaan', 100)->change();
        });

        Schema::table('perawatan_barang', function (Blueprint $table) {
            // Primary key lama tetap dipertahankan; hanya panjang VARCHAR diubah.
            $table->string('id_perawatan', 100)->change();
        });
    }

    public function down(): void
    {
        // Tidak mengubah ukuran saat rollback karena batas panjang kolom
        // sebelum migration ini belum diketahui. Atur sesuai skema asli
        // apabila Anda membutuhkan rollback yang reversibel.
    }
};
