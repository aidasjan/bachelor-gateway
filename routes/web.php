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
Route::get('login', 'App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'App\Http\Controllers\Auth\LoginController@login');
Route::post('logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');

Route::get('/language/{locale}', 'App\Http\Controllers\LocaleController@changeLocale');

Route::get('/cookies-agree', function () {
    Cookie::queue('cookies_agree', '1', 60*24*365);
    return back();
});
