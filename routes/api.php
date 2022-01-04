<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('API')->group(function() {

    Route::prefix('v1')->namespace('v1')->middleware('auth:api')->group(function() {

        Route::prefix('bulletin')->namespace('Administrator')->group(function() {
            Route::post('/', 'BulletinController@addBulletin')->name('api.bulletin.create');
            Route::get('/', 'BulletinController@getBulletins')->name('api.bulletin.get');
            Route::get('{id}', 'BulletinController@getBulletin')->name('api.bulletin.specific');
            Route::patch('{id}', 'BulletinController@editBulletin')->name('api.bulletin.edit');
            Route::delete('{id}', 'BulletinController@deleteBulletin')->name('api.bulletin.delete');
        });
    
    });

});

