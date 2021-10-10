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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::post('/upload', 'Auth\RegisterController@imageUpload')->name('ajaxupload.submit');
Route::post('/profileupload', 'UserController@imageUpload')->name('user.profile.submit');
Route::get('/verifyemail/{token}', 'Auth\RegisterController@verify');

Route::get('/sendMail', 'Auth\RegisterController@checkMail');
Route::get('/add-user', 'UserController@addUser')->name('user.add');
Route::post('/add-user', 'UserController@create')->name('user.create');
Route::get('/user-list', 'UserController@show')->name('user.show');
Route::get('/edit-user', 'UserController@edit')->name('user.edit');
Route::get('/dashboard', 'UserController@dashboard');
Route::get('/', 'UserController@dashboard');
Route::get('/editprofile/{id}', 'UserController@profile');
Route::post('/editprofile/{id}', 'UserController@updateProfile');
Route::post('/delete-user/{id}', 'UserController@deleteUser');
Route::get('/test', 'Auth\RegisterController@test');
