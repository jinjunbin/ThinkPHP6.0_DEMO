<?php
declare (strict_types = 1);

namespace app\data\model;

use think\Model;
use think\Facade\Db;

/**
 * @mixin think\Model
 */
class DataOrderArrange extends Model
{
    //
    /**
     * 获取列表
     *
     * @return array
     */
    public function getList()
    {
        $list = Db::table('t_data_order_arrange')
            ->field('id,iOrderID')
            ->order('id')
            ->where('update_time',0)
            //->limit(15)
            ->select();
        return $list;
    }

    /**
     * 获取订单的IMEI统计数据
     *
     * @param string $orderID 订单ID字符串，多个逗号分隔
     * @return int
     */
    public function getImeiCount($orderID)
    {
        $orderList = explode(",", $orderID);//转数组

        if(count($orderList) > 1){//有两个以上订单ID
            sort($orderList);//排序由低到高
            $sql = '';
            do {
                $v = array_shift($orderList );  //删除并获取第一个元素
                $order_str = implode(",",$orderList);//剩余订单ID转字符串
                $sql .= " select COUNT(distinct `sImei`) AS b  from `t_jiguang_monomers` 
                    where `iOrderID` = '$v' and `sTagValue` <> '' AND `iStatus` = 1 ";
                if(count($orderList) > 0) {//对于不同订单号重复imei，取订单号大的
                    $sql .= "and `sImei` not in (select distinct `sImei` from `t_jiguang_monomers` where `iOrderID` in ($order_str) and `sTagValue` <> '' AND `iStatus` = 1)
                    union";
                }
            } while (count($orderList) > 0);

            $sql = "select sum(a.b) as num from ( $sql ) as a ";    //统计总数

            $list = Db::query($sql);

            //判断结果是否为0，查备份表
            if($list[0]['num'] == 0) {
                $sql = str_replace('t_jiguang_monomers', 't_jiguang_monomers_bak', $sql);
                $list = Db::query($sql);
            }
        }else{
            $list = Db::query("select COUNT(distinct `sImei`) AS num  from `t_jiguang_monomers` where `iOrderID` = :oid1 and `sTagValue` <> '' AND `iStatus` = 1",
                    ['oid1' => $orderList[0]]);
            //判断结果是否为0，查备份表
            if($list[0]['num'] == 0){
                $list = Db::query("select COUNT(distinct `sImei`) AS num  from `t_jiguang_monomers_bak` where `iOrderID` = :oid1 and `sTagValue` <> '' AND `iStatus` = 1",
                    ['oid1' => $orderList[0]]);
            }
        }

        return $list[0]['num'];
    }

    /**
     * 获取各类TAG统计数据
     *
     * @param string $orderID 订单ID字符串，多个逗号分隔
     * @return int
     */
    public function getTagList($orderID)
    {
        $orderList = explode(",", $orderID);//转数组

        if(count($orderList) > 1){//有两个以上订单ID
            sort($orderList);//排序由低到高
            $sql = '';
            do {
                $v = array_shift($orderList );  //删除并获取第一个元素
                $order_str = implode(",",$orderList);//剩余订单ID转字符串
                $sql .= " select `sTagid`,COUNT(*) AS num  from `t_jiguang_monomers` 
                    where `iOrderID` = '$v' and `sTagValue` <> '' AND `iStatus` = 1 ";
                if(count($orderList) > 0) {//对于不同订单号重复imei，取订单号大的
                    $sql .= "and `sImei` not in (select distinct `sImei` from `t_jiguang_monomers` where `iOrderID` in ($order_str) and `sTagValue` <> '' AND `iStatus` = 1)  group by `sTagid` 
                    union";
                } else {
                    $sql .= " group by `sTagid`";
                }
            } while (count($orderList) > 0);

            $list = Db::query($sql);

            //判断结果是否为空，查备份表
            if(empty($list)){
                $sql = str_replace('t_jiguang_monomers', 't_jiguang_monomers_bak', $sql);
                $list = Db::query($sql);
            }
        }else{
            $list = Db::query("select `sTagid`,COUNT(*) AS num from `t_jiguang_monomers` where `iOrderID` = :oid1 and `sTagValue` <> '' AND `iStatus` = 1  group by `sTagid`",
                ['oid1' => $orderList[0]]);
            //判断结果是否为0，查备份表
            if(empty($list)){
                $list = Db::query("select `sTagid`,COUNT(*) AS num from `t_jiguang_monomers_bak` where `iOrderID` = :oid1 and `sTagValue` <> '' AND `iStatus` = 1  group by `sTagid`",
                    ['oid1' => $orderList[0]]);
            }
        }

        return $list;
    }

