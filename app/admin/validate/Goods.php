<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/2/23
 * Time: 21:53
 */
namespace app\admin\validate;

use think\Validate;

class Goods extends Validate
{
    protected $rule = [
        'title' => 'require',
        'category_id' => 'require',
        'sub_title' => 'require',
        'promotion_title' => 'require',
        'keywords' => 'require',
        'goods_unit' => 'require',
        'is_show_stock' => 'require|number',
        'stock' => 'require|number',
        'production_time' => 'require',
        'goods_specs_type' => 'require|number|in:1,2',
        'skus' => 'require',
        'big_image' => 'require',
        'carousel_image' => 'require',
        'recommend_image' => 'require',
        'description' => 'require',
        'add_spec_arr' => ['require'],
    ];

    protected $message = [
        'title' => '商品名称必须',
        'category_id' => '分类必须',
        'sub_title' => '商品副标题必须',
        'promotion_title' => '商品促销语必须',
        'keywords' => '关键词必须',
        'goods_unit' => '商品单位必须',
        'is_show_stock.require' => '库存显示必须',
        'is_show_stock.number' => '库存显示必须为数字',
        'stock.require' => '总库存必须',
        'stock.number' => '总库存必须为数字',
        'production_time' => '生产日期必须',
        'goods_specs_type.require' => '商品规格必须',
        'goods_specs_type.number' => '商品规格必须为数字',
        'goods_specs_type.in' => '商品规格必须为数字1,2',
        'skus' => 'sku必须',
        'big_image' => '大图必须',
        'carousel_image' => '轮播图必须',
        'recommend_image' => '展示图必须',
        'description' => '商品详情必须',
        'add_spec_arr' => '提交的规格数据必须',
    ];

    protected $scene = [
        'save' => ['title','category_id','sub_title',
            'promotion_title','keywords','goods_unit',
            'is_show_stock','stock','production_time',
            'goods_specs_type','carousel_image',
            'recommend_image','description'
        ],
    ];
}
