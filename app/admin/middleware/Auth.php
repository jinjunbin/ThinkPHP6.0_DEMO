<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/1/14
 * Time: 16:52
 */
declare (strict_types = 1);
namespace app\admin\middleware;

use think\facade\Session;

class Auth
{
    public function handle($request, \Closure $next)
    {
        $request->type = 'Auth 中间件';
        // 前置中间件
        if (empty(session(config('admin.session_admin'))) && !preg_match('/login/', $request->pathinfo())) {
            // 跳过验证码的显示
            if (!preg_match('/recaptcha/', $request->pathinfo()) && !preg_match('/check/', $request->pathinfo())) {
                //dump($request->pathinfo());//die;
                return redirect((string)url('login/index'));
            }
        }
        $response = $next($request);

        /*if (empty(session(config('admin.session_admin'))) && $request->controller() != 'login') {
            return redirect(url('login/index'));
        }*/

        // 后置中间件
        return $response;
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
