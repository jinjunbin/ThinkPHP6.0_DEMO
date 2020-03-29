<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/1/17
 * Time: 13:50
 */
namespace app\common\lib;

class ClassArr
{
    public static function smsClassStat()
    {
        return [
            'ali' => 'app\common\lib\sms\AliSms',
            'baidu' => 'app\common\lib\sms\BaiduSms',
            'jd' => 'app\common\lib\sms\JdSms',
        ];
    }

    public static function uploadClassStat()
    {
        return [
            'text' => 'xxx',
            'image' => 'xxx',
        ];
    }

    public static function initClass($type, $classs, $params = [], $needInstance = false)
    {
        // 如果工厂模式调用的方式是静态的, 这里返回类库 AliSms
        // 如果不是静态的, 返回对象
        if (!array_key_exists($type, $classs)) {
            throw new \Exception("类型：{$type} 的类库找不到");
        }
        $className = $classs[$type];

        // new ReflectionClass('A') => 建立A反射类
        // ->newInstanceArgs($args) => 相当于实例化A对象
        return $needInstance == true ? (new \ReflectionClass($className))->newInstanceArgs($params) : $className;
    }
}
