<?php

namespace App\Consts\Admin\Client;

class PageTemplateConst
{
    const ALL = 0;
    const PAGE = 1;
    const NEWS = 2;

    const ALL_DESC = '全部';
    const PAGE_DESC = '单页';
    const NEWS_DESC = '信息列表';

    public static function desc($arr = false)
    {

        $array =  [
            self::PAGE => self::PAGE_DESC,
            self::NEWS => self::NEWS_DESC,
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


    public static function getAdminRoute($template)
    {
        switch($template) {
            case self::NEWS:
                return 'm.client.news.list';
            default :
                return '';
        }
    }

    public static function getWebRoute($template)
    {
        switch($template) {
            case self::PAGE:
                return 'w.page';
            case self::NEWS:
                return 'w.news';
            default :
                return '';
        }
    }
}
