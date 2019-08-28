<?php
/**
 * Created by PhpStorm.
 * User: xiaobona
 * Date: 2018/7/10
 * Time: 09:57
 */

namespace  App\Library\Sdk;

use  App\Library\Rpc\Rpc;
use App\Library\Rpc\Service\Http\HttpRequest;

/**
 * @name 测试Sdk
 *
 */
class TestSdk
{
    const SERVICE_NAME = 'test';

    /**
     * @name 接口测试
     *
     * @param $showId
     * @return mixed
     */
    public static function getOpenidByUserId($showId)
    {

        return self::call('get:test',['name' => $showId]);
    }

    private static function call($api, $param)
    {

        return Rpc::call(static::SERVICE_NAME, $api, $param);
    }

}
