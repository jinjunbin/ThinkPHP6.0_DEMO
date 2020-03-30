<?php
/**
 * Created by PhpStorm
 * User: singwa
 * motto: 现在的努力是为了小时候吹过的牛逼！
 * Time: 09:12
 */
namespace app\demo\controller;

use app\BaseController;
use app\common\business\Demo as DemoBis;
use app\common\lib\Show;

class MController extends BaseController {

    public function index() {
        $categoryId = $this->request->param("category_id", 0, "intval");
        if(empty($categoryId)) {
            return Show::error("参数错误");
        }

        $demo = new DemoBis();
        $results = $demo->getDemoDataByCategoryId($categoryId);
        //

        return Show::success($results);

    }


}