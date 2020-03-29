<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/1/14
 * Time: 9:59
 */

namespace app\api\controller;

use app\common\lib\Show;

class ErrorController
{
    public function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
        return Show::error('controller_not_found', config('status.controller_not_found'),  404);
    }
}
