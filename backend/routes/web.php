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

use App\Http\Controllers\CustomerController;


Auth::routes();

// システム管理者のみ
Route::group(['middleware' => ['auth', 'can:system-only']], function () {
    Route::get('/admin', 'UserController@admin_index');
    Route::patch('/admin', 'UserController@admin_set');
});

// 管理者以上
Route::group(['middleware' => ['auth', 'can:admin-higher']], function () {
    Route::prefix('customers/')->group(function () {
        Route::get('create', 'CustomerController@create');
        Route::post('', 'CustomerController@store');
        Route::get('{customer}/edit', 'CustomerController@edit');
        Route::patch('{customer}', 'CustomerController@update');
    });

    Route::prefix('progresses/')->group(function () {
        Route::get('{progress}/edit', 'ProgressController@edit');
        Route::patch('{progress}', 'ProgressController@update');
        Route::delete('{progress}', 'ProgressController@destroy');
    });

    Route::prefix('contracts/')->group(function () {
        Route::get('create', 'ContractController@create');
        Route::post('', 'ContractController@store');
        Route::get('{contract}/edit', 'ContractController@edit');
        Route::patch('{contract}', 'ContractController@update');
        Route::delete('{contract}', 'ContractController@destroy');
    });
});

// 全ユーザ
Route::group(['middleware' => ['auth', 'can:user-higher']], function () {
    Route::get('/', 'UserController@home');

    Route::prefix('customers/')->group(function () {
        Route::get('', 'CustomerController@index');
        Route::get('{customer}', 'CustomerController@show');
        Route::get('', 'CustomerController@search');
    });

    Route::prefix('progresses/')->group(function () {
        Route::get('', 'ProgressController@index');
        Route::get('create', 'ProgressController@create');
        Route::post('', 'ProgressController@store');
        Route::get('', 'ProgressController@search');
    });

    Route::prefix('contracts/')->group(function () {
        Route::get('', 'ContractController@index');
        Route::get('', 'ContractController@search');
    });

    Route::get('/weathers', 'WeatherController@index');
});
