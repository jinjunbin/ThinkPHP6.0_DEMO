<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/1/16
 * Time: 14:43
 */
namespace app\admin\validate;

use think\Validate;

class AdminUser extends Validate
{
    protected $rule = [
        'username' => 'require',
        'password' => 'require',
        'captcha' => 'require|checkCaptcha:abcd',
    ];

    protected $message = [
        'username' => '用户名必须,请重新输入',
        'password' => '密码必须',
        'captcha' => '验证码必须',
    ];

    protected function checkCaptcha($value, $rule, $data = [])
    {
        // 需要校验验证码
        if (!captcha_check($value)) {
            return '验证码不正确'.$value;
        }

        return true;
    }
}
