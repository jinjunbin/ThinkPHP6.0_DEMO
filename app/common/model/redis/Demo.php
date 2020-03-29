<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/1/14
 * Time: 14:56
 */
namespace app\common\model\redis;

use think\Model;

class Demo extends Model
{
    public function getDemoDataByDid($id)
    {
        $results = $this->where('did', $id)
            ->select()
            ->toArray();

         return $results;
    }
}
