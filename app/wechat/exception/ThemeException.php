<?php

namespace app\wechat\exception;

class ThemeException extends BaseException
{
    public $httpStatus  = 404;
    public $message     = '指定主题不存在，请检查主题ID';
    public $status      = 30000;
}
