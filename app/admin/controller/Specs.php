<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/2/25
 * Time: 22:01
 */
namespace app\admin\controller;

use think\View;

class Specs extends AdminBase
{
    public function dialog()
    {
        return View('', [
            'specs' => json_encode(config('specs'))
        ]);
    }
}
