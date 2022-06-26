<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNilaiAkhirToSekolahPilihanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sekolah_pilihan', function (Blueprint $table) {
            $table->unsignedBigInteger('nilai_akhir')->nullable()->after('nilai')->default(0);
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
            $table->dropColumn('nilai_akhir');
        });
    }
}
