<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
// Route::middleware('jwt.auth')->get('users', function (Request $request) {
//     return auth()->user();
// });

Route::get('student', 'IndexController@index');
Route::get('getdata', 'IndexController@view');



//learn jwt auth 
// Route::post('user/register', 'APIRegisterController@register');
// Route::post('user/login', 'APILoginController@login');
// Route::get('user/logout', 'APILoginController@logout');
// Route::group(['middleware' => 'jwt.auth'], function(){
// 	Route::post('auth/logout','APILoginController@logout');
// });
Route::get('allstudent','IndexController@allstudent');
Route::post('register', 'UserController@register');
Route::post('login', 'UserController@login');


Route::get('token', 'UserController@getbearerToken');
Route::get('bear', 'UserController@gettoken');


Route::group(['middleware'=> 'jwt.verify'], function(){
	Route::get('alldata', 'IndexController@view');
	Route::get('user', 'UserController@getAuthenticatedUser');
	Route::get('viewstudent', 'IndexController@view_student');
	Route::get('refresh','UserController@refresh');
	Route::post('student', 'IndexController@create');
	Route::post('/student/edit', 'IndexController@getEdit');
	Route::put('/student/update', 'IndexController@update');
	Route::delete('/student/delete/{id}', 'IndexController@delete');
	Route::post('logout','UserController@logout');
});