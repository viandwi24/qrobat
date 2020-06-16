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

Route::get('/', 'HomeController@index')->name('home');
Route::resource('/medicine', 'MedicineController');
Route::resource('/transaction', 'TransactionController');
Route::get('/note', 'NoteController@index')->name('note');
Route::get('/link/{transaction}', 'LinkController@index')->name('link');

Route::get('/login', 'AuthController@login')->name('login');