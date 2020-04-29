<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWithoutDestroyColumnStatusNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('status_notes', function (Blueprint $table) {
            $table->unsignedTinyInteger('without_destroy')->nullable()->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('status_notes', function (Blueprint $table) {
            $table->dropColumn(['without_destroy']);
        });
    }
}
