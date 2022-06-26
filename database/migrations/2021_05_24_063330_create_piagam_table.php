<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePiagamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('piagam', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tingkat_prestasi_id')->constrained('tingkat_prestasi')->onDelete('cascade');
            $table->foreignId('jalur_id')->constrained('jalur')->onDelete('cascade');
            $table->uuid('pendaftar_id');
            $table->integer('juara');
            $table->date('tanggal')->nullable();
            $table->string('dokumen');
            $table->unsignedInteger('nilai');
            $table->foreignId('status_id')->nullable()->constrained('status')->onDelete('cascade');
            $table->text('catatan')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('piagam');
    }
}
