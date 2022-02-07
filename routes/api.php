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

        Route::prefix('notes')->namespace('Administrator')->group(function() {
            Route::post('{user_id}', 'NotesController@addNotes');
            Route::get('{user_id}', 'NotesController@getNotesByUserId');
            Route::delete('{note_id}', 'NotesController@deleteNotes');
            Route::patch('{note_id}', 'NotesController@updateNotes');
        });

        Route::prefix('leave')->group(function() {
            Route::post('/', 'LeaveController@addLeave');
            Route::get('/', 'LeaveController@getLeaves');
            Route::get('{id}', 'LeaveController@getLeave');
            Route::patch('{id}', 'LeaveController@editLeave');
            Route::delete('{id}', 'LeaveController@deleteLeave');
            Route::post('approved', 'LeaveController@approved');
            Route::post('declined', 'LeaveController@declined');
        });

        Route::prefix('employee')->namespace('Administrator')->group(function() {
            Route::post('/', 'EmployeeController@addEmployee');
            Route::get('/', 'EmployeeController@getEmployees');
            Route::get('{id}', 'EmployeeController@getEmployee');
            Route::patch('{id}', 'EmployeeController@editEmployee');
            Route::delete('{id}', 'EmployeeController@deleteEmployee');
        });

        Route::prefix('client')->group(function() {
            Route::post('/', 'ClientController@addClient');
            Route::get('/', 'ClientController@getClients');
            Route::get('{id}', 'ClientController@getClient');
            Route::patch('{id}', 'ClientController@editClient');
            Route::delete('{id}', 'ClientController@deleteClient');
        });

        Route::prefix('documents')->group(function() {
            Route::post('/', 'DocumentController@addDocument');
            Route::post('upload/docs', 'DocumentController@uploadDocument');
            Route::get('/', 'DocumentController@getDocuments');
            Route::get('type', 'DocumentController@getDocumentTypes');
            Route::get('{id}', 'DocumentController@getDocument');
            Route::patch('{id}', 'DocumentController@editDocument');
            Route::delete('{id}', 'DocumentController@deleteDocument');
        });

        Route::prefix('tutorials')->group(function() {
            Route::post('/', 'TutorialController@addTutorial');
            Route::get('/', 'TutorialController@getTutorials');
            Route::get('{id}', 'TutorialController@getTutorial');
            Route::delete('{id}', 'TutorialController@deleteTutorial');
        }); 

        Route::prefix('presentations')->group(function() {
            Route::post('/', "PresentationController@addPresentation");
            Route::get('/', 'PresentationController@getAllPresentation');
        });

        Route::prefix('website')->group(function() {
            Route::post('/', "WebsiteController@saveDomain");
            Route::get('/', 'WebsiteController@getAllDomain');
            Route::get('{id}', 'WebsiteController@getDomain');
            Route::delete('{id}', 'WebsiteController@deleteDomain');
        });

        Route::prefix('newsletter')->group(function() {
            Route::post('/', 'NewsletterController@saveNewsletter');
            Route::get('/', 'NewsletterController@getAllNewsletter');
            Route::get('{id}', 'NewsletterController@getNewsletter');
            Route::delete('{id}', 'NewsletterController@deleteNewsletter');
        });

    });

});

