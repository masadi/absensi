<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSekolahPilihansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sekolah_pilihan', function (Blueprint $table) {
            $table->uuid('sekolah_pilihan_id');
            $table->uuid('pendaftar_id');
            $table->uuid('sekolah_id');
            $table->uuid('verifikator_id')->nullable();
            $table->foreignId('jalur_id')->constrained('jalur')->onDelete('cascade');
            $table->unsignedBigInteger('status_id')->nullable();
            $table->foreign('status_id')->references('id')->on('status')->onDelete('cascade');
            $table->smallInteger('kunci')->nullable()->default(0);
            $table->integer('nilai')->nullable()->default(0);
            $table->string('jarak')->nullable();
            $table->smallInteger('usia')->nullable()->default(0);
            $table->string('akreditasi', 5)->nullable();
            $table->integer('pilihan_ke')->nullable()->default(0);
            $table->smallInteger('tampil')->nullable()->default(0);
            $table->unsignedBigInteger('titipan')->nullable()->default(0);
            $table->timestamps();
            $table->primary('sekolah_pilihan_id');
            $table->foreign('pendaftar_id')->references('pendaftar_id')->on('pendaftar')->onDelete('cascade');
            $table->foreign('sekolah_id')->references('sekolah_id')->on('sekolah')->onDelete('cascade');
            $table->foreign('verifikator_id')->references('user_id')->on('users')->onDelete('cascade');
        });
        Schema::table('dokumen', function (Blueprint $table) {
            $table->uuid('sekolah_pilihan_id')->after('pendaftar_id');
            $table->foreign('sekolah_pilihan_id')->references('sekolah_pilihan_id')->on('sekolah_pilihan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dokumen', function (Blueprint $table) {
            $table->dropForeign(['sekolah_pilihan_id']);
            $table->dropColumn(['sekolah_pilihan_id']);
        });
        Schema::dropIfExists('sekolah_pilihan');
    }
}
