<?php

use App\Library\Rpc\Service\Http\RequestBuilder\DefaultApiRequestBuilder;
use App\Library\Rpc\Service\Http\ResponseParser\DefaultApiResponseParser;

return array(
    "test" => [
        "request" => [
            "builder" => DefaultApiRequestBuilder::class,
            "property" => [
                "url" => env('APP_URL').'/api',
                "method" => "post",
                "format" => "json"
            ]
        ],
        "response" => [
            "class" => DefaultApiResponseParser::class
        ]
    ],
);