<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('user_id');
            $table->uuid('sekolah_id')->nullable();
            $table->string('name');
            $table->string('username');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('sandi')->nullable();
            $table->rememberToken();
            $table->integer('bentuk_pendidikan_id')->nullable();
            $table->integer('wna')->nullable();
            $table->string('negara_id', 8)->nullable();
            $table->string('provinsi_id', 8)->nullable();
            $table->string('kabupaten_id', 8)->nullable();
            $table->string('kecamatan_id', 8)->nullable();
            $table->string('desa_id', 8)->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('desa')->nullable();
            $table->string('nomor_hp', 16)->nullable();
            $table->string('photo')->nullable();
            $table->string('alamat')->nullable();
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();
            $table->string('nama_ortu')->nullable();
            $table->longText('kebutuhan_khusus')->nullable();
            $table->string('lintang')->nullable();
            $table->string('bujur')->nullable();
            $table->string('jenis_kelamin', 1)->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('skhu')->nullable();
            $table->string('sekolah_asal')->nullable();
            $table->string('akreditasi', 1)->nullable();
            $table->string('ijazah')->nullable();
            $table->timestamps();
            $table->primary('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
