<?php
namespace App\Library\Rpc\Service\Http;

/**
 * Class HttpRequest
 * @package Dffl\Service\Common\Library\Rpc\Service\Http
 */
class HttpRequest
{
    const HTTP_METHOD_GET = "get";
    const HTTP_METHOD_POST = "post";
    const HTT_METHOD_PUT = "put";
    const HTTP_METHOD_DELETE = "delete";

    const HTTP_POST_TYPE_PARAM = 0;
    const HTTP_POST_TYPE_RAW = 1;

    private $header = array();
    private $url;
    private $method;
    private $param;

    private $postType;
    private $rawPostData;

    /**
     * @param $header
     * @return $this
     */
    public function setHeader($header)
    {
        $this->header = $header;
        return $this;
    }

    /**
     * @param $header
     * @return $this
     */
    public function addHeader($header)
    {
        $this->header = array_merge($this->header, $header);
        return $this;
    }

    /**
     * @param $url
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @param $method
     * @return $this
     */
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @param $param
     * @return $this
     */
    public function setParam($param)
    {
        $this->param = $param;
        return $this;
    }

    /**
     * @param $param
     * @return $this
     */
    public function addParam($param)
    {
        $this->param = array_merge($this->param, $param);
        return $this;
    }

    /**
     * @return array
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return mixed
     */
    public function getParam()
    {
        return $this->param;
    }

    /**
     * @param $data
     * @return $this
     */
    public function setRawPostData($data)
    {
        $this->rawPostData = $data;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRawPostData()
    {
        return $this->rawPostData;
    }

    /**
     * @param $type
     * @return $this
     */
    public function setPostType($type)
    {
        $this->postType = $type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPostType()
    {
        return $this->postType;
    }

    /**
     * @return $this
     */
    public function setRawPostType()
    {
        $this->setPostType(self::HTTP_POST_TYPE_RAW);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPostData()
    {
        return $this->getPostType() == HttpRequest::HTTP_POST_TYPE_RAW ?
            $this->getRawPostData() : http_build_query($this->getParam());
    }
}