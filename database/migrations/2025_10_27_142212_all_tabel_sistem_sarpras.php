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
        // Database/migrations/xxxx_xx_xx_create_users_table.php
        Schema::create('users', function (Blueprint $table) {
            $table->string('id_user', 12)->primary();
            $table->text('nama');
            $table->string('username', 12);
            $table->string('password', 255);
            $table->string('hak_akses', 10);
            $table->decimal('no_hp', 50)->nullable();
            $table->string('status', 10)->nullable();
            $table->text('jabatan')->nullable();
            $table->timestamps(0);
        });

        // Database/migrations/xxxx_xx_xx_create_peminjam_table.php
        Schema::create('peminjam', function (Blueprint $table) {
            $table->string('no_identitas', 12)->primary();
            $table->text('nama_peminjam');
            $table->string('username', 12);
            $table->string('password', 255);
            $table->text('fakultas');
            $table->text('prodi');
            $table->text('img_identitas');
            $table->string('status', 10)->nullable();
            $table->integer('tahun_masuk')->nullable();
            $table->timestamps(0);
        });

        // Database/migrations/xxxx_xx_xx_create_tipe_rooms_table.php
        Schema::create('tipe_rooms', function (Blueprint $table) {
            $table->string('id_tipe_room', 12)->primary();
            $table->text('nama_tipe_room');
        });

        // tipe item
        // Schema::create('tipe_item', function (Blueprint $table) {
        //     $table->string('id_tipe_item', 12)->primary();
        //     $table->text('nama_tipe_item');
        // });

        // Database/migrations/xxxx_xx_xx_create_rooms_table.php
        Schema::create('rooms', function (Blueprint $table) {
            $table->string('id_room', 12)->primary();
            $table->string('id_tipe_room', 12);
            $table->text('nama_room');
            $table->string('kondisi_room', 12);
            $table->text('gambar_room');
            $table->text('visibility_room')->nullable();
            $table->timestamps(0);

            $table->foreign('id_tipe_room')->references('id_tipe_room')->on('tipe_rooms');
        });

        // Database/migrations/xxxx_xx_xx_create_items_table.php
        Schema::create('items', function (Blueprint $table) {
            $table->string('id_item', 12)->primary();
            $table->string('id_room', 12);
            // $table->string('id_tipe_item', 12);
            $table->string('nama_item', 12);
            $table->string('merek_model', 12);
            $table->integer('qty_item');
            $table->string('kondisi_item', 12);
            $table->text('img_item');
            $table->text('visibility_item')->nullable();
            $table->timestamps(0);

            $table->foreign('id_room')->references('id_room')->on('rooms');
            // $table->foreign('id_tipe_item')->references('id_tipe_item')->on('tipe_item');
        });

        // Database/migrations/xxxx_xx_xx_create_agenda_fakultas_table.php
        Schema::create('agenda_fakultas', function (Blueprint $table) {
            $table->string('kode_agenda', 12)->primary();
            $table->string('kode_referensi', 12);
            $table->string('id_user', 12);
            $table->text('nama_agenda');
            $table->date('tgl_mulai_agenda')->nullable();
            $table->text('tipe_agenda')->nullable();
            $table->date('tgl_selesai_agenda')->nullable();
            $table->text('loop_hari')->nullable();
            $table->timestamps(0);

            $table->foreign('id_user')->references('id_user')->on('users');
        });

        // Database/migrations/xxxx_xx_xx_create_peminjaman_table.php
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->string('kode_peminjaman', 12)->primary();
            $table->string('no_identitas', 12);
            $table->string('id_user', 12)->nullable();
            $table->text('ket_peminjaman');
            $table->text('lampiran_file');
            $table->timestamp('tgl_tansaksi', 0);
            $table->text('status_peminjaman')->nullable();
            $table->text('catatan_pengelola')->nullable();
            $table->timestamp('tgl_pinjam')->nullable();
            $table->timestamp('tgl_kembali')->nullable();
            $table->timestamps(0);

            $table->foreign('id_user')->references('id_user')->on('users');
            $table->foreign('no_identitas')->references('no_identitas')->on('peminjam');
        });

        // Database/migrations/xxxx_xx_xx_create_usage_rooms_table.php
        Schema::create('usage_rooms', function (Blueprint $table) {
            $table->string('kode_peminjaman', 12)->nullable();
            $table->string('kode_agenda', 12)->nullable();
            $table->string('id_room', 12);
            $table->timestamp('tgl_pinjam_usage_room', 0);
            $table->timestamp('tgl_kembali_usage_room', 0);
            $table->text('status_usage_room');
            $table->time('jam_mulai_usage_room')->nullable();
            $table->time('jam_selesai_usage_room')->nullable();
            $table->timestamps(0);

            $table->foreign('id_room')->references('id_room')->on('rooms');
            $table->foreign('kode_agenda')->references('kode_agenda')->on('agenda_fakultas');
            $table->foreign('kode_peminjaman')->references('kode_peminjaman')->on('peminjaman');
        });

        // Database/migrations/xxxx_xx_xx_create_usage_items_table.php
        Schema::create('usage_items', function (Blueprint $table) {
            $table->string('kode_peminjaman', 12)->nullable();
            $table->string('kode_agenda', 12)->nullable();
            $table->string('id_item', 12);
            $table->integer('qty_usage_item');
            $table->timestamp('tgl_pinjam_usage_item', 0);
            $table->timestamp('tgl_kembali_usage_item', 0);
            $table->text('status_usage_item');
            $table->time('jam_mulai_usage_item', 0)->nullable();
            $table->time('jam_selesai_usage_item', 0)->nullable();
            $table->timestamps(0);

            $table->foreign('id_item')->references('id_item')->on('items');
            $table->foreign('kode_agenda')->references('kode_agenda')->on('agenda_fakultas');
            $table->foreign('kode_peminjaman')->references('kode_peminjaman')->on('peminjaman');
        });

        Schema::create('pengadaan_barang', function (Blueprint $table) {
            $table->string('id_pengadaan', 12)->primary();
            $table->string('id_pemohon', 12);
            $table->string('id_penyetuju', 12)->nullable();
            $table->text('nama_item');
            $table->string('merek_model', 20);
            $table->integer('qty_item');
            $table->string('status_pengadaan', 20);
            $table->string('tahun_akademik', 15);
            $table->text('keperluan_prodi');
            $table->timestamps(0);

            $table->foreign('id_pemohon')->references('id_user')->on('users');
            $table->foreign('id_penyetuju')->references('id_user')->on('users');
        });

        Schema::create('perawatan_barang', function (Blueprint $table) {
            $table->string('id_perawatan', 100)->primary();
            $table->string('id_pemohon', 12);
            $table->string('id_penyetuju', 12)->nullable();
            $table->string('id_item', 12)->nullable();
            $table->string('id_room', 12)->nullable();
            $table->integer('qty_perawatan');
            $table->string('status_perawatan', 20);
            $table->string('tahun_akademik', 15);
            $table->text('keperluan_prodi');
            $table->timestamps(0);

            $table->foreign('id_pemohon')->references('id_user')->on('users');
            $table->foreign('id_penyetuju')->references('id_user')->on('users');
            $table->foreign('id_item')->references('id_item')->on('items');
            $table->foreign('id_room')->references('id_room')->on('rooms');
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
        Schema::dropIfExists('pengadaan_barang');
        Schema::dropIfExists('perawatan_barang');
    }
};
