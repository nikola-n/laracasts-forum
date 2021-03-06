<?php

use Illuminate\Support\Facades\Route;

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

Route::get('threads', 'ThreadController@index')->name('threads.index');
Route::get('threads/create', 'ThreadController@create')->name('threads.create');
//laravel 7.x
Route::get('threads/{channel:slug}/{thread}', 'ThreadController@show')->name('threads.show');
Route::delete('threads/{channel:slug}/{thread}', 'ThreadController@delete');
Route::post('threads', 'ThreadController@store')->name('threads.store');
Route::get('threads/{channel:slug}', 'ThreadController@index');
Route::post('/threads/{channel:slug}/{thread}/replies', 'ReplyController@store' )->name('replies.store');
Route::patch('/replies/{reply}', 'ReplyController@update');
Route::delete('/replies/{reply}', 'ReplyController@destroy');
Route::post('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@store')->middleware('auth');

Route::post('/replies/{reply}/favorites', 'FavoriteController@store');
Route::delete('/replies/{reply}/favorites', 'FavoriteController@destroy');

Route::get('/profiles/{user:name}', 'ProfileController@show')->name('profile');

