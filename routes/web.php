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

Route::get('/', 'HomeController@index')->name('home');

Auth::routes(['verify' => true]);

# Поиск
Route::get('/search', 'SearchController@getResults')
    ->middleware('verified')->name('search.results');

# Профили
Route::get('/user/{username}', 'ProfileController@getProfile')
    ->middleware('verified')->name('profile.index');

Route::middleware(['auth', 'verified'])->prefix('profile')->name('profile.')->group(function () {
    Route::get('/edit', 'ProfileController@getEdit')->name('edit');
    Route::post('/edit', 'ProfileController@postEdit')->name('edit');
    Route::post('/upload-avatar/{username}', 'ProfileController@postUploadAvatar')->name('upload-avatar');
});

# Друзья
Route::middleware(['auth', 'verified'])->prefix('friends')->name('friend.')->group(function () {
    Route::get('/', 'FriendController@getIndex')->name('index');
    Route::get('/add/{username}', 'FriendController@getAdd')->name('add');
    Route::get('/accept/{username}', 'FriendController@getAccept')->name('accept');
    Route::post('/delete/{username}', 'FriendController@postDelete')->name('delete');
});

# Стена
Route::middleware(['auth', 'verified'])->prefix('wall')->name('wall.')->group(function () {
    Route::post('/', 'WallController@postWall')->name('post');
    Route::post('/{id}/reply', 'WallController@postReply')->name('reply');
    Route::get('/{id}/like', 'WallController@getLike')->name('like');
});