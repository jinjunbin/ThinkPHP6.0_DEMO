<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/2/25
 * Time: 23:23
 */
namespace app\common\business;

class BusBase
{
    public function add($data)
    {
        $data['status'] = config('status.mysql.table_normal');
        //根据$name 去数据库查询是否存在这条纪录
        $res = $this->model->getIdByName($data);
        if ($res) {
            throw new \think\Exception('已存在相同名称, 请重新输入');
        }

        try {
            $this->model->save($data);
        } catch (\Exception $e) {
            // 记录日志
            //throw new \think\Exception('服务内部异常');
            throw new \think\Exception($e->getMessage());
            return 0;
        }
        return $this->model->id;
    }
}
