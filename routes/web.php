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



Route::group(array('middleware' => 'auth'), function()
{
    Route::get('backend/shops', ['as'=> 'backend.shops.index', 'uses' => 'Backend\shopController@index']);
    Route::post('backend/shops', ['as'=> 'backend.shops.store', 'uses' => 'Backend\shopController@store']);
    Route::get('backend/shops/create', ['as'=> 'backend.shops.create', 'uses' => 'Backend\shopController@create']);
    Route::put('backend/shops/{shops}', ['as'=> 'backend.shops.update', 'uses' => 'Backend\shopController@update']);
    Route::patch('backend/shops/{shops}', ['as'=> 'backend.shops.update', 'uses' => 'Backend\shopController@update']);
    Route::delete('backend/shops/{shops}', ['as'=> 'backend.shops.destroy', 'uses' => 'Backend\shopController@destroy']);
    Route::get('backend/shops/{shops}', ['as'=> 'backend.shops.show', 'uses' => 'Backend\shopController@show']);
    Route::get('backend/shops/{shops}/edit', ['as'=> 'backend.shops.edit', 'uses' => 'Backend\shopController@edit']);
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home/likehome/{id}', 'HomeController@likehome')->name('home.likehome');
Route::get('/home/likenearby/{id}', 'HomeController@likenearby')->name('home.likenearby');
Route::get('/home/remove/{id}', 'HomeController@remove')->name('home.remove');
Route::get('/likedshops', 'HomeController@liked')->name('home.liked');
Route::get('/nearby', 'HomeController@nearby')->name('home.nearby')->middleware('auth');
Route::get('/location', 'HomeController@location')->name('home.location');
