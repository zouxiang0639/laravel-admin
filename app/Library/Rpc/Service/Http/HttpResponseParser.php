<?php
namespace App\Library\Rpc\Service\Http;

/**
 * Class HttpResponseParser
 * @package App\Library\Rpc\Service\Http
 */
interface HttpResponseParser
{
    /**
     * @param HttpResponse $response
     * @return mixed
     */
    public function parse(HttpResponse $response);
}
