<?php
namespace App\Library\Rpc\Service\Http\RequestBuilder;

use App\Library\Rpc\Service\Http\HttpRequest;
use App\Library\Rpc\Service\Http\HttpRequestBuilder;

/**
 * Class AbstractBuilder
 * @package App\Library\Rpc\Service\Http\RequestBuilder
 */
class AbstractBuilder implements HttpRequestBuilder
{
    protected $property;
    protected $request;
    protected $uri;
    protected $param;

    public function __construct($property)
    {
        $this->property = $property;
        $this->request = new HttpRequest();
    }

    /**
     * @param $uri
     * @param $param
     * @return HttpRequest
     */
    public function build($uri, $param)
    {
        $this->uri = $uri;
        $this->param = $param;

        $this->buildUrl()
            ->buildHeader()
            ->buildMethod()
            ->buildParam();

        return $this->request;
    }

    /**
     * @return $this
     */
    protected function buildUrl()
    {
        $this->request->setUrl("");
        return $this;
    }

    /**
     * @return $this
     */
    protected function buildHeader()
    {
        $this->request->setHeader(array());
        return $this;
    }

    /**
     * @return $this
     */
    protected function buildMethod()
    {
        $this->request->setMethod(HttpRequest::HTTP_METHOD_GET);
        return $this;
    }

    /**
     * @return $this
     */
    protected function buildParam()
    {

        $this->request->setParam($this->param);
        return $this;
    }
}