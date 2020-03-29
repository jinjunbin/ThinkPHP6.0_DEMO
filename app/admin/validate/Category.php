<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/2/23
 * Time: 21:53
 */
namespace app\admin\validate;

use think\Validate;

class Category extends Validate
{
    protected $rule = [
        'pid' => 'require',
        'name' => 'require',
        'id' => 'require',
        'listorder' => 'require|number|between:0,99',
        'status' => ['require', 'number'],
    ];

    protected $message = [
        'pid' => '父类ID必须',
        'name' => '分类名称必须',
        'id' => '分类ID必须',
        'listorder.require' => '分类排序值必须',
        'listorder.number' => '分类排序值必须为数字',
        'listorder.between' => '分类排序值0~99',
        'status.require' => '分类状态值必须',
        'status.number' => '分类状态值必须为数字',
    ];

    protected $scene = [
        'save' => ['pid','name'],
        'listorder' => ['id','listorder'],
        'status' => ['id','status'],
    ];
}
