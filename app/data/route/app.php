<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;

Route::get('think', function () {
    return 'hello,ThinkPHP6!';
});
//Route::rule('index', 'data/index', 'GET');

Route::resource('blog', 'Blog');    //测试blog路由

Route::resource('data', 'Data/Data');    //统计数据

Route::miss(function() {    //MISS路由
    return '404 Not Found!';
});