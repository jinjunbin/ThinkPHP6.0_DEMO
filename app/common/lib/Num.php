<?php
/**
 * Num 记录和数字相关的类库中的方法
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/1/17
 * Time: 11:26
 */
declare(strict_types=1);
namespace app\common\lib;

class Num
{
    /**
     * @param int $len
     * @return int
     */
    public static function getCode(int $len = 4)
    {
        if ($len == 6) {
            $code = rand(100000, 999999);
        } else {
            $code = rand(1000, 9999);
        }

        return $code;
    }
}
