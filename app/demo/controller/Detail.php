<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/1/14
 * Time: 16:35
 */
namespace app\demo\controller;

use app\BaseController;

class Detail extends BaseController
{
    public function index()
    {
        dump(333);
        dump($this->request->type);
    }
}
