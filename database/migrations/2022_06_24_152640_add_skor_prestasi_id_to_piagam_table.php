<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSkorPrestasiIdToPiagamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('piagam', function (Blueprint $table) {
            $table->foreignId('skor_prestasi_id')->after('tingkat_prestasi_id')->nullable()->constrained('skor_prestasi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('piagam', function (Blueprint $table) {
            $table->dropForeign(['skor_prestasi_id']);
            $table->dropColumn(['skor_prestasi_id']);
        });
    }
}
