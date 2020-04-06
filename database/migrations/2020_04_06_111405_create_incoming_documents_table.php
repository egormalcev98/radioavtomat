<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomingDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incoming_documents', function (Blueprint $table) {
            $table->id();
			$table->string('title');
			$table->unsignedTinyInteger('urgent')->nullable()->comment('Срочное');
			$table->string('counterparty');
			$table->unsignedBigInteger('number');
			$table->timestamp('date_letter_at')->nullable()->comment('Дата исходящего письма');
			$table->string('from')->comment('От кого письмо');
			$table->timestamp('date_delivery_at')->nullable()->comment('Дата доставки документа');
			$table->unsignedTinyInteger('original_received')->nullable()->comment('Оригинал документа получен');
			$table->unsignedBigInteger('register');
			$table->unsignedBigInteger('number_pages');
			$table->unsignedBigInteger('recipient_id')->nullable()->comment('Кому адресовано');
			$table->mediumText('note')->nullable();
			$table->unsignedBigInteger('incoming_doc_status_id');
			$table->unsignedBigInteger('document_type_id');
            $table->timestamps();
			$table->softDeletes(); 
			
			$table->foreign('incoming_doc_status_id')->references('id')->on('incoming_doc_statuses');
			$table->foreign('document_type_id')->references('id')->on('document_types');
        });
		
        Schema::create('incoming_document_files', function (Blueprint $table) {
            $table->id();
			$table->string('name')->comment('Оригинальное название');
			$table->string('file_path');
			$table->unsignedBigInteger('incoming_document_id');
            $table->timestamps();
			$table->softDeletes(); 
			
			$table->foreign('incoming_document_id')->references('id')->on('incoming_documents');
        });
		
        Schema::create('incoming_document_users', function (Blueprint $table) {
            $table->id();
			$table->unsignedTinyInteger('type')->comment('Тип: 1-распределенные, 2-ответственные');
			$table->timestamp('sign_up')->comment('Подписать до');
			$table->timestamp('signed_at')->nullable()->comment('Подписан');
			$table->timestamp('reject_at')->nullable()->comment('Отменен');
			$table->string('comment')->nullable();
			$table->unsignedBigInteger('employee_task_id')->nullable();
			$table->unsignedBigInteger('user_id');
			$table->unsignedBigInteger('incoming_document_id');
            $table->timestamps();
			$table->softDeletes(); 
			
			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('incoming_document_id')->references('id')->on('incoming_documents');
        });
		
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incoming_documents');
        Schema::dropIfExists('incoming_document_files');
        Schema::dropIfExists('incoming_document_users');
    }
}
