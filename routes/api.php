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

Route::group(['middleware' => 'api'], function ($router) {
    Route::get('bbb/create', 'BigBluButtonController@createRoom');
    Route::get('bbb/join', 'BigBluButtonController@joinRoom');
    Route::get('bbb/info', 'BigBluButtonController@getRoomInfo');
    Route::get('bbb/list', 'BigBluButtonController@getListRoom');
    Route::get('bbb/end', 'BigBluButtonController@endRoom');
    Route::get('bbb/record', 'BigBluButtonController@getRecords');
    Route::get('bbb/record/delete', 'BigBluButtonController@deleteRecord');
    Route::get('testMail', 'AuthController@testMail');
    Route::get('checkip', 'AuthController@checkIp');

    Route::get('active/payment/{code}', 'UserController@activePayment');
    Route::get('viewMail', 'AuthController@viewMail');

    Route::get('account/activate/{key}', 'AuthController@activeAccount');
    Route::post('bbb/web-hook', 'BigBluButtonController@webHook');

    Route::prefix('room')->group(function () {
        Route::get('info/{code}', 'RoomsController@infoByCode');
        Route::post('join', 'RoomsController@joinRoom');
        Route::get('trial', 'RoomsController@trialRoom');
    });

    Route::prefix('test')->group(function () {
        Route::get('info/{code}', 'TestsController@infoByCode');
        Route::post('join', 'TestsController@joinTest');
        Route::get('session-info/{code}', 'TestsController@infoSessionByCode');
        Route::get('session-quiz/{test_id}', 'TestsController@getQuizSessionByTest');
    });

    Route::prefix('auth')->group(function () {
        Route::post('login', 'AuthController@login');
        Route::post('register', 'AuthController@register');
        Route::post('forgot-password', 'AuthController@forgotPassword');
        Route::post('reset-password', 'AuthController@resetPassword');
        Route::post('resend-active', 'AuthController@resendActive');
    });
    Route::prefix('law')->group(function () {
        Route::post('list', 'LawController@list');
        Route::post('item/detail', 'LawController@getItemDetail');
    });
    Route::group(['middleware' => 'jwt.auth'], function ($router) {
        Route::post('auth/logout', 'AuthController@logout');
        Route::prefix('user')->group(function () {
            Route::post('update-info', 'UserController@updateInfo');
            Route::post('change-password', 'UserController@changePassword');
            Route::post('contact', 'UserController@addContact');
            Route::post('payment-add', 'UserController@addPayment');
            Route::post('payment-transfer', 'UserController@transferPayment');
            Route::post('payments', 'UserController@listPayment');
            Route::get('payments/{id}', 'UserController@getDetailPayment');
        });
        Route::prefix('rooms')->group(function () {
            Route::post('create', 'RoomsController@create');
            Route::post('update', 'RoomsController@update');
            Route::post('list', 'RoomsController@list');
            Route::get('info/{id}', 'RoomsController@info');
            Route::get('slides/{id}', 'RoomsController@getSlides');
            Route::get('slides-delete/{id}', 'RoomsController@deleteSlide');
            Route::post('upload-file', 'RoomsController@uploadFile');
            Route::post('remove-pass', 'RoomsController@removePass');
            Route::post('gen-pass', 'RoomsController@genPass');
            Route::get('room-delete/{id}', 'RoomsController@deleteRoom');
            Route::post('sessions/{id}', 'RoomsController@getSessions');
        });
        Route::prefix('records')->group(function () {
            Route::post('list', 'RecordsController@list');
            Route::get('delete/{id}', 'RecordsController@delete');
        });

        Route::prefix('quizs')->group(function () {
            Route::post('subjects', 'QuizsController@subjects');
            Route::post('chapters', 'QuizsController@chapters');
            Route::post('chapter-detail', 'QuizsController@chapterDetail');
        });

        Route::prefix('topics')->group(function () {
            Route::post('create', 'TopicsController@create');
            Route::post('delete', 'TopicsController@delete');
            Route::post('list', 'TopicsController@list');
            Route::get('list-all-user', 'TopicsController@listAllUser');
        });
        Route::prefix('tests')->group(function () {
            Route::get('all', 'TestsController@all');
            Route::post('list', 'TestsController@list');
            Route::get('info/{id}', 'TestsController@info');
            Route::post('create', 'TestsController@create');
            Route::get('delete/{id}', 'TestsController@delete');
            Route::post('update', 'TestsController@update');
            Route::post('quizs/{id}', 'TestsController@getQuizs');
            Route::post('add-quiz', 'TestsController@addQuizToTest');
            Route::post('quiz-delete', 'TestsController@deleteQuizFromTest');
        });
    });
});
