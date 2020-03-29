<?php

namespace app\wechat\controller;

class IndexController extends WechatBaseController
{
    public function index($name = 'index')
    {
        return 'hello,' . $name;
    }
    
    public function hello($name = '000')
    {
        return 'hello,' . $name;
    }
}
