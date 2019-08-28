<?php

namespace App\Admin\Bls\Api;

use App\Library\Sdk\TestSdk;
use Minime\Annotations\Reader;

class ApiBls
{
    /** @var array 可调用的类列表 */
    protected static $apiList = array(
        //外部服务
        TestSdk::class,
    );

    /**
     * 获得所有api接口类
     *
     * @return array
     */
    public static function getApiList()
    {
        $apiList = array();
        foreach ( static::$apiList as $class ) {
            $apiList[$class] = static::getApiDesc($class);
        }
        return $apiList;
    }

    /**
     * 获得接口类所有方法
     *
     * @param $class
     * @return array
     */
    public static function getMethodsList($class)
    {
        if ( !in_array($class, static::$apiList) ) {
            return [];
        }

        $reflect = new \ReflectionClass($class);
        $public = $reflect->getMethods(\ReflectionMethod::IS_PUBLIC);
        $static = $reflect->getMethods(\ReflectionMethod::IS_PUBLIC);
        $methods = array_intersect($public, $static);

        $list = array();

        foreach ( $methods as $method ) {
            $methodName = $method->getName();
            $list[$methodName] = static::getMethodDesc($class, $methodName);
        }


        return $list;
    }

    /**
     * 获得api描述
     *
     * @param $class
     * @return mixed|null|string
     */
    public static function getApiDesc($class)
    {
        if ( !in_array($class, static::$apiList) ) {
            return "";
        }

        $reader = Reader::createFromDefaults();
        $annotations = $reader->getClassAnnotations($class);
        return $annotations->get("name");
    }

    /**
     * 获得方法参数列表
     *
     * @param $class
     * @param $method
     * @return array
     */
    public static function getMethodParam($class, $method)
    {
        if ( !in_array($class, static::$apiList) ) {
            return [];
        }

        if ( !in_array($method, array_keys(static::getMethodsList($class))) ) {
            return [];
        }

        $reader = Reader::createFromDefaults();
        $annotations = $reader->getMethodAnnotations($class, $method);
        $param = $annotations->getAsArray("param");
        return $param;
    }

    /**
     * 获得方法描述
     *
     * @param $class
     * @param $method
     * @return mixed|null
     */
    public static function getMethodDesc($class, $method)
    {
        $reader = Reader::createFromDefaults();
        $methodName = $method;
        $annotations = $reader->getMethodAnnotations($class, $methodName);
        return $annotations->get("name");
    }
}

