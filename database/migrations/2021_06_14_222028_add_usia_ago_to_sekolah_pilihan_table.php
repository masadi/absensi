<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsiaAgoToSekolahPilihanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('usia_ago')->nullable()->after('usia')->default(0);
        });
        Schema::table('sekolah_pilihan', function (Blueprint $table) {
            $table->unsignedBigInteger('usia_ago')->nullable()->after('jarak_int')->default(0);
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
            $table->dropColumn('usia_ago');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('usia_ago');
        });
    }
}
