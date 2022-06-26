<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkorPrestasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skor_prestasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jenis_kejuaraan_id')->constrained('jenis_kejuaraan')->onDelete('cascade');
            $table->foreignId('tingkat_prestasi_id')->constrained('tingkat_prestasi')->onDelete('cascade');
            $table->integer('peringkat');
            $table->integer('skor');
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
        Schema::dropIfExists('skor_prestasi');
    }
}
