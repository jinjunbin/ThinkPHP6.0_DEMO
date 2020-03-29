<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/1/14
 * Time: 14:18
 */
use think\facade\Route;

//账号密码登录
Route::rule('index', 'index/index', 'GET');
Route::rule('index/getRotationChart', 'index/getRotationChart', 'GET');
Route::rule('index/cagegoryGoodsRecommend', 'index/cagegoryGoodsRecommend', 'GET');
Route::rule('index/demo', 'index/demo', 'GET');
Route::rule('hello', 'index/hello', 'GET');
Route::rule('hello2', 'index/hello2', 'GET');
Route::rule('smscode', 'sms/code', 'POST');
Route::rule('login', 'login/index', 'POST');
Route::rule('logout', 'logout/index', 'POST');
Route::resource('user', 'User');
Route::resource('category', 'Category');

Route::rule('category/search/:id', 'category/search');
Route::rule('subcategory/:id', 'category/sub');
Route::rule('lists', 'mall.lists/index');
Route::rule('detail/:id', 'mall.detail/index');

Route::rule('cart/add', 'cart/add', 'POST');
Route::rule('cart/lists', 'cart/lists', 'GET');
Route::rule('cart/delete', 'cart/delete', 'POST');
Route::rule('cart/update', 'cart/update', 'POST');
Route::rule('mall.init', 'mall.init/index', 'POST');

Route::rule('address', 'address/index', 'GET');
Route::resource('order', 'order.index');
