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

Route::get('/', 'HomeController@index')->name('home');

Route::post('/login', 'IndieAuthController@login')->name('login');
Route::get('/login/callback', 'IndieAuthController@callback')->name('login-callback');

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
