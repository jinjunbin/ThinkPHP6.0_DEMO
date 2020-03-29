<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/1/14
 * Time: 16:12
 */
namespace app\common\business;

use app\common\model\mysql\Demo as DemoModel;

class Demo
{
    /**
     * business 层通过getDemoDataByCategoryId来获取数据
     * @param $categoryId
     * @param int $limit
     * @return array
     */
    public function getDemoDataByCategoryId($categoryId, $limit = 10) {
        $model = new DemoModel();
        $results = $model->getDemoDataByCategoryId($categoryId, $limit);
        if(empty($results)) {
            return [];
        }
        $cagegorys = config("category");
        foreach($results as $key => $result) {
            $results[$key]['categoryName'] = $cagegorys[$result["category_id"]] ?? "其他";
            // isset($cagegorys[$result["category_id"]]) ? $cagegorys[$result["category_id"]] : "其他";
        }

        return $results;
    }
    
    /**
     * business 层通过调用 model 来获得数据
     * @param $Did
     * @return array
     */
    public function getDemoDataById($Did)
    {
        $model = new DemoModel();
        $results = $model->getDemoDataByDid($Did);
        if (empty($results)) {
            return [];
        }

        //调用第三方数据, 调用 lib

        //对数据进行组装

        return $results;
    }
}
