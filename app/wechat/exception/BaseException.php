<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/4/4 0004
 * Time: 上午 12:57
 */

namespace app\wechat\Exception;

use think\Exception;

class BaseException extends Exception
{
    // HTTP 状态码 404,200
    public $httpStatus = 400;

    // 错误具体信息
    public $message = 'invalid parameters';

    // 自定义的错误码
    public $status = 999;

    public $shouldToClient = true;

    /**
     * 构造函数，接收一个关联数组
     * @param array $params 关联数组只应包含code、msg和errorCode，且不应该是空值
     */
    public function __construct($params=[])
    {
        if(!is_array($params)){
            return;
        }
        if(array_key_exists('httpStatus',$params)){
            $this->httpStatus = $params['httpStatus'];
        }
        if(array_key_exists('message',$params)){
            $this->message = $params['message'];
        }
        if(array_key_exists('status',$params)){
            $this->status = $params['status'];
        }
    }
}
