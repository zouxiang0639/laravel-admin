<?php
namespace App\Library\Rpc\Service\Http\ResponseParser;


use App\Exceptions\LogicException;
use App\Library\Rpc\Exception\BusinessProtocolException;
use App\Library\Rpc\Exception\NetworkException;
use App\Library\Rpc\Service\Http\HttpResponse;
use App\Library\Rpc\Service\Http\HttpResponseParser;

/**
 * Class DfApiResponseParser
 * @package App\Library\Rpc\Service\Http\ResponseParser
 */
class DefaultApiResponseParser implements HttpResponseParser
{

    /**
     * 解析
     * {@inheritDoc}
     * @see \App\Library\Rpc\Service\Http\HttpResponseParser::parse()
     */
    public function parse(HttpResponse $response)
    {
        $responseCode = $response->getCode();
        if ($responseCode != 200) {
            throw new NetworkException('Illegal http response code: ' . $responseCode);
        }

        //$header = $response->getHeader();
        $body = $response->getBody();

        $obj = json_decode($body);
        if ($obj === null) {
            throw new NetworkException('Illegal http response code: ' . $responseCode);
        }

        if (isset($obj->errcode) && $obj->errcode != 0) {
            throw (new BusinessProtocolException($body, $obj->errcode))->setRawResponse($response);
        }

        return $obj;
    }

}