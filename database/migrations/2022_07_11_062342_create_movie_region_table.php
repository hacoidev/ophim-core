<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovieRegionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movie_region', function (Blueprint $table) {
            $table->unsignedBigInteger('movie_id')->index();
            $table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');

            $table->unsignedBigInteger('region_id')->index();
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movie_region');
    }
}
