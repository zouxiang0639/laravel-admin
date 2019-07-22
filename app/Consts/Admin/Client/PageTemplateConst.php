<?php

namespace App\Consts\Admin\Client;

class PageTemplateConst
{
    const ALL = 0;
    const PAGE = 1;
    const INFO = 2;

    const ALL_DESC = '全部';
    const PAGE_DESC = '单页';
    const INFO_DESC = '信息列表';

    public static function desc($arr = false)
    {

        $array =  [
            self::PAGE => self::PAGE_DESC,
            self::INFO => self::INFO_DESC,
        ];

        if($arr) {
            return array_merge([self::ALL => self::ALL_DESC], $array);
        }
        return $array;
    }

    public static function getDesc($item)
    {
        return array_get(self::desc(), $item);
    }

}