<?php
namespace App\Library\Rpc\Service\Http\RequestBuilder;
use App\Library\Rpc\Service\Http\HttpRequest;


/**
 * Class DefaultRequestBuilder
 * @package Dffl\Service\Common\Library\Rpc\Service\Http\RequestBuilder
 */
class DefaultApiRequestBuilder extends AbstractBuilder
{
    private $method;

    /**
     * @param $uri
     * @param $param
     * @return HttpRequest
     */
    public function build($uri, $param)
    {
        $arr = explode(':', $uri);

        $count = count($arr);
        if ($count == '2') {
            list($this->method, $this->uri) = $arr;
        } else {
            $this->uri = $arr[0];
        }

        return parent::build($this->uri, $param);
    }

    /**
     * @return $this
     */
    protected function buildUrl()
    {
        if (!isset($this->property['url'])) {
            throw new \InvalidArgumentException('Illegal property.');
        }
        $this->request->setUrl($this->property['url'] . '/' . $this->uri);
        return $this;
    }

    /**
     * @return $this
     */
    protected function buildMethod()
    {
        if (!empty($this->method)) {
            $this->request->setMethod(strtolower($this->method));
        } elseif (empty($this->property["method"])) {
            $this->request->setMethod(HttpRequest::HTTP_METHOD_POST);
        } else {
            $this->request->setMethod(strtolower($this->property["method"]));
        }

        if ($this->request->getMethod() != HttpRequest::HTTP_METHOD_GET) {
            $this->request->setRawPostType();
        }

        return $this;
    }

    /**
     * @return $this
     */
    protected function buildParam()
    {
        if ($this->request->getMethod() == HttpRequest::HTTP_METHOD_POST) {
            $this->request->setRawPostData(json_encode($this->param));
        } else {
            $this->request->setParam($this->param);
        }
        return $this;
    }

    /**
     * @return $this
     */
    protected function buildHeader()
    {
        $this->request->setHeader([
            'Accept:*/*',
            'Cache-Control:no-cache',
            'Content-Type:application/json',
        ]);

        return $this;
    }

}