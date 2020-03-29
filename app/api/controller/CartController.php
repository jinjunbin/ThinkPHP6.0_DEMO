<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/2/28
 * Time: 15:15
 */
namespace app\api\controller;

use app\common\lib\Show;
use app\common\business\Cart as CartBis;

class CartController extends AuthBaseController
{
    public function add()
    {
        if (!$this->request->isPost()) {
            return Show::error();
        }
        $id = input('param.id', 0, 'intval');
        $num = input('param.num', 0, 'intval');
        // 参数校验
        $data = [
            'id' => $id,
            'num' => $num,
        ];
        $validate = new \app\api\validate\Cart();
        if (!$validate->scene('add')->check($data)) {
            return Show::error($validate->getError());
        }

        $res = (new CartBis())->insertRedis($this->userId, $id, $num);
        if ($res === false) {
            return Show::error();
        }
        return Show::success();
    }

    public function lists()
    {
        $ids = input('param.id', '', 'trim');
        $res = (new CartBis())->lists($this->userId, $ids);
        if ($res === false) {
            return Show::error();
        }
        return Show::success($res);
    }

    public function delete()
    {
        if (!$this->request->isPost()) {
            return Show::error();
        }
        $id = input('param.id', 0, 'intval');
        // 参数校验
        $data = [
            'id' => $id,
        ];
        $validate = new \app\api\validate\Cart();
        if (!$validate->scene('delete')->check($data)) {
            return Show::error($validate->getError());
        }

        $res = (new CartBis())->deleteRedis($this->userId, $id);
        if ($res === false) {
            return Show::error();
        }
        return Show::success($res);
    }

    public function update()
    {
        if (!$this->request->isPost()) {
            return Show::error();
        }
        $id = input('param.id', 0, 'intval');
        $num = input('param.num', 0, 'intval');
        // 参数校验
        $data = [
            'id' => $id,
            'num' => $num,
        ];
        $validate = new \app\api\validate\Cart();
        if (!$validate->scene('delete')->check($data)) {
            return Show::error($validate->getError());
        }

        try {
            $res = (new CartBis())->updateRedis($this->userId, $id, $num);
        } catch (\Exception $e) {
            return Show::error($e->getMessage(), $e->getCode());
        }

        if ($res === false) {
            return Show::error();
        }
        return Show::success($res);
    }
}
