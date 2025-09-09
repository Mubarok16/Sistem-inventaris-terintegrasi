<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // public function up(): void
    // {
    //     // table Usage_items
    //     Schema::create('Usage_items', function (Blueprint $table) {
    //         $table->id_usage_items()->primary();
    //         $table->foreignId('id_user')->constrained('users');
    //         $table->foreignId('id_item')->constrained('items');
    //         $table->dateTime('tgl_usage');
    //         $table->dateTime('tgl_kembali');
    //         $table->integer('qty_usage');
    //         $table->text('ket_usage');
    //         $table->text('status_usage');
    //     });
    //     // table items
    //     Schema::create('items', function (Blueprint $table) {
    //         $table->id_items()->primary();
    //         $table->string('nama_item');
    //         $table->foreignId('id_room')->constrained('rooms');
    //         $table->foreignId('id_tipe_item')->constrained('tipe_items');
    //         $table->integer('qty_item');
    //         $table->string('image_item');
    //         $table->string('kondisi_item');
    //     });
    //     // table rooms
    //     Schema::create('rooms', function (Blueprint $table) {
    //         $table->id_room()->primary();
    //         $table->foreignId('id_tipe_rooms')->constrained('tipe_rooms');
    //         $table->string('nama_room');
    //         $table->string('image_room');
    //         $table->string('kondisi_room');
    //     });
    //     // table tipe_items
    //     Schema::create('tipe_items', function (Blueprint $table) {
    //         $table->id_tipe_item()->primary();
    //         $table->string('nama_tipe_item');
    //     });
    //     // table tipe_rooms
    //     Schema::create('tipe_rooms', function (Blueprint $table) {
    //         $table->id_tipe_rooms()->primary();
    //         $table->string('nama_tipe_room');
    //     });
    //     // table agenda
    //     Schema::create('agenda', function (Blueprint $table) {
    //         $table->id_agenda()->primary();
    //         $table->foreignId('id_room')->constrained('rooms');
    //         $table->foreignId('id_usage_items')->constrained('Usage_items');
    //         $table->foreignId('id_user')->constrained('users');
    //         $table->foreignId('tipe_agenda')->constrained('tipe_agenda');
    //         $table->date('tgl_agenda');
    //         $table->time('waktu_mulai');
    //         $table->time('waktu_selesai');
    //         $table->text('ket_agenda');
    //     });
    //     // table tipe_agenda
    //     Schema::create('tipe_agenda', function (Blueprint $table) {
    //         $table->id_tipe_agenda()->primary();
    //         $table->string('nama_tipe_agenda');
    //     });
    // }

    // public function up(): void
    // {
    //     // table tipe_rooms
    //     Schema::create('tipe_rooms', function (Blueprint $table) {
    //         $table->bigIncrements('id_tipe_rooms');
    //         $table->string('nama_tipe_room');
    //     });

    //     // table tipe_items
    //     Schema::create('tipe_items', function (Blueprint $table) {
    //         $table->bigIncrements('id_tipe_item');
    //         $table->string('nama_tipe_item');
    //     });

    //     // table tipe_agenda
    //     Schema::create('tipe_agenda', function (Blueprint $table) {
    //         $table->bigIncrements('id_tipe_agenda');
    //         $table->string('nama_tipe_agenda');
    //     });

    //     // table rooms
    //     Schema::create('rooms', function (Blueprint $table) {
    //         $table->bigIncrements('id_room');
    //         $table->foreignId('id_tipe_rooms')->constrained('tipe_rooms');
    //         $table->string('nama_room');
    //         $table->string('image_room');
    //         $table->string('kondisi_room');
    //     });

    //     // table items
    //     Schema::create('items', function (Blueprint $table) {
    //         $table->bigIncrements('id_items');
    //         $table->string('nama_item');
    //         $table->foreignId('id_room')->constrained('rooms');
    //         $table->foreignId('id_tipe_item')->constrained('tipe_items');
    //         $table->integer('qty_item');
    //         $table->string('image_item');
    //         $table->string('kondisi_item');
    //     });

    //     // table usage_items
    //     Schema::create('usage_items', function (Blueprint $table) {
    //         $table->bigIncrements('id_usage_items');
    //         $table->foreignId('id_user')->constrained('users');
    //         $table->foreignId('id_item')->constrained('items');
    //         $table->dateTime('tgl_usage');
    //         $table->dateTime('tgl_kembali');
    //         $table->integer('qty_usage');
    //         $table->text('ket_usage');
    //         $table->text('status_usage');
    //     });

    //     // table agenda
    //     Schema::create('agenda', function (Blueprint $table) {
    //         $table->bigIncrements('id_agenda');
    //         $table->foreignId('id_room')->constrained('rooms');
    //         $table->foreignId('id_usage_items')->constrained('usage_items');
    //         $table->foreignId('id_user')->constrained('users');
    //         $table->foreignId('tipe_agenda')->constrained('tipe_agenda');
    //         $table->date('tgl_agenda');
    //         $table->time('waktu_mulai');
    //         $table->time('waktu_selesai');
    //         $table->text('ket_agenda');
    //     });
    // }

    public function up(): void
    {
        // table tipe_rooms
        Schema::create('tipe_rooms', function (Blueprint $table) {
            $table->bigIncrements('id_tipe_rooms')->primary();
            $table->string('nama_tipe_room');
        });

        // table tipe_items
        Schema::create('tipe_items', function (Blueprint $table) {
            $table->bigIncrements('id_tipe_item')->primary();
            $table->string('nama_tipe_item');
        });

        // table tipe_agenda
        Schema::create('tipe_agenda', function (Blueprint $table) {
            $table->bigIncrements('id_tipe_agenda')->primary();
            $table->string('nama_tipe_agenda');
        });

        // table rooms
        Schema::create('rooms', function (Blueprint $table) {
            $table->bigIncrements('id_room')->primary();
            $table->unsignedBigInteger('id_tipe_rooms');
            $table->foreign('id_tipe_rooms')->references('id_tipe_rooms')->on('tipe_rooms');
            $table->string('nama_room');
            $table->string('image_room');
            $table->string('kondisi_room');
        });

        // table items
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id_items')->primary();
            $table->string('nama_item');
            $table->unsignedBigInteger('id_room');
            $table->foreign('id_room')->references('id_room')->on('rooms');
            $table->unsignedBigInteger('id_tipe_item');
            $table->foreign('id_tipe_item')->references('id_tipe_item')->on('tipe_items');
            $table->integer('qty_item');
            $table->string('image_item');
            $table->string('kondisi_item');
        });

        // table usage_items
        Schema::create('usage_items', function (Blueprint $table) {
            $table->bigIncrements('id_usage_items')->primary();
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id_user')->on('users');
            $table->unsignedBigInteger('id_item');
            $table->foreign('id_item')->references('id_items')->on('items');
            $table->dateTime('tgl_usage');
            $table->dateTime('tgl_kembali');
            $table->integer('qty_usage');
            $table->text('ket_usage');
            $table->text('status_usage');
        });

        // table agenda
        Schema::create('agenda', function (Blueprint $table) {
            $table->bigIncrements('id_agenda')->primary();
            $table->unsignedBigInteger('id_room');
            $table->foreign('id_room')->references('id_room')->on('rooms');
            $table->unsignedBigInteger('id_usage_items');
            $table->foreign('id_usage_items')->references('id_usage_items')->on('usage_items');
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id_user')->on('users');
            $table->unsignedBigInteger('id_tipe_agenda');
            $table->foreign('id_tipe_agenda')->references('id_tipe_agenda')->on('tipe_agenda');
            $table->date('tgl_agenda');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->text('ket_agenda');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Usage_items');
        Schema::dropIfExists('items');
        Schema::dropIfExists('rooms');
        Schema::dropIfExists('tipe_items');
        Schema::dropIfExists('tipe_rooms');
        Schema::dropIfExists('agenda');
        Schema::dropIfExists('tipe_agenda');
    }
};
