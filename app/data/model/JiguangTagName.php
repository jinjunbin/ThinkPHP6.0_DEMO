<?php
declare (strict_types = 1);

namespace app\data\model;

use think\Model;

/**
 * @mixin think\Model
 */
class JiguangTagName extends Model
{
    //
    protected $pk = 'tagid';  //定义主键

    /**
     * 获取tagid列表
     *
     * @return array
     */
    public function getTagidList()
    {
        $list = $this->column('tagid');
        return $list;
    }
}
