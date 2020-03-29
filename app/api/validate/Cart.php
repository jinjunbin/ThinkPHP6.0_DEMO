<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/2/28
 * Time: 15:18
 */
namespace app\api\validate;

use think\Validate;

class Cart extends Validate
{
    protected $rule = [
        'id' => 'require|number|>:0',
        'num' => 'require|number|>:0',
        'code' => 'require|number|min:4',
        //'type' => 'require|in:1,2',
        'type' => ['require', 'in'=>'1,2'],// 两种不同的方式而已
        'sex' => ['require', 'in'=>'0,1,2'],
    ];

    protected $message = [
        'id.require' => '商品id必须',
        'id.number' => '商品id必须为数字',
        'num.require' => '加入购物车数量必须',
        'num.number' => '加入购物车数量必须为数字',
        'code.require' => '短信验证码必须',
        'code.number' => '短信验证码必须为数字',
        'code.min' => '短信验证码长度不得低于4位',
        'type.require' => '类型必须',
        'type.in' => '类型数值错误',
        'sex.require' => '性别必须',
        'sex.in' => '性别数值错误',
    ];

    protected $scene = [
        'add' => ['id','num'],
        'delete' => ['id'],
        'update' => ['id','num'],
    ];
}
