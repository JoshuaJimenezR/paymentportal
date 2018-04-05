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

    Route::get('/payment', 'PaymentController@index');
    Route::post('/payment/create', 'PaymentController@create');

    Route::resource('/users', 'UsersController');

});

Auth::routes();