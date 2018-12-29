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

Route::middleware('auth')->group(function(){
	Route::get('profile', 'ProfileController@index')->name('profile');

	Route::get('threads', 'ThreadController@index')->name('threads');
	Route::post('threads/user/filter/push', 'ThreadController@userFilterPush')->name('threads.user.filter.push');
	Route::post('threads/user/filter/forget', 'ThreadController@userFilterForget')->name('threads.user.filter.forget');
	Route::get('thread/view/{thread}', 'ThreadController@edit')->name('thread');
	Route::post('thread/update/{thread}', 'ThreadController@update')->name('thread.update');
	Route::post('thread/store', 'ThreadController@store')->name('thread.store');
	Route::get('thread/destroy/{thread}', 'ThreadController@destroy')->name('thread.destroy');
	Route::post('thread/comment/{thread}', 'CommentController@store')->name('thread.comment.store');
});

