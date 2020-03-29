<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/3/17
 * Time: 20:11
 */
use think\facade\Route;

//Banner
Route::get(':version/hello', ':version.index/hello');   //http://tp6-mall.imooc.com/wechat/v1/hello
Route::get('hello', 'index/hello');                     //http://tp6-mall.imooc.com/wechat/hello
