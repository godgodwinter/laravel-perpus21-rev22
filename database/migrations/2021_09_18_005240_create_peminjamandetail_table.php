<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeminjamandetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peminjamandetail', function (Blueprint $table) {
            $table->id();
            $table->string('kodetrans')->nullable();
            $table->string('buku_isbn')->nullable(); //dari table kategori
            $table->string('nomeridentitas')->nullable();
            $table->string('buku_nama')->nullable();
            $table->string('buku_kode')->nullable();
            // $table->string('buku_kodepanggil')->nullable();
            $table->string('buku_penerbit')->nullable();
            $table->string('buku_tahunterbit')->nullable();
            $table->string('buku_pengarang')->nullable();
            $table->string('buku_tempatterbit')->nullable();
            $table->string('buku_bahasa')->nullable();
            // $table->string('bukurak_nama')->nullable();
            $table->string('bukukategori_nama')->nullable();  //ktp / kartu pelajar
            $table->string('bukukategori_ddc')->nullable(); //dari table kategori
            $table->string('jaminan_nama')->nullable();  //ktp / kartu pelajar
            $table->string('jaminan_tipe')->nullable(); //dari table kategori
            $table->string('tgl_pinjam')->nullable(); //timestamp
            $table->string('tgl_harus_kembali')->nullable(); //diambil dari settings maxharipinjam
            $table->string('denda')->nullable(); //diambil dari settings denda
            $table->string('statuspengembalian')->nullable(); //
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
        Schema::dropIfExists('peminjamandetail');
    }
}
