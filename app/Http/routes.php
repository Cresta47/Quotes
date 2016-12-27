<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::group(['middleware'=>['web']],function(){
   Route::get('/{author?}',[
       'uses'=>'QuoteController@index',
       'as'=>'index'
   ]);

    Route::post('/new',[
        'uses'=>'QuoteController@store',
        'as'=>'create'
    ]);

    Route::get('/delete/{quote_id}',[
        'uses'=>'QuoteController@destroy',
        'as'=>'delete'
    ]);
});
