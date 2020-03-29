<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/2/23
 * Time: 23:23
 */
namespace app\common\business;

use app\common\model\mysql\Category as CategoryModel;

class Category
{
    public $model = null;

    public function __construct()
    {
        $this->model = new CategoryModel();
    }

    public function add($data)
    {
        $data['status'] = config('status.mysql.table_normal');
        //根据$name 去数据库查询是否存在这条纪录
        $res = $this->model->getIdByName($data['name']);
        if ($res) {
            throw new \think\Exception('已存在相同名称, 请重新输入');
        }

        try {
            $this->model->save($data);
        } catch (\Exception $e) {
            throw new \think\Exception('服务内部异常');
        }
        return $this->model->id;
    }

    public function getNormalCategorys($where = [], $field = 'id, name, pid')
    {
        $categorys = $this->model->getNormalCategorys($where, $field);
        if (!$categorys) {
            return [];
        }
        $categorys = $categorys->toArray();
        return $categorys;
    }

    public function getLists($data, $num)
    {
        $list = $this->model->getLists($data, $num);
        if (!$list) {
            return \app\common\lib\Arr::getPaginateDefaultData(5);
        }
        $result = $list->toArray();
        $result['render'] = $list->render();

        // 思路: 第一步拿到列表中id, 第二步 in mysql 求count, 第三步把count填充到列表页中
        $pids = array_column($result['data'], 'id');
        $idCounts = [];
        if ($pids) {
            $idCountResult = $this->model->getChildCountInPids(['pid'=>$pids]);
            $idCountResult = $idCountResult->toArray();// 如果没有的话会返回空数组

            //第一种方式
            foreach ($idCountResult as $countResult) {
                $idCounts[$countResult['pid']] = $countResult['count'];
            }
        }
        if ($result['data']) {
            foreach ($result['data'] as $k => $value) {
                // $a ?? 0 等同于 isset($a) ? $a : 0
                $result['data'][$k]['childCount'] = $idCounts[$value['id']] ?? 0;
            }
        }
        return $result;
    }

    /**
     * 根据id获取某一条记录
     * @param $id
     * @return array|\think\Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getById($id)
    {
        $result = $this->model->find($id);
        if (empty($result)) {
            return [];
        }
        $result = $result->toArray();
        return $result;
    }

    /**
     * 排序bis
     * @param $id
     * @param $listorder
     * @return bool
     * @throws \think\Exception
     */
    public function listorder($id, $listorder)
    {
        //查询 id 这条数据是否存在
        $res = $this->getById($id);
        if (!$res) {
            throw new \think\Exception('不存在该条记录');
        }
        $data = [
            'listorder' => $listorder,
        ];

        try {
            $res = $this->model->updateById($id, $data);
        } catch (\Exception $e) {
            // 记录日志
            return false;
        }
        return $res;
    }

    /**
     * 修改状态s
     * @param $id
     * @param $status
     * @return bool
     * @throws \think\Exception
     */
    public function status($id, $status)
    {
        //查询 id 这条数据是否存在
        $res = $this->getById($id);
        if (!$res) {
            throw new \think\Exception('不存在该条记录');
        }
        if ($res['status'] == $status) {
            throw new \think\Exception('状态修改前和修改后一样没有意义');
        }
        $data = [
            'status' => intval($status),
        ];

        try {
            $res = $this->model->updateById($id, $data);
        } catch (\Exception $e) {
            // 记录日志
            return false;
        }
        return $res;
    }

    /**
     * 获取一级分类的内容
     * @param int $pid
     * @param string $field
     * @return array
     */
    public function getNormalByPid($pid = 0, $field = 'id, name, pid')
    {
        //$field = 'id, name, pid';
        try {
            $res = $this->model->getNormalByPid($pid, $field);
        } catch (\Exception $e) {
            // 记录日志
            return [];
        }
        $result = $res->toArray();

        return $result;
    }
}
