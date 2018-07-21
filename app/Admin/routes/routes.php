<?php

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function(){

    Route::get('/', ['uses' => "HomeController@index", 'as' => 'm.home']);
    Route::get('login', ['uses' => "Auth\\AuthController@login", 'as' => 'm.login']);
    Route::post('login', ['uses' => "Auth\\AuthController@postLogin", 'as' => 'm.postLogin']);
    Route::get('logout', ['uses' => "Auth\\AuthController@logout", 'as' => 'm.logout']);
    Route::get('auth/users', ['uses' => "Auth\\AuthController@index", 'as' => 'm.auth.users']);

    //后台管理员
    Route::group(['prefix'=>'users', 'middleware' => 'admin.auth:m_users'], function(){
        Route::get('', ['uses' => "Auth\\UserController@index", 'as' => 'm.user.list']);
        Route::get('edit/{id}', ['uses' => "Auth\\UserController@edit", 'as' => 'm.user.edit']);
        Route::post('update/{id}', ['uses' => "Auth\\UserController@update", 'as' => 'm.user.update']);
    });

    //角色
    Route::group(['prefix'=>'role', 'middleware' => 'admin.auth:m_role'], function(){
        Route::get('', ['uses' => "Auth\\RoleController@index", 'as' => 'm.role.list']);
        Route::get('edit/{id}', ['uses' => "Auth\\RoleController@edit", 'as' => 'm.role.edit']);
        Route::post('update/{id}', ['uses' => "Auth\\RoleController@update", 'as' => 'm.role.update']);
        Route::get('create', ['uses' => "Auth\\RoleController@create", 'as' => 'm.role.create']);
        Route::post('store', ['uses' => "Auth\\RoleController@store", 'as' => 'm.role.store']);
        Route::delete('destroy/{id}', ['uses' => "Auth\\RoleController@destroy", 'as' => 'm.role.destroy']);
    });

    //权限
    Route::group(['prefix'=>'permissions'], function(){
        Route::get('', ['uses' => "Auth\\PermissionsController@index", 'as' => 'm.permissions.list']);
        Route::get('/create', ['uses' => "Auth\\PermissionsController@create", 'as' => 'm.permissions.create']);
        Route::post('store', ['uses' => "Auth\\PermissionsController@store", 'as' => 'm.permissions.store']);
        Route::get('edit/{id}', ['uses' => "Auth\\PermissionsController@edit", 'as' => 'm.permissions.edit']);
        Route::post('update/{id}', ['uses' => "Auth\\PermissionsController@update", 'as' => 'm.permissions.update']);
        Route::delete('destroy/{id}', ['uses' => "Auth\\PermissionsController@destroy", 'as' => 'm.permissions.destroy']);
    });

    //菜单
    Route::group(['prefix'=>'menu', 'middleware' => 'admin.auth:m_menu'], function(){
        Route::get('', ['uses' => "Auth\\MenuController@index", 'as' => 'm.menu.list']);
        Route::post('store', ['uses' => "Auth\\MenuController@store", 'as' => 'm.menu.store']);
        Route::get('edit/{id}', ['uses' => "Auth\\MenuController@edit", 'as' => 'm.menu.edit']);
        Route::post('update/{id}', ['uses' => "Auth\\MenuController@update", 'as' => 'm.menu.update']);
        Route::post('sort', ['uses' => "Auth\\MenuController@sort", 'as' => 'm.menu.sort']);
        Route::delete('destroy/{id}', ['uses' => "Auth\\MenuController@destroy", 'as' => 'm.menu.destroy']);
    });

    //配置
    Route::group(['prefix'=>'config'], function(){
        Route::get('', ['uses' => "Auth\\MenuController@index", 'as' => 'm.config.list']);
    });
});


