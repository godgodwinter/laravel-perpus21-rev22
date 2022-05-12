<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('paginationjml')->nullable();
            $table->string('sekolahnama')->nullable();
            $table->string('sekolahalamat')->nullable();
            $table->string('sekolahtelp')->nullable();
            $table->string('aplikasijudul')->nullable();
            $table->string('aplikasijudulsingkat')->nullable();
            $table->string('defaultdenda')->nullable();
            $table->string('defaultminbayar')->nullable();
            $table->string('defaultmaxbukupinjam')->nullable();
            $table->string('defaultmaxharipinjam')->nullable();
            $table->string('passdefaultpegawai')->nullable();
            $table->string('passdefaultadmin')->nullable();
            $table->string('sekolahlogo')->nullable();
            $table->string('sekolahttd')->nullable();
            $table->string('sekolahttd2')->nullable();
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
        Schema::dropIfExists('settings');
    }
}
