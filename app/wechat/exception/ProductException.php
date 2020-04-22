<?php

namespace app\wechat\exception;

class ProductException extends BaseException
{
    public $httpStatus  = 404;
    public $message     = '指定商品不存在，请检查商品ID';
    public $status      = 20000;
}
