<?php

namespace App\Library\Format;

/**
 * Class FormatMoney
 * @package App\Library\Common
 */
class FormatData
{
    public static function columnToRow($data, $field)
    {
        $v = [];
        $list = end($data);
        foreach ($list as $k=>$item) {
            $array = [];
            foreach ($field as $n) {
                $array[$n] = $data[$n][$k];
            }
            $v[] = $array;
        }
        return $v;
    }
}
