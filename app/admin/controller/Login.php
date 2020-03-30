<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/1/14
 * Time: 23:21
 */
namespace app\admin\controller;

use app\admin\validate\AdminUser as AdminUserVal;
use app\admin\business\AdminUser;
use app\common\lib\Show;
use think\facade\View;
use think\captcha\facade\Captcha;

class Login extends AdminBase
{
    public function initialize()
    {
        if ($this->isLogin()) {
            return $this->redirect(url('index/index'));
        }
    }

    /**
     * 后台登录页
     * @return string
     * @throws \Exception
     */
    public function index()
    {
        return View::fetch();
    }

    /**
     * 自定义的验证码
     * @return \think\Response
     */
    public function recaptcha()
    {
        return Captcha::create('verify');
    }

    /**
     * 点击登陆
     * @return \think\response\Json
     */
    public function check()
    {
        if (!$this->request->isPost()) {
            return Show::error('请求方式出错');
        }

        // 参数检验 1.原生方式 2.TP6 验证机制
        $username = $this->request->param('username', '', 'trim');
        $password = $this->request->param('password', '', 'trim');
        $captcha = $this->request->param('captcha', '', 'trim');
        $validate = new AdminUserVal();
        $data = [
            'username' => $username,
            'password' => $password,
            'captcha' => $captcha,
        ];
        if (!$validate->check($data)) {
            return Show::error($validate->getError());
        }

        try {
            $result = (new AdminUser())->login($data);
        } catch (\Exception $e) {
            return Show::error($e->getMessage(), $e->getCode());
        }
        if ($result) {
            return Show::success([], '登录成功');
        } else {
            return Show::error('登录失败');
        }
    }
}
