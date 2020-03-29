<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/1/17
 * Time: 10:47
 */
return [
    'code_pre'      => 'mall_code_pre:',
    'code_exire'   => 60,
    'token_pre'     => 'mall_token_pre:',
    'cart_pre'      => 'mall_cart_',
    // 延迟队列 - 订单是否需要取消状态检查
    'order_status_key'  => 'order_status',
    'order_expire'  => 20*60,
];
