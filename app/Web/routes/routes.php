<?php

Route::group([
    'prefix' => '/',
    'namespace' => 'App\\Web\\Controllers',
    'middleware' => [],
], function(){

    Route::get('/', ['uses' => "HomeController@index", 'as' => 'w.home']);
    Route::get('/page/{id}', ['uses' => "PageController@page", 'as' => 'w.page'])->where('id', '[0-9]+');
    Route::get('/news/{id}', ['uses' => "PageController@news", 'as' => 'w.news'])->where('id', '[0-9]+');
    Route::get('/newsInfo/{id}', ['uses' => "PageController@newsInfo", 'as' => 'w.newsInfo'])->where('id', '[0-9]+');

});


