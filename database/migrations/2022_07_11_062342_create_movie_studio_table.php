<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovieStudioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movie_studio', function (Blueprint $table) {
            $table->unsignedBigInteger('movie_id')->index();
            $table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');

            $table->unsignedBigInteger('studio_id')->index();
            $table->foreign('studio_id')->references('id')->on('studios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movie_studio');
    }
}
