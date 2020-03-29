<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/2/27
 * Time: 0:17
 */
namespace app\common\lib;

class Show
{
    /**
     * @param array $data
     * @param string $message
     * @return \think\response\Json
     */
    public static function success($data = [], $message = 'OK')
    {
        $result = [
            'status' => config('status.success'),
            'message' => $message,
            "result" => $data,
        ];

        return json($result);
    }

    /**
     * @param array $data
     * @param string $message
     * @param int $status
     * @return \think\response\Json
     */
    public static function error($message = 'error', $status = 0, $httpStatus = 200, $data = [])
    {
        // Show::error调用
        // message 和 status 位置对换
        // $message = Status::getErrMsg($status) ?: $message;
        // 测试 传入的 $message = '' && Status::getErrMsg($status) = '' 时, 会不会取到默认的 'error'
        // 传入的 $message 想用 getErrMsg, 但又想传 $httpStatus , 怎么办?
        $result = [
            'status' => $status,
            'message' => $message,
            "result" => $data,
        ];

        return json($result, $httpStatus);
    }
}
