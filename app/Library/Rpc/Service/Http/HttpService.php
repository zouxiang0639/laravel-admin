<?php
namespace App\Library\Rpc\Service\Http;

use App\Library\Rpc\Exception\NetworkException;

/**
 * Class HttpService
 * @package App\Library\Rpc\Service\Http
 */
class HttpService
{
    /** @var HttpRequestBuilder */
    protected $requestBuilder;

    /** @var HttpResponseParser */
    protected $responseParser;

    /** @var int */
    protected $timeout = 60;

    protected $beforRequestHandler;
    protected $afterRequestHandler;

    /**
     * @param $handler
     * @return $this
     */
    public function setBeforRequestHandler($handler)
    {

        $this->beforRequestHandler = $handler;
        return $this;
    }

    /**
     * @param $handler
     * @return $this
     */
    public function setAfterRequestHandler($handler)
    {
        $this->afterRequestHandler = $handler;
        return $this;
    }

    /**
     * @param $builder
     * @return $this
     */
    public function setRequestBuilder(HttpRequestBuilder $builder)
    {
        $this->requestBuilder = $builder;
        return $this;
    }

    /**
     * @param $builder
     * @return $this
     */
    public function setResponseParser(HttpResponseParser $builder)
    {
        $this->responseParser = $builder;
        return $this;
    }

    /**
     * @param $uri
     * @param $param
     * @return mixed
     */
    public function call($uri, $param)
    {
        $httpRequest = $this->requestBuilder->build($uri, $param);
        $httpResponse = $this->fire($httpRequest);
        return $this->responseParser->parse($httpResponse);
    }

    /**
     * @param $timeout
     * @return $this
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;
        return $this;
    }

    /**
     * 发送http请求
     *
     * @param HttpRequest $httpRequest
     * @return HttpResponse
     * @throws NetworkException
     */
    private function fire(HttpRequest $httpRequest)
    {
        $url = $httpRequest->getUrl();
        $postData = $httpRequest->getPostData();
        $header = $httpRequest->getHeader();

        if ( is_callable($this->beforRequestHandler) ) {
            call_user_func($this->beforRequestHandler, $url, $postData, $header);
        }
        $curl = $this->curl($httpRequest);

        $this->curlHttps($curl, $httpRequest);
        $this->curlAddHeader($curl, $httpRequest);
        $this->curlAddParam($curl, $httpRequest);

        $data = curl_exec($curl);
        if (($errno = curl_errno($curl)) != CURLE_OK) {
            $error = curl_error($curl);
            throw new NetworkException("curl error({$errno}):{$error}");
        }
        list($header, $body) = explode("\r\n\r\n", $data, 2);

        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ( is_callable($this->afterRequestHandler) ) {
            call_user_func($this->afterRequestHandler, $code, $header, $body);
        }

        $response = new HttpResponse();
        $response->setCode($code);
        $response->setRawHeader($header);
        $response->setBody($body);
        return $response;
    }

    /**
     * @param $httpRequest
     * @return resource
     */
    private function curl(HttpRequest $httpRequest)
    {
        $curl = curl_init($httpRequest->getUrl());
        curl_setopt($curl, CURLOPT_HEADER, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $this->timeout);
        curl_setopt($curl, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($curl, CURLOPT_NOBODY, false);
        return $curl;
    }

    /**
     * @param $curl
     * @param HttpRequest $httpRequest
     * @return resource
     */
    private function curlHttps($curl, HttpRequest $httpRequest)
    {
        $url = $httpRequest->getUrl();
        $parse = parse_url($url);
        if (isset($parse["scheme"]) && $parse["scheme"] == "https") {
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        }
        return $curl;
    }

    /**
     * @param $curl
     * @param $httpRequest
     * @return resource
     */
    private function curlAddHeader($curl, HttpRequest $httpRequest)
    {
        $header = $this->getHeader($httpRequest);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        return $curl;
    }

    /**
     * @param $curl
     * @param HttpRequest $httpRequest
     * @return resource
     */
    private function curlAddParam($curl, HttpRequest $httpRequest)
    {
        $method = $httpRequest->getMethod();
        if ( $method == HttpRequest::HTTP_METHOD_POST ) {
            $this->curlSetPostOpt($curl, $httpRequest);
        } elseif ( $method == HttpRequest::HTTP_METHOD_GET )  {
            $this->curlSetGetOpt($curl, $httpRequest);
        }
        return $curl;
    }

    /**
     * @param $curl
     * @param HttpRequest $httpRequest
     * @return mixed
     */
    private function curlSetPostOpt($curl, HttpRequest $httpRequest)
    {
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $httpRequest->getPostData());
        return $curl;
    }

    /**
     * @param $curl
     * @param HttpRequest $httpRequest
     * @return mixed
     */
    private function curlSetGetOpt($curl, HttpRequest $httpRequest)
    {
        $paramString = http_build_query($httpRequest->getParam());
        $baseUrl = $httpRequest->getUrl();
        $url = strstr($baseUrl, "?") === false ?
            $baseUrl . "?" . $paramString :
            $baseUrl . "&" . $paramString;
        //dd($url);
        curl_setopt($curl, CURLOPT_URL, $url);

        return $curl;
    }

    /**
     * @param HttpRequest $httpRequest
     * @return array
     */
    private function getHeader(HttpRequest $httpRequest)
    {
        $header = $httpRequest->getHeader();
        if ( empty($header) ||  !$this->hasExpectHeader($header) ) {
            $header[] = "Expect:";
        }
        return $header;
    }

    /**
     * @param array $header
     * @return bool
     */
    private function hasExpectHeader(array $header)
    {
        $res = array_where($header, function($key, $value){
            if ( strpos($value, "Expect:") === 0 ) {
                return true;
            }
            return false;
        });
        return !empty($res);
    }
}