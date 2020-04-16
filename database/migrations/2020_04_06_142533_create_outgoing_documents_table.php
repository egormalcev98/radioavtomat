<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutgoingDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outgoing_documents', function (Blueprint $table) {
            $table->id();
            // это в таблице
            $table->unsignedBigInteger('number');
            $table->date('date');
            $table->string('counterparty')->comment('котрагент'); // котрагент
            $table->integer('document_type_id')->comment('вид документа');// вид документа
            $table->integer('from_user_id')->comment('сотрудник отправитель');// сотрудник отправитель
            $table->string('note', 400)->comment('примечания'); // примечания
            $table->integer('outgoing_doc_status_id')->comment('статус'); // статус
            // это добавляется на странице создания и редактирования
            $table->integer('letter_form_id')->comment('бланк письма'); // бланк письма
            $table->string('title'); // заголовок
            $table->unsignedBigInteger('number_pages')->comment(' число страниц'); // число страниц
            $table->unsignedBigInteger('incoming_letter_number')->nullable()->comment('ответ на входящее письмо номер'); // Ответ на входящее письмо номер
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
        Schema::dropIfExists('outgoing_documents');
    }
}
