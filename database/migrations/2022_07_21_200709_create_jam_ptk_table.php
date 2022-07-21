<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJamPtkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jam_ptk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jam_id')->constrained('jam')->onUpdate('cascade')->onDelete('cascade');
            $table->uuid('ptk_id');
            $table->timestamps();
            $table->foreign('ptk_id')->references('ptk_id')->on('ptk')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jam_ptk');
    }
}
