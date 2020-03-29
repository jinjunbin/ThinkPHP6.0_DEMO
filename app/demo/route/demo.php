<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/1/14
 * Time: 14:18
 */
use think\facade\Route;

//账号密码登录
Route::get('index', 'index/index');
Route::rule('hello/:name', 'index/hello', 'GET');
Route::get('abc', 'index/abc');
Route::get('hellotime', 'index/hellotime');
Route::get('mysql', 'index/mysqlDemo');
Route::get('snowflake', 'index/snowflake');

Route::get('e', 'E/index');
Route::get('e/abc', 'E/abc');


//http://1.cn/demo/detail
Route::rule('detail', 'detail/index', 'GET')->middleware(\app\demo\middleware\Detail::class);
