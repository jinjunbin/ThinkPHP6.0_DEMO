<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/2/28
 * Time: 19:46
 */
namespace app\common\business;

use app\common\model\mysql\OrderGoods as OrderGoodsModel;

class OrderGoods extends BusBase
{
    public $model = null;

    public function __construct()
    {
        $this->model = new OrderGoodsModel();
    }

    public function saveAll($data)
    {
        try {
            $result = $this->model->saveAll($data);
            return $result->toArray();
        } catch (\Exception $e) {
            //echo $e->getMessage();die;
            // 记录日志
            return false;
        }
    }

    /**
     * 根据订单ID 获取order_goods表中的数据
     * @param $orderId
     * @return array|bool|\think\Collection
     */
    public function getByOrderId($orderId)
    {
        $condition = [
            "order_id" => $orderId,
        ];

        try {
            $orders = $this->model->getByCondition($condition);
        } catch (\Exception $e) {
            $orders = [];
        }
        if (!$orders) {
            return [];
        }

        $orders = $orders->toArray();
        return $orders;
    }
}
