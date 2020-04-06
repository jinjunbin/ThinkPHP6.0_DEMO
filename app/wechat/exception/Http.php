<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/1/14
 * Time: 16:41
 */

namespace app\wechat\exception;

use app\common\lib\Show;
use think\exception\Handle;
use think\facade\Log;
use think\Response;
use Throwable;

class Http extends Handle
{
    private $httpStatus = 500;
    private $message;
    private $status;
    private $request_url;// 需要返回客户端当前请求的 URL 路径

    /**
     * Render an exception into an HTTP response.
     *
     * @access public
     * @param \think\Request $request
     * @param Throwable $e
     * @return Response
     */
    public function render($request, Throwable $e): Response
    {
        // 添加自定义异常处理机制
        if ($e instanceof BaseException) {
            // 如果是自定义的异常
            $this->httpStatus = $e->httpStatus;
            $this->message = $e->message;
            $this->status = $e->status;
        } else {
            // 如果是服务器未处理的异常，将http状态码设置为500，并记录日志
            if (env('app_debug')) {
                // 调试状态下需要显示TP默认的异常页面，因为TP的默认页面
                // 很容易看出问题
                return parent::render($request, $e);
                die;
            }
            $this->httpStatus = 500;
            $this->message = config('status.error_code.999');
            $this->status = 999;

            //将异常写入日志
            Log::error($e->getMessage() . '[' . $e->getFile() . ':' . $e->getLine() . ']');
        }

        return Show::error($this->message, $this->status, $this->httpStatus, ['request_url' => Request()->url()]);
    }
}
