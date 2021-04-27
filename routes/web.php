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

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/time/table/create','TimetableController@Create');
Route::post('/time/table/save','TimetableController@timetableSave');
Route::post('/savesubjects','TimetableController@saveSubjects');

Route::get('/getTotalHoursForWeek/','TimetableController@getTotalHoursForWeek');
Route::get('/time/table/generate/','TimetableController@timeTableGenerate');
