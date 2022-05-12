<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeminjamanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->string('kodetrans')->nullable();
            $table->string('nama')->nullable();
            $table->string('nomeridentitas')->nullable();
            $table->string('jaminan_nama')->nullable();  //ktp / kartu pelajar
            $table->string('jaminan_tipe')->nullable(); //dari table kategori
            $table->string('tgl_pinjam')->nullable(); //timestamp
            $table->string('tgl_harus_kembali')->nullable(); //diambil dari settings maxharipinjam
            $table->string('denda')->nullable(); //diambil dari settings denda
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('peminjaman');
    }
}
