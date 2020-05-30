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

/**
 * Авторизация
 */
Route::get('/signup', 'AuthController@getSignup')->middleware('guest')->name('auth.signup');
Route::post('/signup', 'AuthController@postSignup')->middleware('guest');

Route::get('/signin', 'AuthController@getSignin')->middleware('guest')->name('auth.signin');
Route::post('/signin', 'AuthController@postSignin')->middleware('guest');

Route::get('/signout', 'AuthController@getSignout')->name('auth.signout');

/**
 * Поиск
 */
Route::get('/search', 'SearchController@getResults')->name('search.results');

/**
 * Профили
 */
Route::get('/user/{username}', 'ProfileController@getProfile')->name('profile.index');

Route::get('/profile/edit', 'ProfileController@getEdit')->middleware('auth')->name('profile.edit');
Route::post('/profile/edit', 'ProfileController@postEdit')->middleware('auth')->name('profile.edit');

/**
 * Друзья
 */
Route::get('/friends', 'FriendController@getIndex')->middleware('auth')->name('friend.index');