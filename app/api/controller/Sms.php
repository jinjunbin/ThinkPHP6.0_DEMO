<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/1/16
 * Time: 16:55
 */
declare(strict_types=1);
namespace app\api\controller;

use app\BaseController;
use app\common\business\Sms as SmsBis;
use app\common\lib\Show;
use think\facade\Log;

class Sms extends BaseController
{
    public function code() //:object
    {
        return Show::success([], '发送验证码成功');
        // 1.controller 控制器层做数据判断: 手机号是否为空
        $phoneNumber = input('param.phone_number', '', 'trim');
        $data = [
            'phone_number' => $phoneNumber,
        ];
        try {
            validate(\app\api\validate\User::class)->scene('send_code')->check($data);
        } catch (\think\exception\ValidateException $e) {
            return Show::error($e->getMessage());
        }

        // (做下控制 20%流量=>阿里云短信 80%流量=>百度云)
        // 2.business 业务逻辑层: 如何生成验证码
        if (SmsBis::sendCode($phoneNumber, 4, 'jd')) {
            Log::info("SmsBis-sendCode-result-{$phoneNumber}".$e->getMessage());
            return Show::success([], '发送验证码成功');
        }

        // 3.调用 lib 层: 发送短信

        // 4.回到 business 记录 redis 并设置过期时间, 登录时作对比

        Log::info("SmsBis-sendCode-result-{$phoneNumber}".$e->getMessage());
        return Show::error('发送验证失败');
    }
}
