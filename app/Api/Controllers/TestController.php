<?php

namespace App\Api\Controllers;

use App\Http\Controllers\ApiController;

class TestController extends ApiController
{

    public function index()
    {
        return $this->success(['name' => '张三']);
    }

}
