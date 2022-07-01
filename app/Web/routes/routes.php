<?php

Route::group([
    'prefix' => '/',
    'namespace' => 'App\\Web\\Controllers',
    'middleware' => [],
], function(){

    Route::get('/', ['uses' => "HomeController@index", 'as' => 'm.home']);

});


