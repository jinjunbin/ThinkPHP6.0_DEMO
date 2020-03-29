<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/2/25
 * Time: 23:26
 */
namespace app\common\model\mysql;

class SpecsValue extends BaseModel
{
    public function getIdByName($data)
    {
        if (empty($data['name']) || empty($data['specs_id'])) {
            return false;
        }

        $where = [
            'name' => trim($data['name']),
            'specs_id' => trim($data['specs_id']),
        ];

        $result = $this->where($where)->find();

        return $result;
    }

    public function getNormalBySpecsId($specsId, $field = '*')
    {
        $where = [
            'specs_id' => $specsId,
            'status' => config('status.mysql.table_normal'),
        ];

        $res = $this->where($where)
            ->field($field)
            ->select();
        return $res;
    }
}
