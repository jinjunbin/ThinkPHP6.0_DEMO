<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/1/17
 * Time: 14:11
 */
namespace app\common\lib;

class Str
{
    /**
     * 生成登录所需的token
     * @param $string
     * @return string
     */
    public static function getLoginToken($string)
    {
        // 生成 token
        $str = md5(uniqid(md5(microtime(true), true))); //生成一个不会重复的字符串
        $token = sha1($str.$string); //加密
        return $token;
    }
}
