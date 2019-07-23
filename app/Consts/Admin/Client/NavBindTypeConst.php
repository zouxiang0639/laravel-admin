<?php

namespace App\Consts\Admin\Client;

class NavBindTypeConst
{
    const BIND_PAGE = 1;
    const BIND_URL = 2;

    const BIND_PAGE_DESC = '绑定页面';
    const BIND_URL_DESC = '绑定URL';

    public static function desc()
    {

        return [
            self::BIND_PAGE => self::BIND_PAGE_DESC,
            self::BIND_URL => self::BIND_URL_DESC,
        ];
    }

    public static function getDesc($item)
    {
        return array_get(self::desc(), $item);
    }

}