<?php
declare (strict_types = 1);

namespace app\data\model;

use think\Model;

/**
 * @mixin think\Model
 */
class DataOrder extends Model
{
    //
    protected $pk = 'iOrderID';  //定义主键

    /**
     * 获取统计结果数据
     *
     * @return array
     */
    public function getList()
    {
        $list = $this->alias('a')
            ->join('t_admin_order b','a.iOrderID = b.iAutoID')
            ->field('a.*,b.sLoupanName,b.sCityName,b.sRegion,b.sBlock,b.iRegionType')->select();
        return $list;
    }
}
