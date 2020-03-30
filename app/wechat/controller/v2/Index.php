<?php

namespace app\wechat\controller\v2;

use app\wechat\controller\WechatBase;

class Index extends WechatBase
{
    public function hello($name = '222')
    {
        return 'hello,' . $name;
    }

}