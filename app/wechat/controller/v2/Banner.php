<?php
/**
 * Created by PhpStorm.
 * User: happy
 * Date: 2020/3/17 0017
 * Time: 下午 07:44
 */

namespace app\wechat\controller\v2;

use app\wechat\controller\Base;

/**
 * Banner资源
 */
class Banner extends Base
{
    /**
     * 获取Banner信息
     * @param $id
     * @return string
     */
    public function getBanner($id)
    {
        return 'This is V2 Version';
    }
}