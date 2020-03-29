<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/2/28
 * Time: 15:18
 */
namespace app\api\validate;

use think\Validate;

class Order extends Validate
{
    protected $rule = [
        'ids' => 'require',
        'address_id' => 'require|number|>:0',
        'order_id' => 'require',
    ];

    protected $message = [
        'ids.require' => '商品id必须',
        'address_id.require' => '收货地址数量必须',
        'address_id.number' => '收货地址必须为数字',
        'order_id.require' => '订单id必须',
    ];

    protected $scene = [
        'save' => ['ids','address_id'],
        'read' => ['order_id'],
    ];
}
