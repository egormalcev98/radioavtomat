<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Authentication Routes...
Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/', 'Auth\LoginController@login');

Route::group(['middleware' => ['auth']], function () {

	Route::post('logout', 'Auth\LoginController@logout')->name('logout');

	Route::get('home', 'HomeController@index')->name('home');


	//Настройки
	Route::resource('settings', 'Settings\SettingsController')->only([
		'index', 'update'
	]);

	//Пользователи
	Route::resource('users', 'Settings\UserController');
	Route::get('users/{user}/permissions', 'Settings\UserController@permissions')->name('users.permissions');
	Route::patch('users/permissions_save/{user}', 'Settings\UserController@permissionsSave')->name('users.permissions_save');

	//Журнал регистрации входящих документов
	Route::get('incoming_documents/print', 'IncomingDocuments\IncomingDocumentController@printExcel')->name('incoming_documents.print');
	Route::resource('incoming_documents', 'IncomingDocuments\IncomingDocumentController');
	Route::post('incoming_documents/check_number', 'IncomingDocuments\IncomingDocumentController@checkNumber')->name('incoming_documents.check_number');
    Route::get('incoming_documents_get_documents', 'IncomingDocuments\IncomingDocumentController@getDocuments')->name('incoming_documents.get_documents');
	Route::post('incoming_document_users/signed/{incomingDocument}', 'IncomingDocuments\IncomingUserController@signed')->name('incoming_document_users.signed');

	Route::get('incoming_document_users/list_distributed/{incomingDocument}', 'IncomingDocuments\IncomingUserController@listDistributed')->name('incoming_document_users.list_distributed');
	Route::post('incoming_document_users/save_distributed/{incomingDocument}', 'IncomingDocuments\IncomingUserController@saveDistributed')->name('incoming_document_users.save_distributed');
	Route::delete('incoming_document_users/destroy_distributed/{incomingDocumentDistributed}', 'IncomingDocuments\IncomingUserController@destroyDistributed')->name('incoming_document_users.destroy_distributed');

	Route::get('incoming_document_users/list_responsibles/{incomingDocument}', 'IncomingDocuments\IncomingUserController@listResponsibles')->name('incoming_document_users.list_responsibles');
	Route::post('incoming_document_users/save_responsible/{incomingDocument}', 'IncomingDocuments\IncomingUserController@saveResponsible')->name('incoming_document_users.save_responsible');
	Route::delete('incoming_document_users/destroy_responsible/{incomingDocumentResponsible}', 'IncomingDocuments\IncomingUserController@destroyResponsible')->name('incoming_document_users.destroy_responsible');

    //Журнал регистрации исходящих документов
    Route::get('outgoing_documents/print', 'OutgoingDocuments\OutgoingDocumentController@printExcel')->name('outgoing_documents.print');
    Route::resource('outgoing_documents', 'OutgoingDocuments\OutgoingDocumentController');
    Route::post('outgoing_documents/check_number', 'OutgoingDocuments\OutgoingDocumentController@checkNumber')->name('outgoing_documents.check_number');

    //История
    Route::post('activity', 'Activity\ActivityController@index');
    Route::resource('activity', 'Activity\ActivityController')->only([
        'index'
    ]);

	//Отчеты
	Route::get('reports', 'Reports\ReportController@index')->name('reports.index');

	//Справочники
	Route::resource('document_types', 'References\DocumentTypeController')->except([
		'show', 'edit'
	]);
	Route::resource('incoming_doc_statuses', 'References\IncomingDocStatusController')->except([
		'show', 'edit'
	]);
	Route::resource('outgoing_doc_statuses', 'References\OutgoingDocStatusController')->except([
		'show', 'edit'
	]);
	Route::resource('employee_tasks', 'References\EmployeeTaskController')->except([
		'show', 'edit'
	]);
	Route::resource('letter_forms', 'References\LetterFormController')->except([
		'show', 'edit'
	]);
	Route::resource('task_statuses', 'References\TaskStatusController')->except([
		'show', 'edit'
	]);
	Route::resource('event_types', 'References\EventTypeController')->except([
		'show', 'edit'
	]);
	Route::resource('category_notes', 'References\CategoryNoteController')->except([
		'show', 'edit'
	]);
	Route::resource('status_notes', 'References\StatusNoteController')->except([
		'show', 'edit'
	]);
	Route::resource('user_statuses', 'References\UserStatusController')->only([
		'index', 'update'
	]);
	Route::resource('structural_units', 'References\StructuralUnitController')->only([
		'index', 'update'
	]);
	Route::resource('roles', 'References\RoleController')->only([
		'index', 'update'
	]);

	//Чат
	Route::post('chat/send_message', 'Chat\ChatController@sendMessage')->name('chat.send_message');
	Route::post('chat/select_channel', 'Chat\ChatController@selectChannel')->name('chat.select_channel');
	Route::post('chat/read_msg', 'Chat\ChatController@readMessages')->name('chat.read_msg');

    //Служебные записки
    Route::resource('notes', 'Notes\NoteController');

	// Задачи
    Route::resource('tasks', 'Tasks\TaskController')->names('tasks');
    Route::post('/tasks_store_task', 'Tasks\TaskController@storeTask')->name('tasks.store_task');
    Route::post('/tasks_store_order', 'Tasks\TaskController@storeOrder')->name('tasks.store_order');
    Route::post('/tasks_update_task/{task}', 'Tasks\TaskController@updateTask')->name('tasks.update_task');
    Route::post('/tasks_update_order/{task}', 'Tasks\TaskController@updateOrder')->name('tasks.update_order');
    Route::get('/get_tasks', 'Tasks\TaskController@getTasks')->name('tasks.get');
    Route::get('/task_info/{task}', 'Tasks\TaskController@taskInfo')->name('tasks.info');
    Route::post('/task_get_weeks', 'Tasks\TaskController@getWeeks')->name('tasks.get_weeks');
    Route::get('/task_do_completed/{task}', 'Tasks\TaskController@doCompleted')->name('tasks.do_completed'); // это чтобы отмечать что уведомление о задачи просмотрено

});
