<?php

namespace app\wechat\exception;

class UserException extends BaseException
{
    public $httpStatus = 404;
    public $message = '用户不存在';
    public $status = 60000;
}
