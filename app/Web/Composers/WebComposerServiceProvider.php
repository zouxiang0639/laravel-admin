<?php
namespace App\Web\Composers;


use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;


/**
 * Composer服务提供类
 */
class WebComposerServiceProvider extends ServiceProvider
{

    public function boot()
    {

        View::composer('web::partials.style', 'App\Web\Composers\CommonComposer');

    }

    public function register()
    {

    }
}
