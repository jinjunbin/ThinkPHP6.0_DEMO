<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/2/26
 * Time: 15:40
 */
namespace app\common\model\mysql;

class GoodsSku extends BaseModel
{
    public function goods()
    {
        return $this->hasOne(Goods::class, 'id', 'goods_id');
        //return $this->belongsTo(Goods::class, 'goods_id', 'id');
        /*https://coding.imooc.com/learn/questiondetail/17608.html
        如果外键在当前模型里面，则使用使用belongsTo来关联模型；
        如果外键在关联的模型里面， 则使用hasOne来关联模型；
        比如：
        Banner模型关联BannerItem模型，外键在BannerItem中， 使用hasOne来关联BannerItem模型
        Theme模型关联Image模型， 外键在Theme模型里， 使用belongsTo来关联Image模型
        BannerItem模型关联Image模型， 外键在BannerItem模型里， 使用belongsTo来关联Image模型*/
        //所以 return $this->hasMany(GoodsSku::class, 'goods_id', 'id'); 应该在 GoodsModel 里
    }

    public function getNormalByGoodsId($goodsId = 0)
    {
        $where = [
            'goods_id' => $goodsId,
            'status' => config('status.mysql.table_normal')
        ];

        return $this->where($where)->select();
    }

    public function decStock($id, $num)
    {
        return $this->where('id', '=', $id)
            ->dec('stock', $num)
            ->update();
    }
}
