<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/1/20
 * Time: 15:17
 */
namespace app\api\controller;

use app\common\business\User as UserBis;
use app\common\lib\Show;

class User extends AuthBase
{
    public function index()
    {
        $user = (new UserBis())->getNormalUserById($this->userId);

        $resultUser = [
            'id' => $user['id'],
            'username' => $user['username'],
            'update_time' => $user['update_time'],
        ];
        return Show::success($resultUser);
    }

    /**
     * PUT
     * @return \think\response\Json
     */
    public function update()
    {
        $username = input('param.username', '', 'trim');
        $sex = input('param.sex', 0, 'intval');
        //
        $data = [
            'username' => $username,
            'sex' => $sex,
            'update_time' => time(),
        ];
        $validate = (new \app\api\validate\User())->scene('update_user');
        if (!$validate->check($data)) {
            return Show::error($validate->getError());
        }
        $userBisObj = new UserBis();
        $user = $userBisObj->update($this->userId, $data);
        if (!$user) {
            return Show::error('更新失败');
        }

        //如果用户名被修改, redis 里面也要同步一下
        $redisData = [
            'id' => $this->userId,
            'username' => $username,
        ];
        cache(config('redis.token_pre').$this->accessToken, $redisData);
        return Show::success();
    }
}
