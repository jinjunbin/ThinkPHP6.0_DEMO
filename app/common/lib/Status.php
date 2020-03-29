<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/2/25
 * Time: 0:47
 */
namespace app\common\lib;

class Status
{
    public static function getTableStatus()
    {
        $mysqlStatus = config('status.mysql');
        return array_values($mysqlStatus);
    }

    /**
     * Show::error调用
     * @param $status
     * @return string
     */
    public static function getErrMsg($status)
    {
        $error_code = config('status.error_code');
        return isset($error_code[$status]) ? $error_code[$status] : '';
    }
}
