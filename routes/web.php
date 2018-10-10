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

// Tested and Confirmed
Route::group(['prefix' => 'auth'], function () {

  Route::post('login' , 'AuthController@login');

});

Route::group(['prefix' => 'users'], function () {

  Route::post('create' , ['as' => 'createUser', 'uses' => 'UserController@create']);
  Route::get('' , ['as' => 'allUsers', 'uses' => 'UserController@users']);
  Route::get('{id}' , ['as' => 'fetchAuser', 'uses' => 'UserController@fetchAUser']);
  Route::post('update/{id}' , ['as' => 'updateUser', 'uses' => 'UserController@updateUser']);

});

Route::group(['middleware' => 'auth' , 'prefix' => 'cotenants'], function () {

  Route::post('create' , 'CotenantController@create');
  // Route::get('' , 'CotenantController@cotenants');
  Route::get('{id}' , 'CotenantController@fetchACoTenant');
  Route::post('update/{id}' , 'CotenantController@updateCoTenant');

});

// Tested and Confirmed
Route::group(['middleware' => 'auth' , 'prefix' => 'properties'], function () {

  Route::post('create' , 'PropertyController@create');
  Route::get('' , 'PropertyController@properties');
  Route::get('{id}' , 'PropertyController@fetchAProperty');
  Route::post('update/{id}' , 'PropertyController@updateProperty');

});

// Tested and Confirmed
Route::group(['prefix' => 'groups'], function () {

  Route::post('create' , 'GroupController@create');
  Route::get('' , 'GroupController@groups');
  Route::get('{id}' , 'GroupController@fetchAGroup');
  Route::post('update/{id}' , 'GroupController@updateGroup');

});

// Tested and Confirmed
Route::group(['prefix' => 'verifications'], function () {

  Route::post('create' , 'VerificationController@create');
  Route::get('' , 'VerificationController@groups');
  Route::get('{id}' , 'VerificationController@fetchAVerification');
  Route::post('update' , 'VerificationController@updateVerification');
  Route::post('user/verify' , 'VerificationController@verifyUser');

});

// Tested and Confirmed
Route::group(['middleware' => 'auth' , 'prefix' => 'transactions'], function () {

  Route::post('create' , 'TransactionController@create');
  Route::get('' , 'TransactionController@transactions');
  Route::get('{id}' , 'TransactionController@fetchATransaction');
  Route::post('update' , 'TransactionController@updateTransaction');

});

// Tested and Confirmed
Route::group(['middleware' => 'auth' , 'prefix' => 'occupanies'], function () {

  Route::post('create' , 'OccupancyController@create');
  Route::get('' , 'OccupancyController@occupancies');
  Route::get('{id}' , 'OccupancyController@fetchAOccupancy');
  Route::post('update/{id}' , 'OccupancyController@updateOccupancy');

});

// Tested and Confirmed
Route::group(['middleware' => 'auth' , 'prefix' => 'accepts'], function () {

  Route::post('create' , 'AcceptController@create');
  Route::get('' , 'AcceptController@accepts');
  Route::get('{id}' , 'AcceptController@fetchAAccept');

});


// Tested and Confirmed
Route::group(['middleware' => 'auth' , 'prefix' => 'interests'], function () {

  Route::post('create' , 'InterestController@create');
  Route::get('' , 'InterestController@interests');
  Route::get('{id}' , 'InterestController@fetchAInterest');

});
