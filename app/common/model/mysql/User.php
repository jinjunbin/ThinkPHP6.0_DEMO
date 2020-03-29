<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/1/15
 * Time: 16:39
 */
namespace app\common\model\mysql;

use think\Model;

class User extends Model
{
    /**
     * 自动生成写入时间
     * @var bool
     */
    protected $autoWriteTimestamp = true;
    public function getUserByPhoneNumber($phoneNumber)
    {
        if (empty($phoneNumber)) {
            return false;
        }

        $where = [
            'phone_number' => trim($phoneNumber),
        ];

        $result = $this->where($where)->find();

        return $result;
    }

    public function getUserByUsername($username)
    {
        if (empty($username)) {
            return false;
        }

        $where = [
            'username' => $username,
        ];

        $result = $this->where($where)->find();

        return $result;
    }

    /**
     * 通过id获取用户数据
     * @param $id
     * @return array|bool|Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getUserById($id)
    {
        $id = intval($id);
        if (!$id) {
            return false;
        }
        return $this->find($id);
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
