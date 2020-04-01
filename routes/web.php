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

	Route::get('/home', 'HomeController@index')->name('home');
	
	//Настройки
	Route::resource('settings', 'Settings\SettingsController')->only([
		'index', 'update'
	]);
	
	//Пользователи
	Route::resource('users', 'Settings\UserController');
	Route::get('users/{user}/permissions', 'Settings\UserController@permissions')->name('users.permissions');
	Route::patch('users/permissions_save/{user}', 'Settings\UserController@permissionsSave')->name('users.permissions_save');
});
