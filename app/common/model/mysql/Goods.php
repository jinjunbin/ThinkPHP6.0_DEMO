<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/2/26
 * Time: 15:40
 */
namespace app\common\model\mysql;

class Goods extends BaseModel
{
    public function goodsSku()
    {
        return $this->hasMany(GoodsSku::class, 'goods_id', 'id');
    }

    public function getIdByName($data)
    {
        if (empty($data['title'])) {
            return false;
        }

        $where = [
            'title' => trim($data['title']),
        ];

        $result = $this->where($where)->find();

        return $result;
    }

    /**
     * title 查询条件表达式
     * 搜索器仅在调用 withSearch 方法的时候触发
     * @param $query
     * @param $value
     */
    public function searchTitleAttr($query, $value)
    {
        $query->where('title', 'like', '%'.$value.'%');
    }
    public function searchCreateTimeAttr($query, $value)
    {
        $query->whereBetweenTime('create_time', $value[0], $value[1]);
    }
    /**
     * 获取后端列表数据
     * @param $data
     * @param int $num
     * @return \think\Paginator
     * @throws \think\db\exception\DbException
     */
    public function getLists($likeKeys, $data, $num = 10)
    {
        $order = ['listorder' => 'desc', 'id' => 'desc'];
        if (!empty($likeKeys)) {
            //搜索器
            $res = $this->withSearch($likeKeys, $data);
        } else {
            $res = $this;
        }

        $list = $res->whereIn('status', [0,1])
            ->order($order)
            ->paginate($num);
        //echo $this->getLastSql();
        return $list;
    }

    public function getNormalGoodsByCondition($where, $field = true, $limit = 5)
    {
        $order = ['listorder' => 'desc', 'id' => 'desc'];

        $where['status'] = config('status.mysql.table_normal');

        $result = $this->where($where)
            ->order($order)
            ->field($field)
            ->limit($limit)
            ->select();
        return $result;
    }

    public function getImageAttr($value)
    {
        return request()->domain().$value;
    }
    public function getCarouselImageAttr($value)
    {
        if (!empty($value)) {
            $value = explode(',', $value);
            $value = array_map(function ($v) {
                return request()->domain().$v;
            }, $value);
        }
        return $value;
    }

    public function getNormalGoodsFindInSetCategoryId($categoryId, $field = true, $limit = 10)
    {
        $order = ['listorder' => 'desc', 'id' => 'desc'];

        $result = $this->whereFindInSet('category_path_id', $categoryId)
            ->where('status', '=', config('status.mysql.table_normal'))
            ->order($order)
            ->field($field)
            ->limit($limit)
            ->select();
        //echo $this->getLastSql();
        return $result;
    }

    public function getNormalLists($data, $order, $num = 10, $field = true)
    {
        $res = $this;
        if (isset($data['category_path_id'])) {
            $res = $this->whereFindInSet('category_path_id', $data['category_path_id']);
        }

        $list = $res->where('status', '=', config('status.mysql.table_normal'))
            ->order($order)
            ->field($field)
            ->paginate($num);
        return $list;
    }
}
