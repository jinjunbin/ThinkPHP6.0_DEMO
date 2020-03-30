<?php

namespace app\wechat\controller\v1;

use app\wechat\controller\WechatBase;

class Index extends WechatBase
{
    public function hello($name = '111')
    {
        return 'hello,' . $name;
    }

}
