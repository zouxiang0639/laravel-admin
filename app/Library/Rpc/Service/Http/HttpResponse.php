<?php
namespace App\Library\Rpc\Service\Http;

/**
 * Class HttpResponse
 * @package App\Library\Rpc\Service\Http
 */
class HttpResponse
{
    private $code;
    private $header;
    private $body;

    /**
     * @param $code
     * @return $this
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

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
     * @return array
     */
    public function setRawHeader($header)
    {
        $split = explode("\r\n", $header, 2);
        $headerString = $split[1];

        $headerSplit = explode("\r\n", $headerString);
        foreach ( $headerSplit as $slice ) {
            $item = explode(":", $slice);
            $key = trim($item[0]);
            $val = trim($item[1]);
            $this->header[$key] = $val;
        }
        return $header;
    }

    /**
     * @param $body
     * @return $this
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return mixed
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }
}