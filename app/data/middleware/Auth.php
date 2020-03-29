<?php
declare (strict_types = 1);

namespace app\middleware;

class Auth
{
    /**
     * 处理请求
     *
     * @param \think\Request $request
     * @param \Closure       $next
     * @return Response
     */
    public function handle($request, \Closure $next)
    {
        $response = $next($request);    //后置行为
        //
        if ($request->param('title') == 'think') {
            return redirect('index/hello');
        }
        //dd($request);
        return $response;
        //return $next($request);    //前置行为
    }

    /**
     * 结束调度
     *
     * @param \think\Response $response
     */
    public function end(\think\Response $response)
    {
        // 回调行为
        dd($response);
    }
}
