<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/1/14
 * Time: 14:18
 */
use think\facade\Route;

//登陆
Route::rule('login', 'login/index', 'GET');
Route::rule('login/index', 'login/index', 'GET');
Route::rule('login/recaptcha', 'login/recaptcha', 'GET');
//Route::get('login/recaptcha/[:id]', "\\think\\captcha\\CaptchaController@index");
Route::rule('login/check', 'login/check', 'POST');
Route::rule('index/index', 'index/index', 'GET');
Route::rule('index/welcome', 'index/welcome', 'GET');
Route::rule('logout/index', 'logout/index', 'GET');


Route::resource('category', 'Category');
Route::rule('category/index', 'category/index', 'GET');
Route::rule('category/add', 'category/add', 'GET');
Route::rule('category/save', 'category/save', 'POST');
Route::rule('category/listorder', 'category/listorder', 'GET');
Route::rule('category/status', 'category/status', 'GET');
Route::rule('category/dialog', 'category/dialog', 'GET');
Route::rule('category/getByPid', 'category/getByPid', 'GET');

Route::resource('goods', 'Goods');
Route::rule('goods/index', 'goods/index', 'GET');
Route::rule('goods/add', 'goods/add', 'GET');
Route::rule('goods/save', 'goods/save', 'POST');
Route::rule('specs/dialog', 'specs/dialog', 'GET');
Route::rule('specsValue/save', 'specsValue/save', 'GET');
Route::rule('specsValue/getBySpecsId', 'specsValue/getBySpecsId', 'GET');
Route::rule('image/upload', 'image/upload', 'POST');
Route::rule('image/layUpload', 'image/layUpload', 'POST');

//Route::get('/', function () {
//    return 'hello,ThinkPHP6!';
//});
