<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('name', 1024);
            $table->string('origin_name', 1024);
            $table->string('slug')->unique();
            $table->text('content')->nullable();
            $table->string('thumb_url', 2048)->nullable();
            $table->string('poster_url', 2048)->nullable();
            $table->enum('type', ['single', 'series']);
            $table->enum('status', ['trailer', 'ongoing', 'completed']);
            $table->string('trailer_url', 2048)->nullable();
            $table->string('episode_time')->nullable();
            $table->string('episode_current')->nullable();
            $table->string('episode_total')->nullable();
            $table->string('quality')->nullable()->default('HD');
            $table->string('language')->nullable()->default('Vietsub');
            $table->string('notify', 512)->nullable();
            $table->string('showtimes', 512)->nullable();
            $table->integer('publish_year')->index()->nullable();
            $table->boolean('is_shown_in_theater')->default(false);
            $table->boolean('is_recommended')->default(false);
            $table->boolean('is_copyright')->default(false);
            $table->boolean('is_sensitive_content')->default(false);

            $table->integer('episode_server_count')->default(0);
            $table->integer('episode_data_count')->default(0);

            $table->integer('view_total')->default(0);
            $table->integer('view_day')->default(0);
            $table->integer('view_week')->default(0);
            $table->integer('view_month')->default(0);
            $table->integer('rating_count')->default(0);
            $table->decimal('rating_star', 3, 1)->default(0);

            $table->string('update_handler', 1024)->nullable();
            $table->string('update_identity', 2048)->nullable();
            $table->string('update_checksum', 2048)->nullable();

            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('user_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movies');
    }
}
