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

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;

Route::get('/', 'App\Http\Controllers\CompanyController@index');
Route::get('login', 'App\Http\Controllers\LoginController@showLoginForm')->name('login');
Route::post('login', 'App\Http\Controllers\LoginController@login');
Route::post('logout', 'App\Http\Controllers\LoginController@logout')->name('logout');
Route::get('dashboard', 'App\Http\Controllers\DashboardController@index')->name('dashboard');

Route::get('password', 'App\Http\Controllers\UsersController@password')->name('users.password');
Route::post('password', 'App\Http\Controllers\UsersController@passwordChange')->name('users.passwordchange');
Route::get('passwordresetrequest', 'App\Http\Controllers\UsersController@showPasswordReset')->name('users.showpasswordreset');
Route::post('passwordresetrequest', 'App\Http\Controllers\UsersController@sendPasswordReset')->name('users.sendpasswordreset');
Route::get('passwordreset/{token}', 'App\Http\Controllers\UsersController@resetPassword')->name('users.resetpassword');
Route::get('users/{user}/edit', 'App\Http\Controllers\UsersController@edit')->name('users.edit');
Route::put('users/{user}', 'App\Http\Controllers\UsersController@update')->name('users.update');
Route::delete('users/{order}', 'App\Http\Controllers\UsersController@destroy')->name('users.destroy');

Route::get('/language/{locale}', 'App\Http\Controllers\LocaleController@changeLocale');

Route::get('/cookies-agree', function () {
    Cookie::queue('cookies_agree', '1', 60*24*365);
    return back();
});
