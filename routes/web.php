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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/about', function(){
	return "Hello World";
});
Route::get('student/view', 'IndexController@view');
Route::get('/', 'IndexController@index');

// Route::get('edit/{$id}', 'IndexController@edit');
Route::get('/adddata', 'IndexController@add');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
