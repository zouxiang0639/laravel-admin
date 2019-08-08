<?php
namespace App\Library\Rpc;

use App\Library\Rpc\Service\Http\HttpRequestBuilder;
use App\Library\Rpc\Service\Http\HttpResponseParser;
use App\Library\Rpc\Service\Http\HttpService;
use App\Library\Rpc\Service\Http\RequestBuilder\DefaultApiRequestBuilder;
use App\Library\Rpc\Service\Http\ResponseParser\DefaultApiResponseParser;

/**
 * Class RpcManager
 * @package App\Library\Rpc
 */
class RpcManager
{
    const DEFAULT_REQUEST_BUILDER = DefaultApiRequestBuilder::class;
    const DEFAULT_RESPONSE_PARSER = DefaultApiResponseParser::class;

    /** @var  HttpService */
    protected $httpServiceHandler;

    private $config;

    public function __construct($config)
    {
        $this->config = $config;

        $this->setHttpServiceHandler(new HttpService());
    }

    /**
     * @param $service
     * @param $method
     * @param $param
     * @return mixed
     */
    public function call($service, $method, $param)
    {

        return $this->callHttpService($service, $method, $param);
    }

    /**
     * @param $service
     * @param $method
     * @param $param
     * @return mixed
     */
    private function callHttpService($service, $method, $param)
    {
        $requestBuilder = $this->getRequestBuilder($service);
        $this->httpServiceHandler->setRequestBuilder($requestBuilder);

        $responseParser = $this->getResponseParser($service);
        $this->httpServiceHandler->setResponseParser($responseParser);
        return $this->httpServiceHandler->call($method, $param);
    }

    /**
     * @param $service
     * @return HttpRequestBuilder
     */
    private function getRequestBuilder($service)
    {
        $class = $this->getRequestBuilderClass($service);
        return new $class($this->config[$service]["request"]["property"]);
    }

    /**
     * @param $service
     * @return string
     */
    private function getRequestBuilderClass($service)
    {
        return isset($this->config[$service]["request"]["builder"]) ?
            $this->config[$service]["request"]["builder"] :
            static::DEFAULT_REQUEST_BUILDER;
    }

    /**
     * @param $service
     * @return HttpResponseParser
     */
    private function getResponseParser($service)
    {
        $class = $this->getResponseParserClass($service);
        return new $class();
    }

    /**
     * @param $service
     * @return string
     */
    private function getResponseParserClass($service)
    {
        return isset($this->config[$service]["response"]["class"]) ?
            $this->config[$service]["response"]["class"] :
            static::DEFAULT_RESPONSE_PARSER;
    }

    /**
     * @param HttpService $handler
     * @return $this
     */
    public function setHttpServiceHandler(HttpService $handler)
    {
        $this->httpServiceHandler = $handler;
        return $this;
    }

    /**
     * @return HttpService
     */
    public function getHttpServiceHandler()
    {
        return $this->httpServiceHandler;
    }

    /**
     * @return $config
     */
    public function getConfig()
    {
        return $this->config;
    }
}
