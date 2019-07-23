<?php

namespace App\Consts\Admin\Client;

class NavCategoryConst
{
    const HEADER = 1;
    const a = 2;

    const HEADER_DESC = '头部';
    const a_DESC = 'a';

    public static function desc()
    {

        return [
            self::HEADER => self::HEADER_DESC,
            self::a => self::a_DESC,
        ];
    }

    public static function getDesc($item)
    {
        return array_get(self::desc(), $item);
    }

}