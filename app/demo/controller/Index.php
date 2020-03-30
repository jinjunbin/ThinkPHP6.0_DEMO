<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/1/14
 * Time: 13:41
 */
namespace app\demo\controller;

use app\BaseController;
use app\common\business\Demo as DemoBis;
use app\common\lib\Show;
use app\common\lib\Snowflake;

class Index extends BaseController
{
    public function index()
    {
        return '<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:) </h1><p> ThinkPHP V6<br/><span style="font-size:30px">13载初心不改 - 你值得信赖的PHP框架</span></p></div><script type="text/javascript" src="https://tajs.qq.com/stats?sId=64890268" charset="UTF-8"></script><script type="text/javascript" src="https://e.topthink.com/Public/static/client.js"></script><think id="eab4b9f840753f8e7"></think>';
    }

    public function hello($name = 'ThinkPHP6')
    {
        return 'hello,' . $name;
    }

    public function abc() {
        return "singwa-abc";
    }

    public function hellotime()
    {
        return time();
    }

    public function mysqlDemo()
    {
        // controller 负责数据的接收,判断
        $Did = $this->request->param('id', 0, 'intval');
        if (empty($Did)) {
            return Show::error('参数错误', []);
        }

        $demo = new DemoBis();
        $results = $demo->getDemoDataById($Did);

        return Show::success($results);
    }

    public function snowflake()
    {
        $workId = rand(1, 1023);
        $orderId = Snowflake::getInstance()->setWorkId($workId)->id();
        dump($orderId);
    }
}
