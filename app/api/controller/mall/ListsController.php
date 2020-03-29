<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/2/27
 * Time: 17:33
 */
namespace app\api\controller\mall;

use app\api\controller\ApiBaseController;
use app\common\lib\Show;
use app\common\business\Goods as GoodsBis;

class ListsController extends ApiBaseController
{
    public function index()
    {
        $pageSize = input('param.page_size', 10, 'intval');
        $categoryId = input('param.category_id', 0, 'intval');
        if (!$categoryId) {
            return Show::success();
        }
        $data = [
            'category_path_id' => $categoryId,
        ];
        $field = input('param.field', 'listorder', 'trim');
        $order = input('param.order', 2, 'intval');
        $order = $order == 2 ? 'desc' : 'asc';//2倒序
        $order = [$field => $order];

        $goods = (new GoodsBis())->getNormalLists($data, $order, $pageSize);
        return Show::success($goods);
    }
}
