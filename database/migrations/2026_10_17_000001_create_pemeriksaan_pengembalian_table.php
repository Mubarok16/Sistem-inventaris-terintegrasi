<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemeriksaan_pengembalian', function (Blueprint $table) {
            $table->bigIncrements('id_pemeriksaan');
            $table->string('kode_peminjaman', 12);
            $table->enum('jenis_aset', ['barang', 'ruangan']);
            $table->string('id_item', 12)->nullable();
            $table->string('id_room', 12)->nullable();
            $table->unsignedInteger('qty_dikembalikan')->default(1);
            $table->unsignedInteger('qty_rusak')->default(0);
            $table->string('kondisi_pengembalian', 20)->default('baik');
            $table->text('deskripsi_kerusakan')->nullable();
            $table->string('foto_kerusakan')->nullable();
            $table->string('dicatat_oleh', 12);
            $table->timestamp('tanggal_pemeriksaan')->useCurrent();
            $table->timestamps(0);

            $table->foreign('kode_peminjaman')->references('kode_peminjaman')->on('peminjaman')->cascadeOnDelete();
            $table->foreign('id_item')->references('id_item')->on('items')->nullOnDelete();
            $table->foreign('id_room')->references('id_room')->on('rooms')->nullOnDelete();
            $table->foreign('dicatat_oleh')->references('id_user')->on('users');
            $table->index(['kode_peminjaman', 'tanggal_pemeriksaan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemeriksaan_pengembalian');
    }
};
