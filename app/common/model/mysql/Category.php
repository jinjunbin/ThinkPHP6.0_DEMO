<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/2/23
 * Time: 23:26
 */
namespace app\common\model\mysql;

class Category extends BaseModel
{
    public function getIdByName($name)
    {
        if (empty($name)) {
            return false;
        }

        $where = [
            'name' => trim($name),
        ];

        $result = $this->where($where)->find();

        return $result;
    }

    /**
     * 查询所有正常的分类数据
     * @param string $field
     * @return \think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getNormalCategorys($where = [], $field = '*')
    {
        $order = ['listorder' => 'desc', 'id' => 'desc'];
        $result = $this->where('status', '=', config('status.mysql.table_normal'))
            ->where($where)
            ->field($field)
            ->order($order)
            ->select();
        return $result;
    }

    public function getLists($where, $num = 10, $field = '*')
    {
        $order = ['listorder' => 'desc', 'id' => 'desc'];
        $result = $this->where('status', '<>', config('status.mysql.table_delete'))
            ->where($where)
            ->field($field)
            ->order($order)
            ->paginate($num);
        //echo $this->getLastSql();
        return $result;
    }

    /**
     * 获取各个 pids 的数量
     * @param $condition
     * @return mixed
     */
    public function getChildCountInPids($condition)
    {
        $where[] = ['pid', 'in', $condition['pid']];
        $where[] = ['status', '<>', config('status.mysql.table_delete')];
        $res = $this->where($where)
            ->field(['pid', 'count(*) as count'])
            ->group('pid')
            ->select();
        //echo $this->>getLastSql();exit;
        return $res;
    }

    /**
     * 根据pid获取正常的分类数据
     * @param int $pid
     * @param $field
     * @return \think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getNormalByPid($pid = 0, $field = 'id, name, pid')
    {
        $where = [
            'pid' => $pid,
            'status' => config('status.mysql.table_normal'),
        ];
        $order = ['listorder' => 'desc', 'id' => 'desc'];

        $res = $this->where($where)
            ->field($field)
            ->order($order)
            ->select();
        return $res;
    }

    public function getNormalInCategoryPids($categoryPids, $field = true)
    {
        $order = ['listorder' => 'desc', 'id' => 'desc'];

        $result = $this->whereIn('pid', $categoryPids)
            ->where('status', '=', config('status.mysql.table_normal'))
            ->order($order)
            ->field($field)
            ->field($field)
            ->select()->toArray();
        //echo $this->getLastSql();
        return $result;
    }
}
