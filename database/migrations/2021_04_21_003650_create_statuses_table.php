<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->timestamps();
        });
        Schema::table('pendaftar', function (Blueprint $table) {
            $table->unsignedBigInteger('status_id')->after('kunci')->nullable();
            $table->foreign('status_id')->references('id')->on('status')->onDelete('cascade');
        });
        Schema::table('dokumen', function (Blueprint $table) {
            $table->unsignedBigInteger('status_id')->after('berkas')->nullable();
            $table->foreign('status_id')->references('id')->on('status')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pendaftar', function (Blueprint $table) {
            $table->dropForeign(['status_id']);
            $table->dropColumn(['status_id']);
        });
        Schema::table('dokumen', function (Blueprint $table) {
            $table->dropForeign(['status_id']);
            $table->dropColumn(['status_id']);
        });
        Schema::dropIfExists('status');
    }
}
