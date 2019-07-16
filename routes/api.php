<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');
    Route::post('income_add', 'IncomeController@store');
    Route::get('income_index', 'IncomeController@index');
    Route::get('amountIncome', 'IncomeController@getAmountOfIncome');
    Route::get('income_delete/{income}', 'IncomeController@destroy');
    Route::post('tax_create', 'TaxController@store');
    Route::get('tax_index', 'TaxController@index');
    Route::get('tax_delete/{tax}', 'TaxController@destroy');


});

Route::post('login', 'AuthController@login');
Route::post('/registration', 'AuthController@register')->name('registration');
Route::get('course', 'DollarController@currentСourse');