<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/1/16
 * Time: 16:29
 */
declare(strict_types=1);
namespace app\common\lib\sms;

class BaiduSms implements SmsBase
{
    public static function sendCode(string $phone, int $code) : bool
    {
        return true;
    }
}
