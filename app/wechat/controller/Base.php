<?php

namespace app\wechat\controller;

use app\api\service\Token;
use app\BaseController;

class Base extends BaseController
{
    protected function checkExclusiveScope()
    {
        Token::needExclusiveScope();
    }

    protected function checkPrimaryScope()
    {
        Token::needPrimaryScope();
    }

    protected function checkSuperScope()
    {
        Token::needSuperScope();
    }
}
