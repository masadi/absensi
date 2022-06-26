<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendaftarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pendaftar', function (Blueprint $table) {
            $table->uuid('pendaftar_id');
            $table->uuid('user_id');
            $table->integer('bentuk_pendidikan_id');
            //$table->uuid('pilihan_1')->nullable();
            //$table->uuid('pilihan_2')->nullable();
            $table->string('nomor_pendaftaran');
            $table->string('jenis_kelamin', 1);
            $table->smallInteger('kunci')->nullable()->default(0);
            $table->timestamps();
            $table->primary('pendaftar_id');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            //$table->foreign('pilihan_1')->references('sekolah_id')->on('sekolah')->onDelete('cascade');
            //$table->foreign('pilihan_2')->references('sekolah_id')->on('sekolah')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pendaftar');
    }
}
