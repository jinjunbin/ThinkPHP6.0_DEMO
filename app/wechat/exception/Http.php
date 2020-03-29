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
use think\Response;
use Throwable;

class Http extends Handle
{
    public $httpStatus = 500;
    /**
     * Render an exception into an HTTP response.
     *
     * @access public
     * @param \think\Request   $request
     * @param Throwable $e
     * @return Response
     */
    public function render($request, Throwable $e): Response
    {
        // 添加自定义异常处理机制
        if ($e instanceof \think\Exception) {
            return Show::error($e->getMessage(), $e->getCode());
        }
        if ($e instanceof \think\exception\HttpResponseException) {
            return parent::render($request, $e);
        }

        if (method_exists($e, 'getStatusCode')) {
            $httpStatus = $e->getStatusCode();
        } else {
            $httpStatus = $this->httpStatus;
        }
        //调试模式关闭时
        if (!env('app_debug')) {
            return Show::error($e->getMessage(), $e->getCode(), $httpStatus);
        }

        // 其他错误交给系统处理
        return parent::render($request, $e);
    }
}
