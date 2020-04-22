<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/2/25
 * Time: 18:45
 */

namespace app\common\lib;

class Arr
{
    /**
     * 分类树, 支持无限级分类
     * @param $data
     * @return array
     */
    public static function getTree($data)
    {
        $items = [];
        foreach ($data as $v) {
            $v['category_id'] = $v['id'];
            unset($v['id']);
            $items[$v['category_id']] = $v;
        }
        $tree = [];
        foreach ($items as $id => $item) {
            if (isset($items[$item['pid']])) {
                $items[$item['pid']]['list'][] = &$items[$id];
            } else {
                $tree[] = &$items[$id];
            }
        }

        return $tree;
    }

    public static function sliceTreeArr($data, $firstCount = 5, $secondCount = 3, $threeCount = 5)
    {
        $data = array_slice($data, 0, $firstCount);
        foreach ($data as $k => $v) {
            if (!empty($v['list'])) {
                $data[$k]['list'] = array_slice($v['list'], 0, $secondCount);
                foreach ($v['list'] as $kk => $vv) {
                    if (!empty($vv['list'])) {
                        $data[$k]['list'][$kk]['list'] = array_slice($vv['list'], 0, $threeCount);
                    }
                }
            }
        }

        return $data;
    }

    /**
     * 分页默认返回的数据
     * @param int $num
     * @return array
     */
    public static function getPaginateDefaultData($num = 5)
    {
        $result = [
            'total' => 0,
            'per_page' => $num,
            'current_page' => 1,
            'last_page' => 0,
            'data' => [],
        ];
        return $result;
    }

    /**
     * 多维数组排序
     * @param $result
     * @param $key
     * @param int $sort
     * @return array
     */
    public static function arrsSortByKey($result, $key, $sort = SORT_DESC)
    {
        if (!is_array($result) || !$key) {
            return [];
        }
        array_multisort(array_column($result, $key), $sort, $result);
        return $result;
    }

    public static function fromArrayToModel($m, $array)
    {
        foreach ($array as $key => $value) {
            $m[$key] = $value;
        }
        return $m;
    }
}
