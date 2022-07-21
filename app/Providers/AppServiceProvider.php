<?php

namespace App\Providers;

use App\Admin\Bls\System\ConfigBls;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        //注入配置
        if(config('admin.config')) {
            ConfigBls::load();
        }

        $this->bootLogger();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    private function bootLogger()
    {

        app("log")->getMonolog()->pushProcessor(function($record){
            $url = \Request::fullUrl();
            $record["message"] =  " ($url)" . $record["message"];
            return $record;
        });
    }
}
