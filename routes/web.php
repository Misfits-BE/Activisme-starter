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

// Policy pages
Route::get('privacy-policy', 'Frontend\PolicyController@privacy')->name('policy.privacy');

// Users Routes
Route::get('/admin/users', 'Backend\UsersController@index')->name('admin.users.index');
Route::get('/admin/users/create', 'Backend\UsersController@create')->name('admin.users.create');
Route::post('/admin/users/store', 'Backend\UsersController@store')->name('admin.users.store');

// Backend fragment routes
Route::get('/admin/fragments', 'Backend\FragmentController@index')->name('admin.fragments.index');