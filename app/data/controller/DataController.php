<?php
declare (strict_types = 1);

namespace app\data\controller;

use think\Request;
use app\data\model\AdminOrder;
use app\data\model\DataOrder;
use app\data\model\JiguangTagName;
use app\data\model\DataOrderArrange;

class DataController
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
        set_time_limit(0);
        $do = new DataOrderArrange();
        $list = $do->getList();//整理的未处理数据
        $t = time();
        dd($list);//查看数据
        //处理数据
        $i = 0;
        foreach ($list as $k => $v) {
            $tmp = array();
            $tmp['iImeiNum'] = $do->getImeiNum($v['iOrderID']);  //订单包含imei数
            $tmp['iImeiAndroid'] = $do->getiImeiAndroidNum($v['iOrderID']);  //减去ipone数
            $tmp['iImeiBack'] = $do->getImeiCount($v['iOrderID']);  //返回imei数
            $tmp['tagNum'] = json_encode($do->getTagList($v['iOrderID']));   //tag统计数据
            $tmp['b68'] = $do->getTagByID('b68', $v['iOrderID']);   //指定TAG统计数据
            $tmp['b80'] = $do->getTagByID('b80', $v['iOrderID']);   //指定TAG统计数据
            $tmp['b81'] = $do->getTagByID('b81', $v['iOrderID']);   //指定TAG统计数据
            $tmp['update_time'] = $t;
            //dd($tmp);
            $rst = $do->update($tmp,['id' => $v['id']]);
            //dd($rst);
            $i++;
        }
        return $i;
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        set_time_limit(0);
        //先从订单表获取数据
        $do = new AdminOrder();
        //$list = $do->getLoupanList();//排序的楼盘数据
        $list = $do->getCityList();//排序的城市数据
        //$list = $do->getRegionList();//排序的地区数据
        //$list = $do->getBlockList();//排序的板块数据
        $data = array();    //保存进整理表的数据
        $tmp = array();
        dd($list);//查看数据
        //处理重复数据并保存
        foreach ($list as $k => $v) {
            if(empty($tmp)) {
                $tmp = $v;
                $tmp['iOrderID'] = $v['iAutoID'];
                unset($tmp['iAutoID']);
            } else {
                if(
                    //$tmp['sLoupanName'] == $v['sLoupanName'] &&
                    $tmp['sCityName'] == $v['sCityName']// &&
                    //$tmp['sRegion'] == $v['sRegion'] //&&
                    //$tmp['sBlock'] == $v['sBlock']
                ) { //重复数据订单ID保存在一起
                    $tmp['iOrderID'] .= ',' . $v['iAutoID'];
                } else { //不重复则将tmp保存进数据库，将新数据替换进tmp
                    $rst = DataOrderArrange::create($tmp); //保存
                    $tmp = $v;
                    $tmp['iOrderID'] = $v['iAutoID'];
                    unset($tmp['iAutoID']);
                }
            }
        }
        //保存最后一条
        if(!empty($tmp)) {
            $rst = DataOrderArrange::create($tmp); //保存
        }
        //dd()
        return json($rst);
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
        //halt('输出测试');
        $do = new DataOrderArrange();
        $list = $do->getCsvList();
        $tg = new JiguangTagName();
        $tag_list = $tg->getTagidList();
        //dd($tag_list);
        $data = array();//
        //以下是标题
        $data[0][0] = 'ID';
        $data[0][1] = 'iOrderID';
        $data[0][2] = '订单名称';
        $data[0][3] = '楼盘名称';
        $data[0][4] = '城市';
        $data[0][5] = '区域';
        $data[0][6] = '板块';
        $data[0][7] = '订单类型';
        $data[0][8] = '区域项目类型';
        $data[0][9] = '提供给极光总imei数';
        $data[0][10] = '减去iphone数';
        $data[0][11] = '返回imei数';
        $data[0][12] = 'b68';
        $data[0][13] = 'b80';
        $data[0][14] = 'b81';
        foreach ($tag_list as $k => $v) {
            $data[0][] = $v;
        }
        //dd($data);
        //以下是内容
        if (!empty($list)) {
            foreach ($list as $k => $v) {
                $tmp = array();
                $tmp[0] = $v['id'];
                $tmp[1] = str_replace(",", "-", $v['iOrderID']);//逗号替换掉
                $tmp[2] = $v['sName'];
                $tmp[3] = $v['sLoupanName'];
                $tmp[4] = $v['sCityName'];
                $tmp[5] = $v['sRegion'];
                $tmp[6] = $v['sBlock'];
                $tmp[7] = $v['iType'];
                $tmp[8] = $v['iRegionType'];
                $tmp[9] = $v['iImeiNum'];
                $tmp[10] = $v['iImeiAndroid'];
                $tmp[11] = $v['iImeiBack'];
                $tmp[12] = $v['b68'];
                $tmp[13] = $v['b80'];
                $tmp[14] = $v['b81'];
                $k = 15;
                //先将json数据整理下
                $tags = json_decode($v['tagNum'], true);
                $tags_list = array();
                foreach ($tags as $key => $val) {
                    $tags_list[$val['sTagid']] = $val['num'];
                }
                //然后对应保存在对应位置
                foreach ($tag_list as $ke => $va) {
                    if (isset($tags_list[$va])) {
                        $tmp[$k++] = $tags_list[$va];
                    } else {
                        $tmp[$k++] = 0;
                    }
                }
                //保存
                $data[] = $tmp;
            }
        }
        //dd($data);

        //写CSV
        $str = '';
        foreach ($data as $k => $v) {
            $str .= implode(",", $v) . PHP_EOL;
        }
        //echo $str;
        //dd($str);
        $str = iconv("UTF-8", "gbk//TRANSLIT", $str);

        return download($str, date('YmdH') . '.csv', true);
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
