<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/1/14
 * Time: 16:52
 */
namespace app\demo\middleware;

class Detail
{
    public function handle($request, \Closure $next)
    {
        dump('detail handle');
        $request->type = 'detail中间件';

        return $next($request);
    }

    /**
     * 中间件结束调度
     * @param \think\Response $response
     */
    public function end(\think\Response $response)
    {
        dump('detail end');
    }
}
