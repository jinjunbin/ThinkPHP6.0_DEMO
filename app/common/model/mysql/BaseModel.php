<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/2/26
 * Time: 19:34
 */
namespace app\common\model\mysql;

use think\Model;

class BaseModel extends Model
{
    /**
     * 自动生成写入时间
     * @var bool
     */
    protected $autoWriteTimestamp = true;

    /**
     * 根据id 更新库里的数据
     * @param $id
     * @param $data
     * @return bool
     */
    public function updateById($id, $data)
    {
        $data['update_time'] = time();
        return $this->where(['id'=>$id])->save($data);
    }

    public function getNormalInIds($ids)
    {
        return $this->whereIn('id', $ids)
            ->where('status', '=', config('status.mysql.table_normal'))
            ->select();
    }

    /**
     * 根据条件查询
     * @param array $condition
     * @param array $order
     * @return bool|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getByCondition($condition = [], $order = ["id" => "desc"])
    {
        if (!$condition || !is_array($condition)) {
            return false;
        }
        $result = $this->where($condition)
            ->order($order)
            ->select();

        ///echo $this->getLastSql();exit;
        return $result;
    }
}
