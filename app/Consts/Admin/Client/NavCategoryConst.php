<?php

namespace App\Consts\Admin\Client;

class NavCategoryConst
{
    const HEADER = 1;

    const HEADER_DESC = '头部';

    public static function desc()
    {

        return [
            self::HEADER => self::HEADER_DESC,
        ];
    }

    public static function getDesc($item)
    {
        return array_get(self::desc(), $item);
    }

}