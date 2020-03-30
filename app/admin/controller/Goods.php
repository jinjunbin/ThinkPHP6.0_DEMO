<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/2/25
 * Time: 22:01
 */
namespace app\admin\controller;

use app\common\business\Goods as GoodsBis;
use app\common\lib\Show;

class Goods extends AdminBase
{
    public function index()
    {
        $data = [];
        $title = input('param.title', '', 'trim');
        $time = input('param.time', '', 'trim');
        if (!empty($title)) {
            $data['title'] = $title;
        }
        if (!empty($time)) {
            $data['create_time'] = explode('-', $time);
        }

        $goods = (new GoodsBis())->getLists($data, 5);
        return View('', [
            'goods' => $goods,
        ]);
    }

    public function add()
    {
        return View();
    }

    public function save()
    {
        // 判断是否为POST请求, 也可以通过理由中的配置支持POST即可
        if (!$this->request->isPost()) {
            return Show::error('参数不合法');
        }

        //参数校验
        $data = input('param.');
        $check = $this->request->checkToken('__token__');
        if (!$check) {
            return Show::error('非法请求');
        }
        /*^ array:16 [
          "title" => "111"
          "category_id" => "2,10,11"
          "sub_title" => "222"
          "promotion_title" => "333"
          "keywords" => "444"
          "goods_unit" => "台"
          "is_show_stock" => "1"
          "stock" => "400"
          "production_time" => "2020-02-03"
          "goods_specs_type" => "2"
          "big_image" => "/upload/image/20200226\f2b0f083a8c73651d4de9f840e889de1.jpg"
          "carousel_image" => "/upload/image/20200226\f6cb788060825f6402ec8f6857cc1846.jpg,/upload/image/20200226\c328a462472b693ee5a8cc7ca6996b00.jpg"
          "recommend_image" => "/upload/image/20200226\fd145ea3e0e947359f31463c185b68e0.jpg"
          "skus" => array:4 [
            0 => array:6 [
              0 => "8G"
              1 => "红色"
              2 => "100"
              3 => "100"
              4 => "101"
              "propvalnames" => array:4 [
                "propvalids" => "7,1"
                "skuSellPrice" => "100"
                "skuMarketPrice" => "101"
                "skuStock" => "100"
              ]
            ]
            1 => array:6 [
              0 => "8G"
              1 => "白色"
              2 => "100"
              3 => "100"
              4 => "101"
              "propvalnames" => array:4 [
                "propvalids" => "7,2"
                "skuSellPrice" => "100"
                "skuMarketPrice" => "101"
                "skuStock" => "100"
              ]
            ]
            2 => array:6 [
              0 => "16G"
              1 => "红色"
              2 => "200"
              3 => "100"
              4 => "201"
              "propvalnames" => array:4 [
                "propvalids" => "8,1"
                "skuSellPrice" => "200"
                "skuMarketPrice" => "201"
                "skuStock" => "100"
              ]
            ]
            3 => array:6 [
              0 => "16G"
              1 => "白色"
              2 => "200"
              3 => "100"
              4 => "201"
              "propvalnames" => array:4 [
                "propvalids" => "8,2"
                "skuSellPrice" => "200"
                "skuMarketPrice" => "201"
                "skuStock" => "100"
              ]
            ]
          ]
          "description" => "<p>112222<img src="http://1.cn/static/admin/lib/layui-v2.5.4/images/face/0.gif" alt="[微笑]"></p><p><img src="/upload/image/20200226\7c8af47bc1d91ed7457e3611662564d2.jpg" alt="undefined"><br></p>"
          "add_spec_arr" => array:1 [
            0 => array:1 [
              "project" => ""
            ]
          ]
        ]*/
        $validate = new \app\admin\validate\Goods();
        if (!$validate->scene('save')->check($data)) {
            return Show::error($validate->getError());
        }

        //数据处理 => 基于验证成功之后
        $data['category_path_id'] = $data['category_id'];
        $result = explode(',', $data['category_path_id']);
        $data['category_id'] = end($result);

        $res = (new GoodsBis())->insertData($data);
        if (!$res) {
            return Show::error('商品新增失败');
        }
        return Show::success([], '商品新增成功');
    }
}
