<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/2/27
 * Time: 17:33
 */
namespace app\api\controller\mall;

use app\api\controller\ApiBase;
use app\common\lib\Show;
use app\common\business\Goods as GoodsBis;

class Detail extends ApiBase
{
    public function index()
    {
        $id = input('param.id', 0, 'intval');
        if (!$id) {
            return Show::error();
        }
        $result = (new GoodsBis())->getGoodsDetailBySkuId($id);
        if (!$result) {
            return Show::error();
        }
        return Show::success($result);
    }
}
