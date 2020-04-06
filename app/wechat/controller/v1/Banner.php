<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/3/31
 * Time: 上午 01:48
 */

namespace app\wechat\controller\v1;

use app\common\lib\Show;
use app\wechat\controller\Base;
use app\wechat\Exception\BannerMissException;
use app\wechat\model\Banner as BannerModel;
use app\wechat\validate\IDMustBePositiveInt;
use app\common\lib\exception\MissException;

/**
 * Banner资源
 */
class Banner extends Base
{
//    protected $beforeActionList = [
//        'checkPrimaryScope' => ['only' => 'getBanner']
//    ];

    /**
     * 获取Banner信息
     * @url     /banner/:id
     * @http    get
     * @param int $id banner id
     * @return  array of banner item , code 200
     * @throws  MissException
     */
    public function getBanner($id)
    {
        // AOP 面向切面编程
        (new IDMustBePositiveInt())->goCheck();

        $banner = BannerModel::getBannerById($id);
        if (!$banner) {
            throw new BannerMissException();
        }
        return Show::success($banner->toArray());


        die;
        $t1 = microtime(true);
        $t2 = microtime(true);
        echo '耗时' . round($t2 - $t1, 3) . '秒';

        try {
        } catch (\Exception $ex) {
            $err = [
                'error_code' => 10001,
                'msg' => $ex->getMessage(),
            ];
            return json($err);
        }

        if (!$banner) {
            throw new MissException([
                'msg' => '请求banner不存在',
                'errorCode' => 40000
            ]);
        }
    }
}
