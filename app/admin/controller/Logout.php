<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/1/15
 * Time: 17:46
 */
namespace app\admin\controller;

class Logout extends AdminBase
{
    public function index()
    {
        // 清除session
        session(config('admin.session_admin'), null);
        // 执行跳转
        return redirect(url('login/index'));
    }
}