    /**
     * 获取指定TAG统计数据
     *
     * @param string $tag_id TAGID
     * @param string $orderID 订单ID字符串，多个逗号分隔
     * @return int
     */
    public function getTagByID($tag_id, $orderID)
    {
        $list = Db::table('t_admin_order_jiguang_tags_tmp')
            ->field('iOrderID,sContent')
            ->where('iOrderID', 'in', $orderID)
            ->where('sTagID', $tag_id)
            ->select();
        $num = 0;
        if (!empty($list)) {
            //先将json数据整理下
            foreach ($list as $k => $v) {
                if(!empty($v['sContent'])) {
                    $citys = json_decode($v['sContent'], true);
                    foreach ($citys as $key => $val) {
                        $num += $val['iNum'];
                    }
                }
            }
        }
        return $num;
    }

    /**
     * 获取提交极光imei数量
     *
     * @param string $orderID 订单ID字符串，多个逗号分隔
     * @return int
     */
    public function getImeiNum($orderID)
    {
        $list = Db::table('t_jiguang_mission_imei')
            ->alias('a')
            ->join('t_jiguang_mission b','a.iMissionID = b.iAutoID')
            ->join('t_admin_order c','c.iAutoID = b.iOrderID')
            ->fieldRaw('count(DISTINCT a.sImei) as num')
            //->fetchSql(true)
            ->where('c.iAutoID', 'in', $orderID)
            ->find();
        //dd($list);
        /*$sql = "select count(DISTINCT `sImei`) as num from `t_jiguang_mission_imei` as a
                left JOIN `t_jiguang_mission` as b on a.`iMissionID` = b.`iAutoID` 
                left JOIN `t_admin_order` as c on c.`iAutoID` = b.`iOrderID`
                where c.`iAutoID` in (:oid);";
        echo $sql . "<br>\n";
        $list = Db::query($sql, ['oid' => $orderID]);*/

        return $list['num'];
    }

    /**
     * 获取提交极光imei去除IPHONE数量
     *
     * @param string $orderID 订单ID字符串，多个逗号分隔
     * @return int
     */
    public function getiImeiAndroidNum($orderID)
    {
        $list = Db::table('t_xf_customer_log')
            ->alias('d')
            ->join('t_jiguang_mission_imei a','d.sImeiID = a.sImei')
            ->join('t_jiguang_mission b','a.iMissionID = b.iAutoID')
            ->join('t_admin_order c','c.iAutoID = b.iOrderID')
            ->fieldRaw('count(DISTINCT d.sImeiID) as num')
            //->fetchSql(true)
            ->where('c.iAutoID', 'in', $orderID)
            ->where('d.sSystem', '<>', 'ios')
            ->find();

        /*$sql = "select count(DISTINCT d.`sImeiID`) as num from `t_xf_customer_log` as d
                left JOIN `t_jiguang_mission_imei` as a on d.`sImeiID` = a.`sImei` 
                left JOIN `t_jiguang_mission` as b on a.`iMissionID` = b.`iAutoID` 
                left JOIN `t_admin_order` as c on c.`iAutoID` = b.`iOrderID`
                where c.`iAutoID` in (:oid) and d.sSystem <> 'ios';";

        $list = Db::query($sql, ['oid' => $orderID]);*/

        return $list['num'];
    }


    /**
     * 获取统计结果数据
     *
     * @return array
     */
    public function getCsvList()
    {
        $list = Db::table('t_data_order_arrange')
            ->order('id')
            //->limit(30)
            ->where('iType',3)
            ->where('iRegionType', '=', 1)
            ->select();
        return $list;
    }
}
