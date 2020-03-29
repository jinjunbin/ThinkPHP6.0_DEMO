<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/2/28
 * Time: 19:46
 */
namespace app\common\business;

use app\common\lib\Snowflake;
use app\common\model\mysql\Order as OrderModel;
use app\common\model\mysql\OrderGoods as OrderGoodsModel;
use think\facade\Cache;

class Order extends BusBase
{
    public $model = null;

    public function __construct()
    {
        $this->model = new OrderModel();
    }

    public function save($data)
    {
        // 拿到一个订单号
        $workId = rand(1, 1023);
        $orderId = Snowflake::getInstance()->setWorkId($workId)->id();
        $orderId = (string)$orderId;

        // 获取购物车数据 => redis
        $carObj = new Cart();
        $result = $carObj->lists($data['user_id'], $data['ids']);
        if (!$result) {
            return false;
        }
        // $v 是 $result 的每一条数据
        $newResult = array_map(function ($v) use ($orderId) {
            $v['sku_id'] = $v['id'];
            unset($v['id']);
            $v['order_id'] = $orderId;  // $orderId 在外层, 传入需要 use 一下
            $v['create_time'] = time();
            return $v;
        }, $result);
        // 订单总价
        $price = array_sum(array_column($result, 'total_price'));
        $orderData = [
            'user_id' => $data['user_id'],
            'order_id' => $orderId,
            'total_price' => $price,
            'address_id' => $data['address_id'],
        ];

        $this->model->startTrans();//开启事务
        try {
            // 新增 order
            $id = $this->add($orderData);
            if (!$id) {
                return 0;
            }
            // 新增 order_goods
            // 不调用 business/OrderGoods 的 save (异常返回[], 就需要多一层判断)
            // 直接调用 model/OrderGoods (异常直接 catch 捕获)
            $orderGoodsResult = (new OrderGoodsModel())->saveAll($newResult);
            // goods_sku 更新库存
            $skuRes = (new GoodsSku())->updateStock($result);
            // goods 更新 => 消息队列异步处理
            // 删除购物车里面的商品
            $carObj->deleteRedis($data['user_id'], $data['ids']);
            $this->model->commit();

            // 把当前订单ID 放入延迟队列中， 定期检测订单是否已经支付 （因为订单有效期是20分钟，超过这个时间还没有支付的，
            // 我们需要把这个订单取消 ， 然后库存+操作）小伙伴需要举一反三，比如其他场景也可以用到延迟队列：发货提醒等
            // 学习就是要不断的提升自己，老师授的只是思路，我们需要举一反三，从而提升自己
            try {
                Cache::zAdd(config("redis.order_status_key"), time() + config("redis.order_expire"), $orderId);
            } catch (\Exception $e) {
                // 记录日志， 添加监控 ，异步根据监控内容处理。
                //echo $e->getMessage();
            }

            return ["id" => $orderId];
        } catch (\Exception $e) {
            $this->model->rollback();
            echo $e->getMessage();
            return false;
        }
    }

    public function detail($data)
    {
        // user_id 订单ID组合查询
        $conditon = [
            "user_id" => $data['user_id'],
            "order_id" => $data['order_id'],
        ];
        try {
            $orders = $this->model->getByCondition($conditon);
        } catch (\Exception $e) {
            $orders = [];
        }
        if (!($orders)) {
            return [];
        }
        $orders = $orders->toArray();
        $orders = !empty($orders) ? $orders[0] : [];
        if (empty($orders)) {
            return [];
        }

        $orders['id'] = $orders['order_id'];
        // 模拟地址， 关于真实地址需要同学们自行完成。 加油
        $orders['consignee_info'] = "江西省 抚州市 东校区 xxx";

        // 根据order_id查询 order_goods表信息数据
        $orderGoods = (new OrderGoods())->getByOrderId($data['order_id']);

        $orders['malls'] = $orderGoods;
        return $orders;
    }

    /**
     * @return bool
     */
    public function checkOrderStatus()
    {
        //tp6 bug(12-11): command 只能获取根目录下的 config/cache.php 文件, 要把 api/config/cache.php 复制出去
        //               配置文件也只能获取根目录下的, 所以先写死 order_status, 配置在 api/config/redis.php
        $result = Cache::store('redis_tp')->zRangeByScore("order_status", 0, time(), ['limit' => [0, 1]]);

        if (empty($result) || empty($result[0])) {
            return false;
        }

        try {
            $delRedis = Cache::store('redis_tp')->zRem("order_status", $result[0]);
        } catch (\Exception $e) {
            // 记录日志
            $delRedis = "";
        }
        if ($delRedis) {
            echo "订单id:{$result[0]}在规定时间内没有完成支付 我们判定为无效订单删除".PHP_EOL;
            /**
             * 第一步： 根据订单ID 去数据库order表里面获取当前这条订单数据 看下当前状态是否是待支付:status = 1
             *        如果是那么我们需要把状态更新为 已取消 status = 7， 否则不需要care
             *
             * 第二步： 如果第一步status修改7之后， 我们需要再查询order_goods表， 拿到 sku_id num  把sku表数据库存增加num
             *        goods表总库存也需要修改。
             *
             *
             */
        } else {
            return false;
        }

        return true;
    }
}
