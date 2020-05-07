<?php

namespace app\wechat\exception;

/**
 * token验证失败时抛出此异常
 */
class ForbiddenException extends BaseException
{
    public $httpStatus = 403;
    public $message = '权限不够';
    public $status = 10001;
}
