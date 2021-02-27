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
});
// Route::get('/login', function () {
//     return view('auth.login');
// });
Route::group(['prefix' => 'admins'], function () {
	Route::get('/login',  function () {	return view('auth.admin_login');
	})->name('admin.login');

	Route::post('/login',  'Admin\AuthController@login');

	Route::get('/register',  function () {
	    return view('auth.admin_register');
	})->name('admin.register');

	Route::post('/register',  'Admin\AuthController@register');
});
	

Auth::routes();
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
Route::resource('admins','Admin\AdminController');
Route::resource('products','Admin\ProductController');
