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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');
//admin routes
Route::group(['prefix' => 'admins'], function () {
	Route::get('/login',  function () {	return view('auth.admin_login');
	})->name('admin.login');

	Route::post('/login',  'Admin\AuthController@login');

	Route::get('/register',  function () {
	    return view('auth.admin_register');
	})->name('admin.register');

	Route::post('/register',  'Admin\AuthController@register');
	Route::post('/logout',  'Admin\AuthController@logout');
});

Route::middleware('auth:admin')->group(function () {
	Route::get('/admins/dashboard', 'Admin\AdminController@index')->name('admin.dashboard');
	Route::resource('products','Admin\ProductController');
});
//users routes
Route::group(['prefix' => 'users'], function () {
	Route::get('/login',  function () {	return view('auth.user_login');
	})->name('user.login');

	Route::post('/login',  'User\AuthController@login');

	Route::get('/register',  function () {
	    return view('auth.user_register');
	})->name('user.register');

	Route::post('/register',  'User\AuthController@register');
	Route::post('/logout',  'User\AuthController@logout');
});
Route::middleware('auth:user')->group(function () {
	Route::get('/users/dashboard', 'User\UserController@index')->name('user.dashboard');
	Route::resource('products','Admin\ProductController');
});
	

// Auth::routes();
