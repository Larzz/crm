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
            Route::get('all-bulletin', 'BulletinController@getAllBulletin')->name('api.bulletin.get.all');
            Route::post('/', 'BulletinController@addBulletin')->name('api.bulletin.create');
            Route::get('/', 'BulletinController@getBulletins')->name('api.bulletin.get');
            Route::get('{id}', 'BulletinController@getBulletin')->name('api.bulletin.specific');
            Route::put('{id}', 'BulletinController@editBulletin')->name('api.bulletin.edit');
            Route::delete('{id}', 'BulletinController@deleteBulletin')->name('api.bulletin.delete');
            Route::post('{id}/post', 'BulletinController@postBulletin')->name('api.bulletin.specific');

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
            Route::post('{id}', 'ClientController@editClient');
            Route::delete('{id}', 'ClientController@deleteClient');
        });

        Route::prefix('documents')->group(function() {
            Route::post('{id}', 'DocumentController@addDocument');
            Route::post('upload/docs', 'DocumentController@uploadDocument');
            Route::get('{id}', 'DocumentController@getDocuments');
            Route::get('types/docs', 'DocumentController@getDocumentTypes');
            // Route::get('{id}', 'DocumentController@getDocument');
            Route::patch('{id}', 'DocumentController@editDocument');
            Route::delete('{id}', 'DocumentController@deleteDocument');
            Route::get('expiration', 'DocumentController@deleteExpiration');
        });

        Route::prefix('tutorials')->group(function() {
            Route::post('/', 'TutorialController@addTutorial');
            Route::get('/', 'TutorialController@getTutorials');
            Route::get('{id}', 'TutorialController@getTutorial');
            Route::delete('{id}', 'TutorialController@deleteTutorial');
        }); 

        Route::prefix('presentations')->group(function() {
            Route::post('{client_id}', "PresentationController@addPresentation");
            Route::get('{client_id}', 'PresentationController@getPresentation');
            Route::post('upload', 'PresentationController@uploadPresentation');
            Route::delete('{presentation_id}/client/{client_id}', 'PresentationController@deletePresentation');
            Route::patch('{presentation_id}/client/{client_id}', 'PresentationController@updatePresentation');
        });

        Route::prefix('meetings')->group(function() {
            Route::post('{client_id}', 'MeetingController@addMeeting');
            Route::get('{client_id}', 'MeetingController@getMeeting');
            Route::delete('{client_id}/client/{meeting_id}', 'MeetingController@deleteMeeting');
            Route::patch('{client_id}/client/{meeting_id}', 'MeetingController@updateMeeting');
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
            Route::get('{newsletter_id}', 'NewsletterController@getNewsletter');
            Route::delete('{newsletter_id}', 'NewsletterController@deleteNewsletter');
        });

        Route::prefix('employee-staff')->group(function() {
            Route::patch('{employee_id}', 'EmployeeController@UpdateEmployee');
        });

        Route::prefix('tools')->group(function() {
            Route::post('/', "ToolController@addTool");
            Route::get('/', 'ToolController@getTools');
            Route::post('{id}', 'ToolController@editTool');
            Route::delete('{tool_id}', 'ToolController@deleteTool');
        });

    });

});

