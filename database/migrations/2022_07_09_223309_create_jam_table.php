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
            $table->uuid('sekolah_id')->nullable();
            $table->string('untuk', 3);
            $table->string('nama');
            $table->string('slug');
            $table->decimal('is_libur', 1, 0)->default(0);
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_akhir')->nullable();
            $table->time('scan_masuk_start', 0);
            $table->time('scan_masuk_end', 0);
            $table->time('waktu_akhir_masuk', 0);
            $table->time('scan_pulang_start', 0);
            $table->time('scan_pulang_end', 0);
            $table->timestamps();
            $table->foreign('sekolah_id')->references('sekolah_id')->on('sekolah');
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
