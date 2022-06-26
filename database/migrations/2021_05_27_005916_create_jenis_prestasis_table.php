<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJenisPrestasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jenis_prestasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jalur_id')->constrained('jalur')->onDelete('cascade');
            $table->string('nama');
            $table->timestamps();
        });
        Schema::table('sekolah_pilihan', function (Blueprint $table) {
            $table->foreignId('jenis_prestasi_id')->after('pilihan_ke')->nullable()->constrained('jenis_prestasi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sekolah_pilihan', function (Blueprint $table) {
            $table->dropForeign(['jenis_prestasi_id']);
            $table->dropColumn(['jenis_prestasi_id']);
        });
        Schema::dropIfExists('jenis_prestasi');
    }
}
