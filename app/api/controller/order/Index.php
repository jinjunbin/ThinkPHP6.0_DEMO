<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/2/28
 * Time: 19:37
 */
namespace app\api\controller\order;

use app\api\controller\AuthBase;
use app\common\lib\Show;
use app\common\business\Order as OrderBis;

class Index extends AuthBase
{
    /**
     * 创建订单
     * @return \think\response\Json
     */
    public function save()
    {
        $addressId = input('param.address_id', 0, 'intval');
        $ids = input('param.ids', '', 'trim');
        // 参数校验
        $data = [
            'ids' => $ids,
            'address_id' => $addressId,
            'user_id' => $this->userId,
        ];
        $validate = new \app\api\validate\Order();
        if (!$validate->scene('save')->check($data)) {
            return Show::error($validate->getError());
        }

        try {
            $result = (new OrderBis())->save($data);
        } catch (\Exception $e) {
            return Show::error($e->getMessage(), $e->getCode());
        }
        if (!$result) {
            return Show::error('提交订单失败, 请稍后重试');
        }
        return Show::success($result);
    }

    /**
     * 获取订单详情
     * @return \think\response\Json
     */
    public function read()
    {
        $id = input('param.id', '0', 'trim');
        // 参数校验
        $data = [
            'order_id' => $id,
            'user_id' => $this->userId,
        ];
        $validate = new \app\api\validate\Order();
        if (!$validate->scene('read')->check($data)) {
            return Show::error($validate->getError());
        }

        $result = (new OrderBis())->detail($data);
        if (!$result) {
            return Show::error('获取订单失败');
        }
        return Show::success($result);
    }
}
