<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJenisTinggalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jenis_tinggal', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->timestamps();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('jenis_tinggal_id')->after('tanggal_lahir')->nullable();
            $table->foreign('jenis_tinggal_id')->references('id')->on('jenis_tinggal')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['jenis_tinggal_id']);
            $table->dropColumn(['jenis_tinggal_id']);
        });
        Schema::dropIfExists('jenis_tinggal');
    }
}
