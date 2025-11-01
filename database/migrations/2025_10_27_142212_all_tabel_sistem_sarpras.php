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
        // table users
        Schema::create('users', function (Blueprint $table) {
            $table->string('id_user', 12)->primary();
            $table->text('nama');
            $table->string('username', 12);
            $table->string('password', 255);
            $table->string('hak_akses', 10);
        });

        // table tipe_rooms
        Schema::create('tipe_rooms', function (Blueprint $table) {
            $table->string('id_tipe_room', 12)->primary();
            $table->text('nama_tipe_room');
        });

        // table rooms
        Schema::create('rooms', function (Blueprint $table) {
            $table->string('id_room', 12)->primary();
            $table->string('id_tipe_room', 12);
            $table->text('nama_room');
            $table->string('kondisi_room', 12);
            $table->text('gambar_room');

            // Relasi ke tabel tipe_rooms
            $table->foreign('id_tipe_room')
                ->references('id_tipe_room')
                ->on('tipe_rooms');
        });

        // table tipe_item dan items
        Schema::create('tipe_item', function (Blueprint $table) {
            $table->string('id_tipe_item', 12)->primary();
            $table->text('nama_tipe_item');
        });

        // table items
        Schema::create('items', function (Blueprint $table) {
            $table->string('id_item', 12)->primary();
            $table->string('id_room', 12);
            $table->string('id_tipe_item', 12);
            $table->string('nama_item', 12);
            $table->string('merek_model', 12);
            $table->integer('qty_item');
            $table->string('kondisi_item', 12);
            $table->text('img_item');

            // Foreign key constraints
            $table->foreign('id_room')
                ->references('id_room')
                ->on('rooms');

            $table->foreign('id_tipe_item')
                ->references('id_tipe_item')
                ->on('tipe_item');
        });

        // table peminjam
         Schema::create('peminjam', function (Blueprint $table) {
            $table->string('no_identitas', 12)->primary();
            $table->text('nama_peminjam');
            $table->string('username', 12);
            $table->string('password', 255);
            $table->text('fakultas');
            $table->text('prodi');
            $table->text('img_identitas');
        });

        // table peminjaman rooms
         Schema::create('peminjaman_rooms', function (Blueprint $table) {
            $table->string('id_peminjaman_room', 12)->primary();
            $table->string('kode_transaksi', 12);
            $table->string('id_room', 12);
            $table->string('id_user', 12)->nullable();
            $table->string('no_identitas', 12);
            $table->text('lampiran_file')->nullable();
            $table->text('ket_peminjaman');
            $table->timestampTz('tgl_transaksi');
            $table->timeTz('tgl_mulai');
            $table->timeTz('tgl_selesai');
            $table->string('status');

            // Foreign keys
            $table->foreign('id_room')
                  ->references('id_room')
                  ->on('rooms');

            $table->foreign('id_user')
                  ->references('id_user')
                  ->on('users');

            $table->foreign('no_identitas')
                  ->references('no_identitas')
                  ->on('peminjam');
        });

        // table peminjaman items
        Schema::create('peminjaman_items', function (Blueprint $table) {
            $table->string('id_peminjaman_item', 12)->primary();
            $table->string('kode_transaksi', 12);
            $table->string('id_user', 12);
            $table->string('id_item', 12);
            $table->string('no_identitas', 12);
            $table->text('lampiran_file');
            $table->timeTz('tgl_transaksi_item');
            $table->timeTz('tgl_pinjam_item');
            $table->timeTz('tgl_kembali_item');
            $table->integer('qty_pinjam_item');
            $table->string('status_item', 12);

            // Foreign keys
            $table->foreign('id_item')
                  ->references('id_item')
                  ->on('items');

            $table->foreign('id_user')
                  ->references('id_user')
                  ->on('users');

            $table->foreign('no_identitas')
                  ->references('no_identitas')
                  ->on('peminjam');
        });

        // table agenda_akademik
        Schema::create('agenda_akademik', function (Blueprint $table) {
            $table->string('id_agenda_akademik', 12)->primary();
            $table->text('nama_agenda_akademik');
            $table->string('id_room', 12);
            $table->string('id_item', 12);
            $table->timeTz('tgl_agenda');
            $table->timeTz('tgl_agenda_selesai');

            // Relasi ke tabel items
            $table->foreign('id_item')
                  ->references('id_item')
                  ->on('items');

            // Relasi ke tabel rooms
            $table->foreign('id_room')
                  ->references('id_room')
                  ->on('rooms');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('tipe_rooms');
        Schema::dropIfExists('rooms');
        Schema::dropIfExists('tipe_item');
        Schema::dropIfExists('items');
        Schema::dropIfExists('peminjam');
        Schema::dropIfExists('peminjaman_rooms');
        Schema::dropIfExists('peminjaman_items');
        Schema::dropIfExists('agenda_akademik');
    }
};
