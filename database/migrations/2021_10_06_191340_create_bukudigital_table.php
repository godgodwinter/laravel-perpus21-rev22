<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBukudigitalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bukudigital', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable();
            $table->string('gambar')->nullable();
            $table->string('ket')->nullable();
            $table->string('tipe')->nullable(); // upload dan link
            $table->string('link')->nullable();
            $table->string('file')->nullable();
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
        Schema::dropIfExists('bukudigital');
    }
}
