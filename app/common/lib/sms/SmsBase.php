<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/1/17
 * Time: 13:42
 */
declare(strict_types=1);
namespace app\common\lib\sms;

interface SmsBase
{
    public static function sendCode(string $phone, int $code);
}
