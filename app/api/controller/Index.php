<?php

namespace app\api\controller;

use think\App;
use think\facade\Db;
use app\CkEx;
use app\common\business\Goods as GoodsBis;
use app\common\lib\Show;

class Index extends ApiBase
{
    /**
     * 获取轮播图
     * @return \think\response\Json
     */
    public function getRotationChart()
    {
        $result = (new GoodsBis())->getRotationChart();
        return Show::success($result);
    }

    /**
     * 获取首页栏目推荐的商品
     * @return \think\response\Json
     */
    public function cagegoryGoodsRecommend()
    {
        $categoryIds = [
            2,10,12,
        ];
        $result = (new GoodsBis())->cagegoryGoodsRecommend($categoryIds);
        return Show::success($result);
    }

    public function demo()
    {
        return '<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:) </h1><p> ThinkPHP V6<br/><span style="font-size:30px">13载初心不改 - 你值得信赖的PHP框架</span></p></div><script type="text/javascript" src="https://tajs.qq.com/stats?sId=64890268" charset="UTF-8"></script><script type="text/javascript" src="https://e.topthink.com/Public/static/client.js"></script><think id="eab4b9f840753f8e7"></think>';
    }

    public function hello($name = 'ThinkPHP6')
    {
        $list = Db::name('t_address')
            ->select();
        foreach ($list as $user) {
            echo $user['iAutoID'] . ':' . $user['sRecipient'] . '<br>';
        }

        var_dump($list);
        die;

        return 'hello,' . $name;
    }
    public function hello2()
    {
        return '111';
    }

    public function ck()
    {
        /*CREATE TABLE t_jiguang_monomers_bak
        ENGINE = MergeTree
        ORDER BY iAutoID AS
        SELECT *
        FROM mysql('127.0.0.1', 'goingdata', 't_jiguang_monomers_bak', 'mysql', 'qwert12345')*/


        /*$config = [
            'host' => env('clickhouse.host', '127.0.0.1'),
            'port' => env('clickhouse.hostname', 'default'),
            'username' => env('clickhouse.username', 'ck'),
            'password' => env('clickhouse.password', '123456'),
        ];*/
        $db = CkEx::getInstance();

        $statement = $db->select('SELECT * FROM t_jiguang_monomers_bak LIMIT 5')->rows();
        dump($statement);
        //echo json_encode($statement);
        die;

        // Count select rows

        // Count all rows
        $statement->countAll();

        // fetch one row
        $statement->fetchOne();

        // get extremes min
        var_dump($statement->extremesMin());

        // totals row
        var_dump($statement->totals());

        // result all
        var_dump($statement->rows());

        // totalTimeRequest
        var_dump($statement->totalTimeRequest());

        // raw answer JsonDecode array, for economy memory
        var_dump($statement->rawData());

        // raw curl_info answer
        var_dump($statement->responseInfo());

        // human size info
        var_dump($statement->info());

        // if clickhouse-server version >= 54011
        $db->settings()->set('output_format_write_statistics', true);
        var_dump($statement->statistics());

        die;
        $list = Db::name('t_address')
            ->select();
        foreach ($list as $user) {
            echo $user['iAutoID'] . ':' . $user['sRecipient'] . '<br>';
        }
        var_dump($list);
        die;

        $list = Address::getAddressList;
        var_dump($list);
        die;
        $count = count($list);
        foreach ($list as $user) {
            echo $user['id'] . ':' . $user['name'];
        }
    }
}
