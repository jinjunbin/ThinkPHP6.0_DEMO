<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/1/14
 * Time: 16:52
 */
namespace app\demo\middleware;

class Check
{
    public function handle($request, \Closure $next)
    {
        //dump('check handle');
        $request->type = 'check中间件';

        return $next($request);
    }

    /**
     * 中间件结束调度
     * @param \think\Response $response
     */
    public function end(\think\Response $response)
    {
        //dump('check end');
    }
}
