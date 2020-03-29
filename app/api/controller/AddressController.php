<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/2/28
 * Time: 18:59
 */
namespace app\api\controller;

use app\common\lib\Show;

class AddressController extends AuthBaseController
{
    public function index()
    {
        // 获取该用户下所有设置的收货地址
        $result = [
            [
                'id' => 1,
                'consignee_info' => '上海市 普陀区',
                'is_default' => 1,
            ],
            [
                'id' => 2,
                'consignee_info' => '上海市 静安区',
                'is_default' => 0,
            ],
            [
                'id' => 3,
                'consignee_info' => '上海市 浦东新区',
                'is_default' => 0,
            ],
        ];
        return Show::success($result);
    }
}
