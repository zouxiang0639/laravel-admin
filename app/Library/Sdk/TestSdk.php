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
 * 测试Sdk
 */
class TestSdk
{
    const SERVICE_NAME = 'test';
    /**
     * @name userid转openid
     * 该接口使用场景为企业支付，在使用企业红包和向员工付款时，需要自行将企业微信的userid转成openid
     * @param $accessToken 调用接口凭证
     * @param $userid 企业内的成员id
     * @return mixed
     */
    public static function getOpenidByUserid()
    {

        return self::call('get:test',['name' => 'a']);
    }

    private static function call($api, $param)
    {

        return Rpc::call(static::SERVICE_NAME, $api, $param);
    }

}
