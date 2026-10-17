<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('perawatan_barang', function (Blueprint $table) {
            $table->string('sumber_perawatan', 20)->default('manual')->after('qty_perawatan');
            $table->unsignedBigInteger('id_pemeriksaan')->nullable()->after('sumber_perawatan');
            $table->unique('id_pemeriksaan', 'perawatan_id_pemeriksaan_unique');
            $table->foreign('id_pemeriksaan', 'perawatan_id_pemeriksaan_foreign')
                ->references('id_pemeriksaan')->on('pemeriksaan_pengembalian')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('perawatan_barang', function (Blueprint $table) {
            $table->dropForeign('perawatan_id_pemeriksaan_foreign');
            $table->dropUnique('perawatan_id_pemeriksaan_unique');
            $table->dropColumn(['id_pemeriksaan', 'sumber_perawatan']);
        });
    }
};
