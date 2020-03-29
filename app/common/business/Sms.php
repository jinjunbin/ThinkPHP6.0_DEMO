<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/1/16
 * Time: 16:58
 */
declare(strict_types=1);
namespace app\common\business;

use app\common\lib\sms\AliSms;
use app\common\lib\Num;
use app\common\lib\ClassArr;
use app\RedisEx;
use think\facade\Cache;

class Sms
{
    public static function sendCode(string $phoneNumber, int $len, string $type = 'ali') :bool
    {
        // 生成短信验证码 4位
        $code = Num::getCode($len);

        // 一般模式
        /*$sms = AliSms::sendCode($phoneNumber, $code);*/

        // 工厂模式
        /*$type = ucfirst($type);
        $class = 'app\common\lib\sms\\'.$type.'Sms';
        $sms = $class::sendCode($phoneNumber, $code);*/

        // 利用反射机制处理工厂模式
        $classStats = ClassArr::smsClassStat();
        $classObj = ClassArr::initClass($type, $classStats, [], false);
        if ($classObj == false) {
            // 最好在记录一个日志
            return false;
        }
        $sms = $classObj::sendCode($phoneNumber, $code);

        if ($sms) {
            // 需要把我们得到的验证码记录到 redis 并且需要给出一个失效时间 1分钟
            // 1.安装 redis 扩展 redis.dll  linux unix:redis.so
            // 2.安装 redis 服务 linux服务器进入命令#./redis-cli
            cache(config('redis.code_pre').$phoneNumber, $code, config('redis.code_expire'));
            //RedisEx::getInstance()->set(config('redis.code_pre').$phoneNumber, $code, config('redis.code_expire'));
            //$b = RedisEx::getInstance()->get(config('redis.code_pre').$phoneNumber);
            //dd($b);
            //Cache::store('redis_tp')->set('ddd', 444, 20);
            //dd(Cache::store('redis_tp')->get('ddd'));
        }

        return $sms;
    }
}
