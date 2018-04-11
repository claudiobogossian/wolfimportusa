<?php

use Illuminate\Support\Facades\Mail;

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

Route::get('/reset-password', 'UsersController@resetPassword');

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

Route::get('/history', 'HistoryController@showHistory');

Route::post('/updateuser', 'UsersController@update');

Route::get('/manage-requests', 'AdminController@manageRequests');

Route::post('/updaterequest', 'AdminController@updateRequest');

Route::get('/showForgetPassword', 'LoginController@showForgetPassword');

Route::post('/forgetPassword', 'LoginController@forgetPassword');

Route::get('/deleteUser', 'AdminController@deleteUser');






Route::get('/migrate', function () {
    $migrate = Artisan::call('migrate');
    echo "DB Migrated <br>";
});
    
    
Route::get('/migrate-reset', function () {
    $migrate = Artisan::call('migrate:reset');
    echo "DB Migrated <br>";
});

    Route::get('/calculate-balance', function () {
        $migrate = Artisan::call('calculate:balance');
        echo "Calculated balance <br>";
    });
    
    


/*
Route::get('/', function () {
    return MainController::;
});

*/
