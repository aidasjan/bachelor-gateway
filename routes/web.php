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

Route::get('/', 'App\Http\Controllers\CompaniesController@index');
Route::get('login', 'App\Http\Controllers\LoginController@showLoginForm')->name('login');
Route::post('login', 'App\Http\Controllers\LoginController@login');
Route::post('logout', 'App\Http\Controllers\LoginController@logout')->name('logout');
Route::get('dashboard', 'App\Http\Controllers\DashboardController@index')->name('dashboard');

Route::get('password', 'App\Http\Controllers\UsersController@password')->name('users.password');
Route::post('password', 'App\Http\Controllers\UsersController@passwordChange')->name('users.passwordchange');
Route::get('passwordresetrequest', 'App\Http\Controllers\UsersController@showPasswordReset')->name('users.showpasswordreset');
Route::post('passwordresetrequest', 'App\Http\Controllers\UsersController@sendPasswordReset')->name('users.sendpasswordreset');
Route::get('passwordreset/{token}', 'App\Http\Controllers\UsersController@resetPassword')->name('users.resetpassword');

Route::get('users', 'App\Http\Controllers\UsersController@index')->name('users.index');
Route::get('users/create', 'App\Http\Controllers\UsersController@create')->name('users.create');
Route::post('users', 'App\Http\Controllers\UsersController@store')->name('users.store');
Route::get('users/{user}/edit', 'App\Http\Controllers\UsersController@edit')->name('users.edit');
Route::put('users/{user}', 'App\Http\Controllers\UsersController@update')->name('users.update');
Route::delete('users/{user}', 'App\Http\Controllers\UsersController@disable')->name('users.disable');

Route::get('companies/create', 'App\Http\Controllers\CompaniesController@create')->name('companies.create');
Route::post('companies', 'App\Http\Controllers\CompaniesController@store')->name('companies.store');
Route::get('companies/{user}/edit', 'App\Http\Controllers\CompaniesController@edit')->name('companies.edit');
Route::put('companies/{user}', 'App\Http\Controllers\CompaniesController@update')->name('companies.update');
Route::delete('companies/{user}', 'App\Http\Controllers\CompaniesController@disable')->name('companies.disable');

Route::get('/language/{locale}', 'App\Http\Controllers\LocaleController@changeLocale');

Route::get('/cookies-agree', function () {
    Cookie::queue('cookies_agree', '1', 60*24*365);
    return back();
});

Route::get('/privacy-policy', function () {
    return view('pages.privacy')->with('pageName', 'Privacy Policy');
});
