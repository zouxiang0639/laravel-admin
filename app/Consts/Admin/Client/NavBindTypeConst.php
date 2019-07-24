<?php

namespace App\Consts\Admin\Client;

class NavBindTypeConst
{
    const BIND_PAGE = 1;
    const BIND_URL = 2;
    const JUMP = 3;

    const BIND_PAGE_DESC = '绑定页面';
    const BIND_URL_DESC = '绑定URL';
    const JUMP_DESC = '跳转下级';

    public static function desc()
    {

        return [
            self::BIND_PAGE => self::BIND_PAGE_DESC,
            self::BIND_URL => self::BIND_URL_DESC,
            self::JUMP => self::JUMP_DESC,
        ];
    }

    public static function getDesc($item)
    {
        return array_get(self::desc(), $item);
    }

}