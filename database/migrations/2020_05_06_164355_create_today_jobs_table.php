<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTodayJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('today_jobs', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->text('allowed_routes')->nullable();
            $table->text('href')->nullable();
            $table->boolean('red')->nullable();
            $table->boolean('missed')->nullable();
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
        Schema::dropIfExists('today_jobs');
    }
}
