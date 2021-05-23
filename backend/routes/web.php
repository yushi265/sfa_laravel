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
    Route::prefix('admin')->name('admin.')->group(function() {
        Route::get('', 'UserController@admin_index')->name('index');
        Route::patch('', 'UserController@admin_set')->name('set');
    });
});

// 管理者以上
Route::group(['middleware' => ['auth', 'can:admin-higher']], function () {
    Route::prefix('customers/')->name('customers.')->group(function () {
        Route::get('create', 'CustomerController@create')->name('create');
        Route::post('', 'CustomerController@store')->name('store');
        Route::get('{customer}/edit', 'CustomerController@edit')->name('edit');
        Route::patch('{customer}', 'CustomerController@update')->name('update');
    });

    Route::prefix('progresses/')->name('progresses.')->group(function () {
        Route::get('{progress}/edit', 'ProgressController@edit')->name('edit');
        Route::patch('{progress}', 'ProgressController@update')->name('update');
        Route::delete('{progress}', 'ProgressController@destroy')->name('destroy');
    });

    Route::prefix('contracts/')->name('contracts.')->group(function () {
        Route::get('create', 'ContractController@create')->name('create');
        Route::post('', 'ContractController@store')->name('store');
        Route::get('{contract}/edit', 'ContractController@edit')->name('edit');
        Route::patch('{contract}', 'ContractController@update')->name('update');
        Route::delete('{contract}', 'ContractController@destroy')->name('destroy');
    });
});

// 全ユーザ
Route::group(['middleware' => ['auth', 'can:user-higher']], function () {
    Route::get('/', 'UserController@home')->name('home');

    Route::prefix('customers/')->name('customers.')->group(function () {
        Route::get('', 'CustomerController@index')->name('index');
        Route::get('{customer}', 'CustomerController@show')->name('show');
    });

    Route::prefix('progresses/')->name('progresses.')->group(function () {
        Route::get('', 'ProgressController@index')->name('index');
        Route::get('create', 'ProgressController@create')->name('create');
        Route::post('', 'ProgressController@store')->name('store');
    });

    Route::prefix('contracts/')->name('contracts.')->group(function () {
        Route::get('', 'ContractController@index')->name('index');
    });

    Route::get('/weathers', 'WeatherController@index')->name('weathers');
});
