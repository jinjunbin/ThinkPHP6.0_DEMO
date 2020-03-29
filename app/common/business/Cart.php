<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/2/28
 * Time: 15:45
 */
namespace app\common\business;

use app\common\lib\Arr;
use app\common\lib\Key;
use think\facade\Cache;

class Cart extends BusBase
{
    public function insertRedis($userId, $id, $num)
    {
        // id获取商品数据
        $GoodsSku = (new GoodsSku())->getNormalSkuAndGoods($id);
        if (!$GoodsSku) {
            return false;
        }
        $data = [
            'title' => $GoodsSku['goods']['title'],
            'image' => $GoodsSku['goods']['recommend_image'],
            'num' => $num,
            'goods_id' => $GoodsSku['goods']['id'],
            'create_time' => time(),
        ];

        try {
            $get = Cache::hGet(Key::userCart($userId), $id);
            if ($get) {
                $get = json_decode($get, true);
                $data['num'] += $get['num'];
            }

            // $data['num'] 与 $GoodsSku 库存对比
            if (isset($GoodsSku['stock']) && $GoodsSku['stock'] < $data['num']) {
                throw new \think\Exception($GoodsSku['goods']['title'].'的商品库存不足');
            }
            $res = Cache::hSet(Key::userCart($userId), $id, json_encode($data));
        } catch (\Exception $e) {
            //dump($e->getMessage());die;
            return false;
        }
        return $res;
    }

    /**
     * 3个地方用到, 购物车页面(不传$ids), 订单确认页面, 订单提交按钮(获取购物车数据做判断)
     * @param $userId
     * @param $ids
     * @return array
     * @throws \think\Exception
     */
    public function lists($userId, $ids)
    {
        try {
            if ($ids) {
                $ids = explode(',', $ids);
                $res = Cache::hMget(Key::userCart($userId), $ids);
                if (in_array(false, array_values($res))) {
                    return [];
                }
            } else {
                $res = Cache::hGetAll(Key::userCart($userId));
            }
        } catch (\Exception $e) {
            //dump($e->getMessage());die;
            $res = [];
        }
        if (!$res) {
            return [];
        }

        $result = [];
        $skuIds = array_keys($res);
        $skus = (new GoodsSku())->getNormalInIds($skuIds);

        // 库存
        $stocks = array_column($skus, 'stock', 'id');

        $skuIdPrice = array_column($skus, 'price', 'id');
        $skuIdSpecsValueIds = array_column($skus, 'specs_value_ids', 'id');
        $SpecsValues = (new SpecsValue())->dealSpecsValue($skuIdSpecsValueIds);
        foreach ($res as $k => $v) {
            $price = $skuIdPrice[$k] ?? 0;
            $v = json_decode($v, true);

            // 库存
            if ($ids && isset($stocks[$k]) && $stocks[$k] < $v['num']) {
                throw new \think\Exception($v['title'].'的商品库存不足');
            }

            $v['id'] = $k;
            $v['image'] = preg_match("/http/", $v['image']) ? $v['image'] : request()->domain().$v['image'];
            $v['price'] = $price;
            $v['total_price'] = $price * $v['num'];
            $v['sku'] = $SpecsValues[$k] ?? '暂无规格';
            $result[] = $v;
        }
        //排序
        if (!empty($result)) {
            $result = Arr::arrsSortByKey($result, 'create_time');
        }
        return $result;
    }

    /**
     * 删除购物车功能
     * @param $userId
     * @param $id
     * @return bool
     */
    public function deleteRedis($userId, $ids)
    {
        if (!is_array($ids)) {
            $ids = explode(',', $ids);// id=1 => [1] .  1,2,5,6 => [1, 2, 5, 6]
        }
        try {
            // ... 是PHP提供的一个特性, 可变参数
            $res = Cache::hDel(Key::userCart($userId), ...$ids);
        } catch (\Exception $e) {
            return false;
        }

        return $res;
    }

    /**
     * 更新购物车中的商品数量
     * @param $userId
     * @param $id
     * @param $num
     * @return bool
     * @throws \think\Exception
     */
    public function updateRedis($userId, $id, $num)
    {
        try {
            $get = Cache::hGet(Key::userCart($userId), $id);
        } catch (\Exception $e) {
            return false;
        }
        // id获取商品数据
        $GoodsSku = (new GoodsSku())->getNormalSkuAndGoods($id);
        if (!$GoodsSku) {
            return false;
        }

        if ($get) {
            $get = json_decode($get, true);
            $get['num'] = $num;
        } else {
            throw new \think\Exception('不存在该购物车的商品, 您更新没有任何意义');
        }
        try {
            // $get['num'] 与 $GoodsSku 库存对比
            if (isset($GoodsSku['stock']) && $GoodsSku['stock'] < $get['num']) {
                throw new \think\Exception($GoodsSku['goods']['title'].'的商品库存不足');
            }
            $res = Cache::hSet(Key::userCart($userId), $id, json_encode($get));
        } catch (\Exception $e) {
            return false;
        }

        return $res;
    }

    /**
     * 获取购物车数量
     * @param $userId
     * @return int
     */
    public function getCount($userId)
    {
        try {
            $count = Cache::hLen(Key::userCart($userId));
        } catch (\Exception $e) {
            return 0;
        }
        return intval($count);
    }
}
