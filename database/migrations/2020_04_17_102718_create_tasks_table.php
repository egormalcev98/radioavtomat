<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->text('text')->nullable();
            $table->dateTime('start');
            $table->dateTime('end');
            $table->unsignedInteger('incoming_document_id')->nullable();
            $table->string('file_path')->nullable();
            $table->unsignedInteger('task_status_id')->nullable();
            $table->unsignedInteger('event_type_id')->nullable();
            $table->integer('remember_time')->nullable()->comment('за сколько минут напомнить');;
            $table->unsignedInteger('creator_id');
            $table->timestamps();
			$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('task_user');
    }
}
