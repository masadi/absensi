<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagu', function (Blueprint $table) {
            $table->uuid('pagu_id');
            $table->uuid('sekolah_id');
            $table->foreignId('jalur_id')->constrained('jalur')->onDelete('cascade');
            $table->integer('jumlah')->nullable()->default(0);
            $table->timestamps();
            $table->primary('pagu_id');
            $table->foreign('sekolah_id')->references('sekolah_id')->on('sekolah')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pagu');
    }
}
