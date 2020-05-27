<?php

use Sassnowski\LaravelShareableModel\Shareable\ShareableLink;

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

Route::group(['middleware' => 'Admin'], function () {
    Route::get('/admin-home', 'AdminController@Home')->name('admin');
    Route::get('/admin-events', 'AdminController@events')->name('admin.events');
    Route::get('/admin-comments', 'AdminController@comments')->name('admin.comments');
    Route::get('/admin-unavailables', 'AdminController@unavailables')->name('admin.unavailables');
    Route::post('/MakeAdmin/{id}', 'AdminController@MakeAdmin')->name('MakeAdmin');
    Route::resource('users', 'UsersController');
});


// Route::get('/event/show/{id}', 'EventsController@show')->name('availables')->middleware('ShowEvent');

Route::resource('events', 'EventsController');

Route::get('event/share/{id}', 'EventsController@share')->name('shareEvent');

Route::get('shared/{shareable_link}', 'EventsController@participate')->middleware('shared');

Route::get('event/participate/{id}', 'EventsController@confirmParticipation')->name('Confirm');

Route::resource('unavailables', 'UnavailablesController')->middleware('auth');

Route::delete('repeatables/{id}', 'UnavailablesController@RepDestroy')->name('repeatables.destroy');

Route::resource('comments', 'CommentsController');

//Route::resource('repeatables', 'RepeatablesController');

Route::get('login/facebook', 'Auth\LoginController@redirectToProvider');
Route::get('login/facebook/callback', 'Auth\LoginController@handleProviderCallback');

