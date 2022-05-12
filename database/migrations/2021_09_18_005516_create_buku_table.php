<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBukuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buku', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->nullable();
            $table->string('isbn')->nullable();
            $table->string('nama')->nullable();
            $table->string('pengarang')->nullable();
            $table->string('tempatterbit')->nullable();
            $table->string('penerbit')->nullable();
            $table->string('tahunterbit')->nullable();
            $table->string('bahasa')->nullable();
            // $table->string('bukurak_nama')->nullable();
            // $table->string('bukurak_kode')->nullable();
            $table->string('bukukategori_nama')->nullable();  //ktp / kartu pelajar
            $table->string('bukukategori_ddc')->nullable(); //dari table kategori
            $table->string('gambar')->nullable();
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
        Schema::dropIfExists('buku');
    }
}
