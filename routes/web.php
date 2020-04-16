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

    Route::get('incoming_document_users/list_distributed/{incomingDocument}', 'IncomingDocuments\IncomingUserController@listDistributed')->name('incoming_document_users.list_distributed');

    //Журнал регистрации исходящих документов
    Route::resource('outgoing_documents', 'OutgoingDocuments\OutgoingDocumentController');
    Route::post('outgoing_documents/check_number', 'OutgoingDocuments\OutgoingDocumentController@checkNumber')->name('outgoing_documents.check_number');

    //История
    Route::post('activity', 'Activity\ActivityController@index');
    Route::resource('activity', 'Activity\ActivityController')->only([
        'index'
    ]);


	Route::post('incoming_document_users/signed/{incomingDocument}', 'IncomingDocuments\IncomingUserController@signed')->name('incoming_document_users.signed');

	Route::get('incoming_document_users/list_distributed/{incomingDocument}', 'IncomingDocuments\IncomingUserController@listDistributed')->name('incoming_document_users.list_distributed');
	Route::post('incoming_document_users/save_distributed/{incomingDocument}', 'IncomingDocuments\IncomingUserController@saveDistributed')->name('incoming_document_users.save_distributed');
	Route::delete('incoming_document_users/destroy_distributed/{incomingDocumentDistributed}', 'IncomingDocuments\IncomingUserController@destroyDistributed')->name('incoming_document_users.destroy_distributed');

	Route::get('incoming_document_users/list_responsibles/{incomingDocument}', 'IncomingDocuments\IncomingUserController@listResponsibles')->name('incoming_document_users.list_responsibles');
	Route::post('incoming_document_users/save_responsible/{incomingDocument}', 'IncomingDocuments\IncomingUserController@saveResponsible')->name('incoming_document_users.save_responsible');
	Route::delete('incoming_document_users/destroy_responsible/{incomingDocumentResponsible}', 'IncomingDocuments\IncomingUserController@destroyResponsible')->name('incoming_document_users.destroy_responsible');


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

});
