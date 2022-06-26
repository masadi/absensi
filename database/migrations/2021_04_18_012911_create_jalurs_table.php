<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJalursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jalur', function (Blueprint $table) {
            $table->id();
            $table->integer('bentuk_pendidikan_id');
            $table->string('nama');
            $table->string('tautan');
            $table->string('icon');
            $table->integer('kuota');
            $table->string('card');
            $table->smallInteger('prestasi')->nullable()->default(0);
            $table->text('keterangan');
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
        Schema::dropIfExists('jalur');
    }
}
