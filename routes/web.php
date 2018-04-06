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

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return redirect("/payment");
    });

    Route::get('/home', function () {
        return redirect("/payment");
    });

    Route::get('/payment', 'PaymentController@index');
    Route::post('/payment/create', 'PaymentController@create');

    Route::group(['middleware' => ['role:admin']], function() {
        Route::resource('/users', 'UsersController');
    });

});

//Auth::routes();

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');