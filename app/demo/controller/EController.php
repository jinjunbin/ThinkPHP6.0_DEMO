<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/1/14
 * Time: 16:35
 */
namespace app\demo\controller;

use app\BaseController;

class EController extends BaseController
{
    public function index()
    {
        //throw new \think\exception\HttpException(404, '找不到');
        echo $abc;
    }

    public function abc()
    {
        //dump(2);
        dump($this->request->type);
    }
}
