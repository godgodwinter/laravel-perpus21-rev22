<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnggotaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anggota', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable();
            $table->string('nomeridentitas')->nullable();
            $table->string('agama')->nullable();
            $table->string('tempatlahir')->nullable();
            $table->string('tgllahir')->nullable();
            $table->string('alamat')->nullable();
            $table->string('jk')->nullable();
            $table->string('tipe')->nullable(); // siswa / umum  //jika siswa sekolah lainya
            $table->string('sekolahasal')->nullable(); // siswa / umum //jika siswa sekolah lainya
            $table->string('telp')->nullable();
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
        Schema::dropIfExists('anggota');
    }
}
