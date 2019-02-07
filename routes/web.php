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

use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('tweets', 'TweetsController');
Route::post('/tweets/{tweet}/comments', 'TweetCommentsController@store')->name('tweet.comments.store');
Route::post('tweets/upload', function () {


    Storage::disk('files')->put('', request()->file('text'));


})->name('tweet.upload');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

