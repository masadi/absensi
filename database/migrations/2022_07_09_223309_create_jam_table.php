<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jam', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained('kategori');
            //$table->decimal('aktif_jam', 1, 0);
            $table->time('scan_masuk_start', 0);
            $table->time('scan_masuk_end', 0);
            $table->time('waktu_akhir_masuk', 0);
            $table->time('scan_pulang_start', 0);
            $table->time('scan_pulang_end', 0);
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
        Schema::dropIfExists('jam');
    }
}
