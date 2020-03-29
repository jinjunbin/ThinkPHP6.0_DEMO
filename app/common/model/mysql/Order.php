<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/2/28
 * Time: 19:47
 */
namespace app\common\model\mysql;

class Order extends BaseModel
{
    public function getIdByName($name)
    {
        if (empty($name['order_id'])) {
            return false;
        }

        $where = [
            'order_id' => trim($name['order_id']),
        ];

        $result = $this->where($where)->find();

        return $result;
    }
}
