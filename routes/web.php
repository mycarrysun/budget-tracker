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

Route::group(['middleware' => 'auth'], function () {
    Route::resource('expenses', 'ExpenseController');
    Route::post('expenses/{id}/restore', 'ExpenseController@restore')->name('expenses.restore');

    Route::resource('income', 'IncomeController');
    Route::post('income/{id}/restore', 'IncomeController@restore')->name('income.restore');

    Route::get('projection', 'ProjectionController@index')->name('projection');

    Route::get('projection/stats', 'ProjectionController@stats')->name('projection.stats');
});