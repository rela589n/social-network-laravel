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

# Авторизация
Route::get('/signout', 'AuthController@getSignout')->name('auth.signout');

Route::middleware('guest')->group(function () {
    Route::get('/signup', 'AuthController@getSignup')->name('auth.signup');
    Route::get('/signin', 'AuthController@getSignin')->name('auth.signin');
    Route::post('/signup', 'AuthController@postSignup');
    Route::post('/signin', 'AuthController@postSignin');
});

# Поиск
Route::get('/search', 'SearchController@getResults')->name('search.results');

# Профили
Route::get('/user/{username}', 'ProfileController@getProfile')->name('profile.index');

Route::middleware('auth')->prefix('profile')->name('profile.')->group(function () {
    Route::get('/edit', 'ProfileController@getEdit')->name('edit');
    Route::post('/edit', 'ProfileController@postEdit')->name('edit');
});

# Друзья
Route::middleware('auth')->prefix('friends')->name('friend.')->group(function () {
    Route::get('/', 'FriendController@getIndex')->name('index');
    Route::get('/add/{username}', 'FriendController@getAdd')->name('add');
    Route::get('/accept/{username}', 'FriendController@getAccept')->name('accept');
    Route::post('/delete/{username}', 'FriendController@postDelete')->name('delete');
});

# Стена
Route::middleware('auth')->prefix('status')->name('status.')->group(function () {
    Route::post('/', 'StatusController@postStatus')->name('post');
    Route::post('/{statusId}/reply', 'StatusController@postReply')->name('reply');
    Route::get('/{statusId}/like', 'StatusController@getLike')->name('like');
});