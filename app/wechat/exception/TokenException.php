<?php

namespace app\wechat\exception;

/**
 * token验证失败时抛出此异常
 */
class TokenException extends BaseException
{
    public $httpStatus = 401;
    public $message = 'Token已过期或无效Token';
    public $status = 10001;
}
