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


Route::get('/', 'MainController@index');

Route::post('/login', 'LoginController@authenticate');

Route::get('/logout', 'LoginController@logout');

Route::get('/register-form', 'UsersController@showRegisterForm');

Route::post('/register', 'UsersController@register');

Route::get('/withdraw-form', 'WithdrawController@showWithdrawForm');

Route::post('/withdraw', 'WithdrawController@createWithdrawRequest');

Route::get('/investiment-form', 'InvestimentController@showInvestimentForm');

Route::post('/investiment', 'InvestimentController@createInvestimentRequest');

Route::get('/reinvestment-form', 'ReinvestmentController@showReinvestmentForm');

Route::post('/reinvestment', 'ReinvestmentController@createReinvestmentRequest');

Route::get('/bankdata-form', 'BankDataController@showBankDataForm');

Route::post('/updatebankdata', 'BankDataController@updateBankData');

/*
Route::get('/', function () {
    return MainController::;
});

*/
