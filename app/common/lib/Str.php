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
        $token = sha1($str . $string); //加密
        return $token;
    }

    /**
     * 32 个字符串自成一组随机字符串
     * @param $length
     * @return string|null
     */
    public static function getRandChar($length)
    {
        $str = null;
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol) - 1;

        for ($i = 0; $i < $length; $i++) {
            $str .= $strPol[rand(0, $max)];
        }

        return $str;
    }
}
