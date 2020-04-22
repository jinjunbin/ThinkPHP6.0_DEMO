<?php

namespace app\wechat\exception;

class CategoryException extends BaseException
{
    public $httpStatus  = 404;
    public $message     = '指定类目不存在，请检查商品ID';
    public $status      = 50000;
}
