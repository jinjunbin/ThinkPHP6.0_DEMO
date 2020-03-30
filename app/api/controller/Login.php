<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/1/17
 * Time: 14:42
 */
declare(strict_types=1);
namespace app\api\controller;

use app\BaseController;
use app\common\business\User as UserBis;
use app\common\lib\Show;

class Login extends BaseController
{
    public function index()// :obiect
    {
        if (!$this->request->isPost()) {
            return Show::error('非法请求');
        }
        $phoneNumber = $this->request->param('phone_number', '', 'trim');
        $code = $this->request->param('code', 0, 'intval');
        $type = $this->request->param('type', 0, 'intval');
        // 参数校验
        $data = [
            'phone_number' => $phoneNumber,
            'code' => $code,
            'type' => $type,
        ];
        $validate = new \app\api\validate\User();
        if (!$validate->scene('login')->check($data)) {
            return Show::error($validate->getError());
        }

        try {
            $result = (new UserBis())->login($data);
        } catch (\Exception $e) {
            return Show::error($e->getMessage(), $e->getCode());
        }

        if ($result) {
            return Show::success($result, '登录成功');
        }
        return Show::error('登录失败');
    }
}
