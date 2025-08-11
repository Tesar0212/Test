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
    return redirect()->route('login');
});

// Auth routes (no external packages)
Route::middleware('guest')->group(function () {
    Route::get('/login', 'AuthController@showLoginForm')->name('login');
    Route::post('/login', 'AuthController@login')->name('login.attempt');
    Route::get('/register', 'AuthController@showRegisterForm')->name('register');
    Route::post('/register', 'AuthController@register')->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', 'AuthController@logout')->name('logout');
    Route::get('/home', function () { return redirect()->route('profile'); })->name('home');
    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::get('/profile/data', 'ProfileController@data')->name('profile.data');
    Route::post('/profile', 'ProfileController@update')->name('profile.update');
});
