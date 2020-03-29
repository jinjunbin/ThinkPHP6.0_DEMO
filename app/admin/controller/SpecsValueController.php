<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/2/25
 * Time: 22:01
 */
namespace app\admin\controller;

use app\common\business\SpecsValue as SpecsValueBis;
use app\common\lib\Show;

class SpecsValueController extends AdminBaseController
{
    public function save()
    {
        $specsId = input('param.specs_id', 0, 'intval');
        $name = input('param.name', '', 'trim');

        //参数校验
        $data = [
            'specs_id' => $specsId,
            'name' => $name,
        ];
        $validate = new \app\admin\validate\SpecsValue();
        if (!$validate->scene('SpecsValue')->check($data)) {
            return Show::error($validate->getError());
        }

        $id = (new SpecsValueBis())->add($data);
        if (!$id) {
            return Show::error('新增失败');
        }

        return Show::success(['id'=>$id]);
    }

    public function getBySpecsId()
    {
        $specsId = input('param.specs_id', 0, 'intval');
        if (!$specsId) {
            return Show::success([], '没有数据');
        }
        $result = (new SpecsValueBis())->getBySpecsId($specsId);
        return Show::success($result);
    }
}
