<?php

namespace app\wechat\service;

use app\common\lib\enum\ScopeEnum;
use app\common\lib\Str;
use app\wechat\exception\ForbiddenException;
use app\wechat\exception\ParameterException;
use app\wechat\exception\TokenException;
use think\Exception;
use think\facade\Cache;
use think\facade\Request;

class Token
{
    // 生成令牌
    public static function generateToken()
    {
        // 32个字符组成一组随机字符串
        $randChar = Str::getRandChar(32);
        // 用三组字符串, 进行 md5 加密
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        // salt 加盐
        $tokenSalt = config('secure.token_salt');
        return md5($randChar . $timestamp . $tokenSalt);
    }


    //验证token是否合法或者是否过期
    //验证器验证只是token验证的一种方式
    //另外一种方式是使用行为拦截token，根本不让非法token
    //进入控制器
    // 需要用户和 CMS 管理员都可以访问的权限
    public static function needPrimaryScope()
    {
        $scope = self::getCurrentTokenVar('scope');
        if ($scope) {
            if ($scope >= ScopeEnum::USER) {
                return true;
            } else {
                throw new ForbiddenException();
            }
        } else {
            throw new TokenException();
        }
    }

    // 只有用户才能访问的接口权限
    public static function needExclusiveScope()
    {
        $scope = self::getCurrentTokenVar('scope');
        if ($scope) {
            if ($scope == ScopeEnum::USER) {
                return true;
            } else {
                throw new ForbiddenException();
            }
        } else {
            throw new TokenException();
        }
    }

    public static function needSuperScope()
    {
        $scope = self::getCurrentTokenVar('scope');
        if ($scope){
            if ($scope == ScopeEnum::SUPER) {
                return true;
            } else {
                throw new ForbiddenException();
            }
        } else {
            throw new TokenException();
        }
    }
    
    public static function getCurrentTokenVar($key)
    {
        $token = Request::header('token');
        $vars = Cache::get($token);

        if (!$vars) {
            throw new TokenException();
        } else {
            if (!is_array($vars)) {
                $vars = json_decode($vars, true);
            }
            if (array_key_exists($key, $vars)) {
                return $vars[$key];
            } else {
                throw new Exception('尝试获取的Token变量并不存在');
            }
        }
    }
    
    /**
     * 从缓存中获取当前用户指定身份标识
     * @param array $keys
     * @return array result
     * @throws \app\lib\exception\TokenException
     */
    public static function getCurrentIdentity($keys)
    {
        $token = Request::header('token');
        $identities = Cache::get($token);
        //cache 助手函数有bug
//        $identities = cache($token);
        if (!$identities)
        {
            throw new TokenException();
        }
        else
        {
            $identities = json_decode($identities, true);
            $result = [];
            foreach ($keys as $key)
            {
                if (array_key_exists($key, $identities))
                {
                    $result[$key] = $identities[$key];
                }
            }
            return $result;
        }
    }

    /**
     * 当需要获取全局UID时，应当调用此方法
     * 而不应当自己解析UID
     */
    public static function getCurrentUid()
    {
        $uid = self::getCurrentTokenVar('uid');
        $scope = self::getCurrentTokenVar('scope');
        if ($scope == ScopeEnum::SUPER) {
            // 只有Super权限才可以自己传入uid
            // 且必须在get参数中，post不接受任何uid字段
            $userID = input('get.uid');
            if (!$userID) {
                throw new ParameterException([
                        'msg' => '没有指定需要操作的用户对象'
                    ]);
            }
            return $userID;
        } else {
            return $uid;
        }
    }

    /**
     * 检查操作UID是否合法
     * @param $checkedUID
     * @return bool
     * @throws Exception
     * @throws ParameterException
     */
    public static function isValidOperate($checkedUID)
    {
        if(!$checkedUID){
            throw new Exception('检查UID时必须传入一个被检查的UID');
        }
        $currentOperateUID = self::getCurrentUid();
        if($currentOperateUID == $checkedUID){
            return true;
        }
        return false;
    }

    public static function verifyToken($token)
    {
        $exist = Cache::get($token);
        if($exist){
            return true;
        }
        else{
            return false;
        }
    }
}