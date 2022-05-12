<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePemasukanDanPengeluaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemasukan', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable();
            $table->string('nominal')->nullable();
            $table->string('kategori_nama')->nullable(); //danabos dll
            $table->string('tglbayar')->nullable();
            $table->string('catatan')->nullable();
            $table->timestamps();
        });


        Schema::create('pengeluaran', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable();
            $table->string('nominal')->nullable();
            $table->string('kategori_nama')->nullable(); //danabos dll
            $table->string('tglbayar')->nullable();
            $table->string('catatan')->nullable();
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
        Schema::dropIfExists('pemasukan');
    }
}
