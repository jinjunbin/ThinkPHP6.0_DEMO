<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/1/15
 * Time: 16:39
 */
namespace app\common\model\mysql;

use think\Model;

class AdminUser extends Model
{
    /**
     * 根据用户名获取后端表的数据
     * @param $username
     * @return array|bool|Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getAdminUserByUserName($username)
    {
        if (empty($username)) {
            return false;
        }

        $where = [
            'username' => trim($username),
        ];

        $result = $this->where($where)->find();

        return $result;
    }

    /**
     * 根据主键id更新数据
     * @param $id
     * @param $data
     * @return bool
     */
    public function updateById($id, $data)
    {
        $id = intval($id);
        if (empty($id) || empty($data) || !is_array($data)) {
            return false;
        }

        $where = [
            'id' => $id,
        ];

        $result = $this->where($where)->save($data);
        return $result;
    }
}
