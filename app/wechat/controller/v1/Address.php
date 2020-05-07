<?php

namespace app\wechat\controller\v1;

use app\wechat\controller\Base;
use app\wechat\model\User as UserModel;
use app\wechat\model\UserAddress as UserAddressModel;
use app\wechat\service\Token;
use app\wechat\service\Token as TokenService;
use app\wechat\validate\AddressNew;
use app\common\lib\Arr;
use app\wechat\exception\SuccessMessage;
use app\wechat\exception\UserException;
use think\Controller;

class Address extends Base
{
    // 前置方法在 tp6 中已失效
    /*protected $beforeActionList = [
        'checkPrimaryScope' => ['only' => 'createOrUpdateAddress,getUserAddress']
    ];*/
    
    /**
     * 获取用户地址信息
     * @return UserAddress
     * @throws UserException
     */
    public function getUserAddress()
    {
        // 前置方法在 tp6 中已失效
        self::checkPrimaryScope();

        $uid = Token::getCurrentUid();
        $userAddress = UserAddressModel::where('user_id', $uid)
            ->find();
        if(!$userAddress){
            throw new UserException([
               'msg' => '用户地址不存在',
                'errorCode' => 60001
            ]);
        }
        return $userAddress;
    }

    /**
     * 更新或者创建用户收获地址
     */
    public function createOrUpdateAddress()
    {
        // 前置方法在 tp6 中已失效
        self::checkPrimaryScope();

        $validate = new AddressNew();
        $validate->goCheck();

        // 根据 Token 来获取 uid
        // 根据 uid 来查找用户数据, 判断用户是否存在, 如果不存在抛出异常
        // 获取用户从客户端提交上来的地址信息
        // 根据用户地址信息是否存在, 从而判断是添加地址还是更新地址

        $uid = TokenService::getCurrentUid();
        $user = UserModel::findOrEmpty($uid);
        if ($user->isEmpty()) {
            throw new UserException([
                'httpStatus' => 404,
                'message' => '用户收获地址不存在',
                'status' => 60001
            ]);
        }
        $userAddress = $user->address;
        // 根据规则取字段是很有必要的，防止恶意更新非客户端字段
        $data = $validate->getDataByRule(input('post.'));
        if (!$userAddress) {
            // 关联属性不存在，则新建
            $user->address()
                ->save($data);
        } else {
            // 存在则更新
            // Arr::fromArrayToModel($user->address, $data);
            // 新增的save方法和更新的save方法并不一样
            // 新增的save来自于关联关系
            // 更新的save来自于模型
            $user->address->save($data);
        }
        return json(new SuccessMessage(), 201);
    }
}
