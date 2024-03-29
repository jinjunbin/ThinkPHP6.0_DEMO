<?php

namespace app\wechat\model;

class Category extends BaseModel
{
    protected $hidden = ['icon', 'path', 'pivot', 'operate_user', 'status', 'listorder', 'create_time', 'update_time', 'delete_time'];

    public function products()
    {
        return $this->hasMany('Product', 'category_id', 'id');
    }

    public function img()
    {
        return $this->belongsTo('Image', 'topic_img_id', 'id');
    }

    public static function getCategories($ids)
    {
        $categories = self::with('products')
            ->with('products.img')
            ->select($ids);
        return $categories;
    }

    public static function getCategory($id)
    {
        $category = self::with('products')
            ->with('products.img')
            ->find($id);
        return $category;
    }
}
