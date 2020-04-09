<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutgoingDocumentFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outgoing_document_files', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Оригинальное название');
            $table->string('file_path');
            $table->unsignedBigInteger('outgoing_document_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('outgoing_document_id')->references('id')->on('outgoing_documents');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('outgoing_document_files');
    }
}
