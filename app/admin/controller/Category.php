<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/2/22
 * Time: 22:47
 */
declare (strict_types = 1);

namespace app\admin\controller;

use app\common\lib\Show;
use think\facade\View;
use app\common\business\Category as CategoryBis;
use app\common\lib\Status as StatusLib;

class Category extends AdminBase
{
    public function index()
    {
        $pid = input('param.pid', 0, 'intval');
        $data = [
            'pid' => $pid,
        ];

        try {
            $categorys = (new CategoryBis())->getLists($data, 5);
        } catch (\Exception $e) {
            $categorys = \app\common\lib\Arr::getPaginateDefaultData(5);
        }

        return View::fetch('', [
            'categorys' => $categorys,
            'pid' => $pid,
        ]);
    }

    public function add()
    {
        try {
            $categorys = (new CategoryBis())->getNormalCategorys();
        } catch (\Exception $e) {
            $categorys = [];
        }

        return View::fetch('', [
            'categorys' => json_encode($categorys),
        ]);
    }

    /**
     * 新增逻辑
     */
    public function save()
    {
        $pid = input('param.pid', 0, 'intval');
        $name = input('param.name', '', 'trim');

        //参数校验
        $data = [
            'pid' => $pid,
            'name' => $name,
        ];
        $validate = new \app\admin\validate\Category();
        if (!$validate->scene('save')->check($data)) {
            return Show::error($validate->getError());
        }

        try {
            $result = (new CategoryBis())->add($data);
        } catch (\Exception $e) {
            // 记录日志
            return Show::error($e->getMessage(), $e->getCode());
        }
        if ($result) {
            return Show::success();
        }
        return Show::error('新增分类失败');
    }

    /**
     * 排序
     * @return \think\response\Json
     */
    public function listorder()
    {
        $id = input('param.id', 0, 'intval');
        $listorder = input('param.listorder', 0, 'intval');

        //参数校验
        $data = ['listorder' => $listorder, 'id' => $id,];
        $validate = new \app\admin\validate\Category();
        if (!$validate->scene('listorder')->check($data)) {
            return Show::error($validate->getError());
        }

        try {
            $res = (new CategoryBis())->listorder($id, $listorder);
        } catch (\Exception $e) {
            // 记录日志
            return Show::error($e->getMessage(), $e->getCode());
        }

        if ($res) {
            return Show::success([], '排序成功');
        } else {
            return Show::error('排序失败');
        }
    }

    /**
     * 更新状态
     * @return \think\response\Json
     */
    public function status()
    {
        $id = input('param.id', 0, 'intval');
        $status = input('param.status', 0, 'intval');

        //参数校验
        $data = [
            'id' => $id,
            'status' => $status,
        ];
        $validate = new \app\admin\validate\Category();
        if (!$validate->scene('status')->check($data)) {
            return Show::error($validate->getError());
        }
        if (!$id || !in_array($status, StatusLib::getTableStatus())) {
            return Show::error('参数错误');
        }

        try {
            $res = (new CategoryBis())->status($id, $status);
        } catch (\Exception $e) {
            // 记录日志
            return Show::error($e->getMessage(), $e->getCode());
        }

        if ($res) {
            return Show::success([], '状态更新成功');
        } else {
            return Show::error('状态更新失败');
        }
    }

    //分类编辑

    //分类页面添加路径

    /**
     * 调模板引擎
     * @return \think\response\View
     */
    public function dialog()
    {
        // 获取正常的一级分类数据
        $categorys = (new CategoryBis())->getNormalByPid();
        return View('', [
            'categorys' => json_encode($categorys),
        ]);
    }

    public function getByPid()
    {
        $pid = input('param.pid', 0, 'intval');
        $categorys = (new CategoryBis())->getNormalByPid($pid);
        return Show::success($categorys);
    }
}
