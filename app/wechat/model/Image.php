<?php

namespace app\wechat\model;

use think\Model;

class Image extends BaseModel
{
    protected $hidden = ['from', 'update_time', 'delete_time'];

    public function getUrlAttr($value, $data)
    {
        return $this->prefixImgUrl($value, $data);
    }
}
