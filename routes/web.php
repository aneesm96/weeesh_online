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

    //$locale = App::getLocale();

    return view('welcome');
});

Auth::routes();



Route::get('/home', 'HomeController@index')->name('home');

Route::get('/user_profiles/{id_user_profile}/wlists/{id_list}/friend_show', 'WListController@friend_show')
    ->name('user_profiles.wlists.friend_show');
Route::resource('user_profiles.wlists', 'WListController');
Route::resource('wlists','WListController');

Route::resource('wlists.list_rows', 'ListRowController');
Route::resource('list_rows','ListRowController');

Route::resource('friendships','FriendshipController');

Route::resource('users','UserController');
Route::resource('fs_requests','FsRequestController');
Route::resource('user_profiles','UserProfileController');

Route::post('/send', 'EmailController@send');

Route::resource('bookings','BookingController');




