<?php
declare (strict_types = 1);

namespace app\data\model;

use think\Model;
use think\Facade\Db;

/**
 * @mixin think\Model
 */
class AdminOrder extends Model
{
    //
    protected $pk = 'iAutoID';  //定义主键

    /**
     * 获取楼盘列表
     *
     * @return array
     */
    public function getLoupanList()
    {
        $list = Db::table('t_admin_order')
            ->field('iAutoID,sName,sLoupanName,sCityName,sRegion,sBlock,iType,iRegionType')
            ->order('sLoupanName,sCityName')
            ->where('iType',1)
            ->select();
        return $list;
    }

    /**
     * 获取城市列表
     *
     * @return array
     */
    public function getCityList()
    {
        $list = Db::table('t_admin_order')
            ->field('iAutoID,sName,sLoupanName,sCityName,sRegion,sBlock,iType,iRegionType')
            ->order('sCityName')
            ->where('iType',3)
            ->where('iRegionType',1)
            ->select();
        return $list;
    }

    /**
     * 获取地区列表
     *
     * @return array
     */
    public function getRegionList()
    {
        $list = Db::table('t_admin_order')
            ->field('iAutoID,sName,sLoupanName,sCityName,sRegion,sBlock,iType,iRegionType')
            ->order('sCityName,sRegion')
            ->where('iType',3)
            ->where('iRegionType',2)
            ->select();
        return $list;
    }

    /**
     * 获取板块列表
     *
     * @return array
     */
    public function getBlockList()
    {
        $list = Db::table('t_admin_order')
            ->field('iAutoID,sName,sLoupanName,sCityName,sRegion,sBlock,iType,iRegionType')
            ->order('sCityName,sBlock')
            ->where('iType',3)
            ->where('iRegionType',3)
            ->select();
        return $list;
    }

}
