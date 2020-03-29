<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/2/25
 * Time: 17:48
 */
namespace app\api\controller;

use app\common\business\Category as CategoryBis;
use app\common\lib\Show;

class CategoryController extends ApiBaseController
{
    public function index()
    {
        try {
            // 获取所有分类的内容
            $categoryBisObj = new CategoryBis();
            $categorys = $categoryBisObj->getNormalCategorys();
        } catch (\Exception $e) {
            // 记录日志
            return Show::success([], '内部异常');
        }
        if (!$categorys) {
            // 记录日志
            return Show::success([], '数据为空');
        }

        $result = \app\common\lib\Arr::getTree($categorys);
        $result = \app\common\lib\Arr::sliceTreeArr($result);
        return Show::success($result);
    }

    /**
     * api/category/search/11
     * 商品列表页面中 按栏目检索的内容
     * @return \think\response\Json
     */
    public function search()
    {
        $result = [
            'name' => '我是一级分类',
            'focus_ids' => [ // 分类的定位焦点 ，注意这个地方 有可能是一个，有可能是两个
                1,
                11
            ],
            'list' => [
                [
                    ['id' => 1, 'name' => '二级分类1'],
                    ['id' => 2, 'name' => '二级分类2'],
                    ['id' => 3, 'name' => '二级分类3'],
                    ['id' => 4, 'name' => '二级分类4'],
                    ['id' => 5, 'name' => '二级分类5'],
                ],
                [
                    ['id' => 11, 'name' => '三级分类1'],
                    ['id' => 12, 'name' => '三级分类2'],
                    ['id' => 13, 'name' => '三级分类3'],
                    ['id' => 14, 'name' => '三级分类4'],
                    ['id' => 15, 'name' => '三级分类5'],
                ]
            ]
        ];
        return Show::success($result);
    }

    /**
     * 获取子分类    api/subcategory/2
     * @return \think\response\Json
     */
    public function sub()
    {
        // 拿 id , 查 pid = id
        $result = [
            ['id' => 21, 'name' => '点二到三分类1'],
            ['id' => 22, 'name' => '点二到三分类2'],
            ['id' => 23, 'name' => '点二到三分类3'],
            ['id' => 24, 'name' => '点二到三分类4'],
            ['id' => 25, 'name' => '点二到三分类5'],
        ];
        return Show::success($result);
    }
}
