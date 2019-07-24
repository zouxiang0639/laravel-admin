<?php
namespace App\Http\Composers;


use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;


/**
 * Composer服务提供类
 */
class ComposerServiceProvider extends ServiceProvider
{

    public function boot()
    {

       // View::composer('admin::users.form', 'App\Http\Composers\UserFormComposer');

    }

    public function register()
    {

    }
}
