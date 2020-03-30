<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/2/28
 * Time: 17:43
 */
namespace app\api\controller\mall;

use app\api\controller\AuthBase;
use app\common\business\Cart as CartBis;
use app\common\lib\Show;

class Init extends AuthBase
{
    public function index()
    {
        if (!$this->request->isPost()) {
            return Show::error();
        }

        $count = (new CartBis())->getCount($this->userId);
        $result = [
            'cart_num' => $count
        ];
        return Show::success($result);
    }
}
