<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/1/16
 * Time: 15:28
 */
namespace app\admin\business;

use app\common\model\mysql\AdminUser as AdminUserModel;
use think\Exception;

class AdminUser
{
    public $model = null;
    public function __construct()
    {
        $this->model = new AdminUserModel();
    }

    public function login($data)
    {
        // 常规的做法：
        $adminUser = $this->getAdminUserByUserName($data['username']);
        if (!$adminUser) {
            throw new Exception('不存在该用户');
        }
        // 判断密码是否正确
        if ($adminUser['password'] != md5($data['password'])) {
            throw new Exception('密码错误');
        }

        // 需要记录信息到mysql表中
        $updateData = [
            'last_login_time' => time(),
            'last_login_ip' => request()->ip(),
            'update_time' => time(),
        ];
        $res = $this->model->updateById($adminUser['id'], $updateData);
        if (empty($res)) {
            throw new Exception('登录失败');
        }

        // 记录session
        session(config('admin.session_admin'), $adminUser);
        return true;
    }

    /**
     * 通过用户名获取用户数据
     * @param $username
     * @return array|bool|\think\Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getAdminUserByUserName($username)
    {
        $adminUser = $this->model->getAdminUserByUserName($username);

        if (empty($adminUser) || $adminUser->status != config('status.mysql.table_normal')) {
            return [];
        }
        $adminUser = $adminUser->toArray();
        return $adminUser;
    }
}
