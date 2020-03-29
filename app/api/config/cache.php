<?php

// +----------------------------------------------------------------------
// | 缓存设置
// +----------------------------------------------------------------------

return [
    // 默认缓存驱动
    'default' => env('cache.driver', 'redis'),

    // 缓存连接方式配置
    'stores'  => [
        'file' => [
            // 驱动方式
            'type'       => 'File',
            // 缓存保存目录
            'path'       => app()->getRuntimePath() . 'cache' . DIRECTORY_SEPARATOR,
            // 缓存前缀
            'prefix'     => '',
            // 缓存有效期 0表示永久缓存
            'expire'     => 0,
            // 缓存标签前缀
            'tag_prefix' => 'tag:',
            // 序列化机制 例如 ['serialize', 'unserialize']
            'serialize'  => [],
        ],
        // 更多的缓存连接
        'redis' => [
            'type'      => 'redis',
            'host'      => '127.0.0.1',
            'port'      => '6379',
            'password'  => '123456',
        ],
        /*tp6-mall/vendor/topthink/framework/src/think/cache/driver/Redis.php
        1. string
            发送验证码   Cache(key, value, time)
            登录 token  Cache(key, value, time)
            商品计数器   Cache::inc('mall_pv_'.$goods_id)
        2. hash
            购物车        $key        $hashKey        $value
            Cache::hGet('mall_cart_'.$this->userId, $goods_id)  //获取某个 $hashKey 的值
            Cache::hMget('mall_cart_'.$this->userId, $goods_ids)//获取某些 $hashKey 的值
            Cache::hGetAll('mall_cart_'.$this->userId)  //获取 $key 下所有 $hashKey 的值
            Cache::hLen('mall_cart_'.$this->userId)     //获取 $key 下所有 $hashKey 数量
            Cache::hSet('mall_cart_'.$this->userId, $goods_id, json_encode($data))
            Cache::hDel('mall_cart_'.$this->userId, ...$goods_id)
            子主题
        3. 有序集合 延迟队列
            Cache::zAdd('order_status', time(), $orderId)   //存入有序集合
            Cache::zRangeByScore('order_status', 0, time(), ['limit' => [0, 1]]) //获取0-当前时间内的1条数据
            Cache::zRem('order_status', $result[0])         //删除第0个结果
        */
    ],
];
