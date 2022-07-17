<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrawlSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crawl_schedules', function (Blueprint $table) {
            $table->id();
            $table->text('fields');
            $table->string('type');
            $table->string('link');
            $table->text('exclude_categories')->nullable();
            $table->text('exclude_regions')->nullable();
            $table->integer('from_page')->default(1);
            $table->integer('to_page')->default(1);
            $table->string('at_month',10)->nullable();
            $table->string('at_week',10)->nullable();
            $table->string('at_day',10)->nullable();
            $table->string('at_hour',10)->nullable();
            $table->string('at_minute',10)->nullable();
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
        Schema::dropIfExists('crawl_schedules');
    }
}
