<?php

Route::group([], function(){

    //测试接口
    Route::group(['prefix'=>'test'], function(){
        Route::get('list', ['uses' => "TestController@index"]);
    });

});


