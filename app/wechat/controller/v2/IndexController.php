<?php

namespace app\wechat\controller\v2;

use app\wechat\controller\WechatBaseController;

class IndexController extends WechatBaseController
{
    public function hello($name = '222')
    {
        return 'hello,' . $name;
    }

}