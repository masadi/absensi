<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomNilaiToSekolahPilihanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sekolah_pilihan', function (Blueprint $table) {
            $table->unsignedBigInteger('nilai_mapel')->nullable()->after('usia_ago')->default(0);
            $table->unsignedBigInteger('nilai_usia')->nullable()->after('nilai_mapel')->default(0);
            $table->unsignedBigInteger('nilai_jarak')->nullable()->after('nilai_usia')->default(0);
            $table->unsignedBigInteger('nilai_piagam')->nullable()->after('nilai_jarak')->default(0);
            $table->unsignedBigInteger('nilai_dokumen')->nullable()->after('nilai_piagam')->default(0);
            $table->unsignedBigInteger('nilai_akreditasi')->nullable()->after('nilai_dokumen')->default(0);
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
            $table->dropColumn(['nilai_mapel', 'nilai_usia', 'nilai_jarak', 'nilai_piagam', 'nilai_dokumen', 'nilai_akreditasi']);
        });
    }
}
