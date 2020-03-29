<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/2/28
 * Time: 16:02
 */
namespace app\common\lib;

class Key
{
    /**
     * 记录用户购物车的 redis key
     * @param $userId
     * @return string
     */
    public static function userCart($userId)
    {
        return config('redis.cart_pre').$userId;
    }
}
