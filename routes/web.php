<?php

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

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'as' => '.admin'], function() {
	Route::resource('groups',		'GroupsController');
	Route::resource('roles',		'RolesController');
	Route::resource('permissions',	'PermissionsController');
	Route::resource('services',		'ServicesController');
	Route::resource('users',		'UsersController');

	Route::get('settings',	'SettingsController@edit')->name('settings');
	Route::post('settings',	'SettingsController@update');
});

Route::group(['prefix' => 'cas', 'as' => 'cas.'], function() {
	Route::get('login',				'CasController@login')->name('login');
	Route::post('login',			'CasController@postLogin');
	Route::get('logout',			'CasController@logut')->name('logout');
	Route::get('validate',			'CasController@validate');
	Route::get('serviceValidate',	'CasController@serviceValidate');
	Route::get('proxyValidate',		'CasController@proxyValidate');
	Route::get('proxy',				'CasController@proxy');

	Route::group(['prefix' => 'p3', 'as' => 'p3'], function() {
		Route::get('serviceValidate',	'CasP3Controller@serviceValidate');
		Route::get('proxyValidate',		'CasP3Controller@proxyValidate');
	});
});

Route::get('/', function() {
	return redirect()->route('cas.login');
});
