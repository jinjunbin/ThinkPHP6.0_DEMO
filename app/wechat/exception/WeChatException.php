<?php

namespace app\wechat\exception;

/**
 * 微信服务器异常
 */
class WeChatException extends BaseException
{
    public $httpStatus = 400;
    public $message = 'wechat unknown error';
    public $status = 999;
}
