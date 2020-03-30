<?php
declare (strict_types = 1);

namespace app\admin\controller;

use think\facade\View;

class Index extends AdminBase
{
    public function index()
    {
        return View::fetch();
        //return '您好！这是一个[admin]示例应用';
    }

    public function welcome()
    {
        return View::fetch();
    }
}
