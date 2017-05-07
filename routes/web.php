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
    return view('home');
})->name('home');


//Route::get('/test', function () {
//    return "123";
//});

Route::group(['middleware' => 'auth'], function () {
    Route::resource('project', 'ProjectController');
    Route::resource('image', 'ImageController');
    Route::post('project/updateCover', 'ProjectController@updateCover');
    Route::get('image/{id}/ids', 'ImageController@getImgIDList');
    Route::get('image/info/{id}', 'ImageController@getInfo');
});



Auth::routes();




