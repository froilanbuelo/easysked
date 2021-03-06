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

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();
Route::group(['prefix' => 'manage'], function () {
    Route::resource('user', 'UserController');
    Route::resource('service', 'ServiceController');
    Route::resource('appointment', 'AppointmentController');
});
Route::get('reservation', 'AppointmentController@create')->name('new_appointment');
Route::post('reservation', 'AppointmentController@store')->name('new_appointment_save');

Route::get('/google_login', 'GoogleAuthController@login')->name('google_login');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('{username}', 'ProfileController@show')->name('profile');
Route::get('{username}/{service}', 'ProfileController@service_profile')->name('service_profile');

