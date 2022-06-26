<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDokumensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dokumen', function (Blueprint $table) {
            $table->uuid('dokumen_id');
            $table->uuid('pendaftar_id');
            $table->foreignId('komponen_id')->constrained('komponen')->onDelete('cascade');
            $table->string('type');
            $table->string('berkas')->nullable();
            $table->date('tanggal')->nullable();
            $table->text('catatan')->nullable();
            $table->integer('skor')->nullable();
            $table->timestamps();
            $table->primary('dokumen_id');
            $table->foreign('pendaftar_id')->references('pendaftar_id')->on('pendaftar')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dokumen');
    }
}
