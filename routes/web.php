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

Route::get('login', [
    'as' => 'form.login',
    'uses' => 'AuthController@ShowloginForm'
]);

Route::post('login', 'AuthController@login');
Route::get('logout', 'AuthController@logout');

Route::group(['middleware'=>'adminLogin'],function (){
    Route::get('/', [
            'as' => 'index',
            'uses' => 'HomeController@index']
    );
});

Route::group(['prefix' => 'ajax', 'middleware' => 'adminLogin'], function () {

    Route::get('getEventOfDay', [
        'as' => 'getEventOfDay',
        'uses' => 'AjaxController@getEventOfDay'
    ]);

});
