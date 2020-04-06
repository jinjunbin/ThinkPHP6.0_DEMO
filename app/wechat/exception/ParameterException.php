<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/4/5 0004
 * Time: 00:29
 */

namespace app\wechat\exception;

/**
 * Class ParameterException
 * 通用参数类异常错误
 */
class ParameterException extends BaseException
{
    public $httpStatus = 400;
    public $message = "invalid parameters";
    public $status = 10000;
}