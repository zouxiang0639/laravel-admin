<?php
namespace App\Library\Rpc\Service\Http;

/**
 * Interface HttpRequestBuilder
 * @package App\Library\Rpc\Service\Http
 */
interface HttpRequestBuilder
{
    /**
     * @param $uri
     * @param $param
     * @return HttpRequest
     */
    public function build($uri, $param);
}