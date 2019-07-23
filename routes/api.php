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
    Route::get('amount_income', 'IncomeController@getIncomeAmount');
    Route::post('income_update/{income}', 'IncomeController@update');
    Route::get('income_delete/{income}', 'IncomeController@destroy');
    Route::post('tax_create', 'TaxController@store');
    Route::get('tax_index', 'TaxController@index');
    Route::get('list_of_tax', 'TaxController@getTaxForSidebar');
    Route::post('tax_update/{tax}', 'TaxController@update');
    Route::get('tax_delete/{tax}', 'TaxController@destroy');
    Route::get('amount_tax', 'TaxController@getTaxAmount');
    Route::post('upload', 'UserFileController@upload');
    Route::get('file_index', 'UserFileController@index');
    Route::post('file_upload', 'UserFileController@upload');


});

Route::post('login', 'AuthController@login');
Route::post('/registration', 'AuthController@register')->name('registration');
Route::get('course', 'ExchangeController@getCurrentСourse');
Route::post('forgot', 'AuthController@forgot');
Route::post('reset-password', 'AuthController@forgot');
Route::post('reset/password', 'AuthController@callResetPassword');