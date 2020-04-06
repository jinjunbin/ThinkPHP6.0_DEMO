<?php

namespace app\wechat\model;

use app\wechat\Exception\BannerMissException;

class Banner extends BaseModel
{
    protected $hidden = ['update_time', 'delete_time'];
    //protected $visible = ['id'];

    public function items()
    {
        return $this->hasMany('BannerItem', 'banner_id', 'id');
    }

    /**
     * @param $id int banner所在位置
     * @return Banner
     */
    public static function getBannerById($id)
    {
        $banner = self::with(['items', 'items.img'])
            ->find($id);

        return $banner;
        $banner = [];



        if (!$banner) {
            throw new BannerMissException();
        }
//        $banner = self::with(['items','items.img'])
//            ->find($id);

//         $banner = BannerModel::relation('items,items.img')
//             ->find($id);
        return $banner;
    }
}
