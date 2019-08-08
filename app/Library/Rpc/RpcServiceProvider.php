<?php
namespace App\Library\Rpc;

use Illuminate\Support\ServiceProvider;

class RpcServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton("rpc", function($app){
            $config = config("rpc");
            $rpc = new RpcManager($config);
            $httpService = $rpc->getHttpServiceHandler();

            $httpService->setBeforRequestHandler(function($url, $postData, $header){
                \Log::getMonolog()->popHandler();
                \Log::useFiles(storage_path('logs/rpc.log'), 'info');
                \Log::info("http request url: " . $url);
                \Log::info("http request post: " . $postData);
                \Log::info("http request header: " . http_build_query($header));
            });

            $httpService->setAfterRequestHandler(function($code, $header, $body){
            	if (strpos($header,'Content-Encoding: gzip')!==false && !empty($body)) {
                    $body = gzinflate(substr($body, 10));
                }
                \Log::info("http response code: " . $code);
                \Log::info("http response body: " . $body);
            });

            return $rpc;
        });
    }
}