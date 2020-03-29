<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/1/17
 * Time: 14:45
 */

namespace app\common\lib;

class Time
{
    public static function userLoginExpiresTime($type = 2)
    {
        $type = !in_array($type, [1, 2]) ? 2 : $type;
        if ($type == 1) {
            $day = 7;
        } elseif ($type == 2) {
            $day = 30;
        }
        return $day * 24 * 3600;
    }
}
