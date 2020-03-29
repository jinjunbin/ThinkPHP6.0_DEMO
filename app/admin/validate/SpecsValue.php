<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/2/23
 * Time: 21:53
 */
namespace app\admin\validate;

use think\Validate;

class SpecsValue extends Validate
{
    protected $rule = [
        'specs_id' => 'require',
        'name' => 'require',
    ];

    protected $message = [
        'specs_id' => 'specs_id必须',
        'name' => '分类名称必须',
    ];

    protected $scene = [
        'SpecsValue' => ['specs_id','name'],
    ];
}
