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
            $table->integer('no_hp')->nullable();
            $table->timestamps();
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
            $table->timestamps();

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
            $table->timestamps();

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
            $table->timestamps();
        });

        // table peminjaman
         Schema::create('peminjaman', function (Blueprint $table) {
            $table->string('kode_peminjaman', 12)->primary();
            $table->string('no_identitas', 12);
            $table->string('id_user', 12);
            $table->text('ket_peminjaman');
            $table->text('lampiran_file');
            $table->text('status_peminjaman');
            $table->dateTime('tgl_tansaksi');
            $table->timestamps();

            // Foreign keys
            $table->foreign('id_user')
                  ->references('id_user')
                  ->on('users');

            $table->foreign('no_identitas')
                  ->references('no_identitas')
                  ->on('peminjam');
        });

        // table Agenda Fakultas
         Schema::create('agenda_fakultas', function (Blueprint $table) {
            $table->string('kode_agenda', 12)->primary();
            $table->string('id_user', 12);
            $table->text('nama_agenda');
            $table->text('tipe_agenda');
            $table->dateTime('tgl_mulai_agenda');
            $table->dateTime('tgl_selesai_agenda');
            $table->timestamps();

            // Foreign keys
            $table->foreign('id_user')
                  ->references('id_user')
                  ->on('users');
        });

        // table usage rooms
         Schema::create('usage_rooms', function (Blueprint $table) {
            $table->string('kode_peminjaman', 12)->nullable();
            $table->string('kode_agenda', 12)->nullable();
            $table->string('id_room', 12);
            $table->dateTime('tgl_pinjam_usage_room');
            $table->dateTime('tgl_kembali_usage_room');
            $table->text('status_usage_room');
            $table->timestamps();

            // Foreign keys
            $table->foreign('id_room')
                  ->references('id_room')
                  ->on('rooms');

            $table->foreign('kode_peminjaman')
                  ->references('kode_peminjaman')
                  ->on('peminjaman');

            $table->foreign('kode_agenda')
                  ->references('kode_agenda')
                  ->on('agenda_fakultas');
        });

        // table usage items
        Schema::create('usage_items', function (Blueprint $table) {
           $table->string('kode_peminjaman', 12)->nullable();
            $table->string('kode_agenda', 12)->nullable();
            $table->string('id_item', 12);
            $table->integer('qty_usage_item');
            $table->dateTime('tgl_pinjam_usage_item');
            $table->dateTime('tgl_kembali_usage_item');
            $table->text('status_usage_item');
            $table->timestamps();

            // Foreign keys
            $table->foreign('id_item')
                  ->references('id_item')
                  ->on('items');

            $table->foreign('kode_peminjaman')
                  ->references('kode_peminjaman')
                  ->on('peminjaman');

            $table->foreign('kode_agenda')
                  ->references('kode_agenda')
                  ->on('agenda_fakultas');
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
        Schema::dropIfExists('peminjaman');
        Schema::dropIfExists('agenda_fakultas');
        Schema::dropIfExists('usage_rooms');
        Schema::dropIfExists('usage_items');
    }
};
