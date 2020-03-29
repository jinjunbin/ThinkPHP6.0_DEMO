<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/1/21
 * Time: 14:24
 */
namespace app\api\controller;

use app\common\lib\Show;

class LogoutController extends AuthBaseController
{
    public function index()
    {
        // 删除 redis token 缓存
        $res = cache(config('redis.token_pre').$this->accessToken, null);
        if ($res) {
            return Show::success([], '退出登录成功');
        }
        return Show::error('退出登录失败');
    }
}
