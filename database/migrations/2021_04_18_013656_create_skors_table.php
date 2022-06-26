<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('komponen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jalur_id')->constrained('jalur')->onDelete('cascade');
            $table->string('nama');
            $table->integer('bobot');
            $table->integer('skor');
            $table->string('bukti');
            $table->smallInteger('tanggal')->nullable()->default(0);
            $table->integer('jenis_prestasi');
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
        Schema::dropIfExists('komponen');
    }
}
