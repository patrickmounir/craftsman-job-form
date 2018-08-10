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
Route::group(['prefix' => 'job-requests'], function () {
    Route::post('/', 'JobRequestController@store')->name('createJobRequest');

    Route::get('/', 'JobRequestController@index')->name('listJobRequests');

    Route::get('/my', 'JobRequestController@myRequests')->name('listMyRequests');

    Route::get("/{jobRequest}", 'JobRequestController@show')->name('showRequest');
});

Route::get('/services', 'ServiceController@index')->name('listServices');
