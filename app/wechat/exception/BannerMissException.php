<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/4/4 0004
 * Time: 上午 12:58
 */

namespace app\wechat\Exception;

class BannerMissException extends BaseException
{
    public $httpStatus  = 404;
    public $message     = 'global:your required resource are not found';
    public $status      = 10001;


}
