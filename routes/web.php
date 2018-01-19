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

Route::get('/login', 'IndieAuthController@showLoginForm');
Route::post('/login', 'IndieAuthController@login')->name('login');
Route::get('/login/callback', 'IndieAuthController@callback')->name('login-callback');
Route::post('/logout', 'IndieAuthController@logout')->name('logout');

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
Route::get('/dashboard/settings', 'DashboardController@settings')->name('settings');
Route::post('/dashboard/settings/query', 'DashboardController@queryEndpoint')->name('micropub-query');

Route::get('/note', 'ClientController@note')->name('note');

Route::post('/post/note', 'BackendController@note')->name('post-note');
