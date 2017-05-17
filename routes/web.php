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
	Route::resource('services',		'ServicesController');
	Route::resource('users',		'UsersController');

	Route::get('settings',	'SettingsController@edit')->name('settings');
	Route::post('settings',	'SettingsController@update');
});

Route::group(['prefix' => 'cas', 'namespace' => 'Cas', 'as' => 'cas.'], function() {
	Route::get('login',				'LoginController@login')->name('login');
	Route::post('login',			'LoginController@postLogin');
	Route::get('logout',			'LoginController@logut')->name('logout');

	Route::get('validate',			'CasController@validate');
	Route::get('serviceValidate',	'CasController@serviceValidate');
	Route::get('proxyValidate',		'CasController@proxyValidate');
	Route::get('proxy',				'CasController@proxy');

	/* To be Implement
	Route::group(['prefix' => 'p3', 'as' => 'p3'], function() {
		Route::get('serviceValidate',	'CasP3Controller@serviceValidate');
		Route::get('proxyValidate',		'CasP3Controller@proxyValidate');
	});*/
});

Route::get('login', 'HomeController@login')->name('login');
Route::get('logout', 'HomeController@logout')->name('logout');
Route::get('/', 'HomeController@index')->name('root');
