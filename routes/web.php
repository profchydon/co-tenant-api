<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

Route::group(['prefix' => 'api/v1'], function () {

    // Matching route
    Route::group(['prefix' => 'admin'], function () {
        Route::post('match' , 'AdminController@matchTenantToProperty');
        Route::post('cotenant/records' , 'AdminController@cotenantRecords');
        Route::post('create' , ['as' => 'createAdmin', 'uses' => 'AdminController@create']);
    });

    // Auth route
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login' , 'AuthController@login');
    });

    // Users route
    Route::group(['prefix' => 'users'], function () {
        Route::post('create' , ['as' => 'createUser', 'uses' => 'UserController@create']);
        Route::get('' , ['as' => 'allUsers', 'uses' => 'UserController@users']);
        Route::get('{id}' , ['as' => 'fetchAuser', 'uses' => 'UserController@fetchAUser']);
        Route::post('update' , ['as' => 'updateUser', 'uses' => 'UserController@updateUser']);

        Route::post('sendmail' , ['as' => 'sendMail', 'uses' => 'UserController@sendVerificationMail']);
    });

    // Cotenants  route
    Route::group(['prefix' => 'cotenants'], function () {
        Route::post('create' , 'CotenantController@create');
        Route::get('' , 'CotenantController@cotenants');
        Route::get('{id}' , 'CotenantController@fetchACoTenant');
        Route::post('update' , 'CotenantController@updateCoTenant');
        Route::post('accepts/all' , 'CotenantController@allAccepts');
    });

    // Properties route
    Route::group(['prefix' => 'properties'], function () {
        Route::post('create' , 'PropertyController@create');
        Route::get('' , 'PropertyController@properties');
        Route::get('{id}' , 'PropertyController@fetchAProperty');
        Route::post('update/{id}' , 'PropertyController@updateProperty');
    });

    // Groups route
    Route::group(['prefix' => 'groups'], function () {
        Route::post('create' , 'GroupController@create');
        Route::get('' , 'GroupController@groups');
        Route::get('{id}' , 'GroupController@fetchAGroup');
        Route::post('update/{id}' , 'GroupController@updateGroup');
    });

    // Verifications route
    Route::group(['prefix' => 'verifications'], function () {
        Route::post('create' , 'VerificationController@create');
        // Route::get('{id}' , 'VerificationController@fetchAVerification');
        Route::post('update' , 'VerificationController@updateVerification');
        Route::post('user/verify' , 'VerificationController@verifyUser');
    });

    // Transactions route
    Route::group(['prefix' => 'transactions'], function () {
        Route::post('create' , 'TransactionController@create');
        Route::get('' , 'TransactionController@transactions');
        Route::get('{id}' , 'TransactionController@fetchATransaction');
        Route::post('update' , 'TransactionController@updateTransaction');
    });

    // Occupanies route
    Route::group(['prefix' => 'occupanies'], function () {
        Route::post('create' , 'OccupancyController@create');
        Route::get('' , 'OccupancyController@occupancies');
        Route::get('{id}' , 'OccupancyController@fetchAOccupancy');
        Route::post('update/{id}' , 'OccupancyController@updateOccupancy');
    });

    // Accepts route
    Route::group(['prefix' => 'accepts'], function () {
        Route::post('create' , 'AcceptController@create');
        Route::get('' , 'AcceptController@accepts');
        Route::get('{id}' , 'AcceptController@fetchAAccept');
    });

    // Interests route
    Route::group(['prefix' => 'interests'], function () {
        Route::post('create' , 'InterestController@create');
        Route::get('' , 'InterestController@interests');
        Route::get('{id}' , 'InterestController@fetchAInterest');
    });

    // Visits route
    Route::group(['prefix' => 'visits'], function () {
        Route::post('create' , 'VisitController@create');
        Route::get('' , 'InterestController@visits');
        Route::get('{id}' , 'InterestController@fetchAVisit');
    });

});
