<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToIncomingDocStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('incoming_doc_statuses', function (Blueprint $table) {
            $table->string('color')->nullable()->after('name');
			$table->unsignedTinyInteger('without_destroy')->nullable()->after('color');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('incoming_doc_statuses', function (Blueprint $table) {
             $table->dropColumn(['color', 'without_destroy']);
        });
    }
}
