<?php

namespace app\wechat\controller\v1;

use app\wechat\controller\WechatBaseController;

class IndexController extends WechatBaseController
{
    public function hello($name = '111')
    {
        return 'hello,' . $name;
    }

}
