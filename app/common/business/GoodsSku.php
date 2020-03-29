<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/2/26
 * Time: 15:34
 */
namespace app\common\business;

use app\common\model\mysql\GoodsSku as GoodsSkuModel;

class GoodsSku extends BusBase
{
    public $model = null;

    public function __construct()
    {
        $this->model = new GoodsSkuModel();
    }

    /**
     * 批量新增逻辑
     * @param $data
     * @return array|bool
     */
    public function saveAll($data)
    {
        if (!$data['skus']) {
            return false;
        }

        foreach ($data['skus'] as $value) {
            $insertData[] = [
                'goods_id' => $data['goods_id'],
                'specs_value_ids' => $value['propvalnames']['propvalids'],
                'price' => $value['propvalnames']['skuSellPrice'],
                'cost_price' => $value['propvalnames']['skuMarketPrice'],
                'stock' => $value['propvalnames']['skuStock'],
                'status' => config('status.mysql.table_normal'),
            ];
        }

        //number_format round
        try {
            $result = $this->model->saveAll($insertData);
            return $result->toArray();
        } catch (\Exception $e) {
            //echo $e->getMessage();die;
            // 记录日志
            return false;
        }
        return true;
    }

    public function getNormalSkuAndGoods($id)
    {
        try {
            // 2次 sql 查询
            $result= $this->model->with('goods')->find($id);
            // join 查询
            //$result= $this->model->withJoin('goods')->find($id);
        } catch (\Exception $e) {
            //echo $e->getMessage();
            return [];
        }
        if (!$result) {
            return [];
        }
        $result = $result->toArray();
        if ($result['status'] != config('status.mysql.table_normal')) {
            return [];
        }
        return $result;
    }

    public function getSkusByGoodsId($goodsId = 0)
    {
        if (!$goodsId) {
            return [];
        }
        try {
            $skus = $this->model->getNormalByGoodsId($goodsId);
        } catch (\Exception $e) {
            return [];
        }
        return $skus->toArray();
    }

    public function getNormalInIds($ids)
    {
        if (!$ids) {
            return [];
        }
        try {
            $result = $this->model->getNormalInIds($ids);
        } catch (\Exception $e) {
            return [];
        }
        $result = $result->toArray();
        if (!$result) {
            return [];
        }
        return $result;
    }

    public function updateStock($data)
    {
        // 性能瓶颈
        foreach ($data as $value) {
            $this->model->decStock($value['id'], $value['num']);
        }
        // 改成批量更新方式去做

        return true;
    }
}
