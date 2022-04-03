<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/3/17
 * Time: 20:11
 */
/**
 * 路由注册
 *
 * 以下代码为了尽量简单，没有使用路由分组
 * 实际上，使用路由分组可以简化定义
 * 并在一定程度上提高路由匹配的效率
 */

// 写完代码后对着路由表看，能否不看注释就知道这个接口的意义
use think\facade\Route;

//Sample
Route::get(':version/sample/:key', ':version.Sample/getSample');
Route::post(':version/sample/test3', ':version.Sample/test3');

//Miss 404
//Miss 路由开启后，默认的普通模式也将无法访问
//Route::miss('v1.Miss/miss');

//Banner
//http://tp6-mall.imooc.com/wechat/v1/hello
//http://tp6-mall.imooc.com/wechat/v1/banner/1?num=19&XDEBUG_SESSION_START=11867
Route::get(':version/banner/:id', ':version.Banner/getBanner');
Route::get('hello/[:name]', 'index/hello');

//Theme
// 如果要使用分组路由，建议使用闭包的方式，数组的方式不允许有同名的key
//Route::group(':version/theme',[
//    '' => [':version.Theme/getThemes'],
//    ':t_id/product/:p_id' => [':version.Theme/addThemeProduct'],
//    ':t_id/product/:p_id' => [':version.Theme/addThemeProduct']
//]);

//Route::group(':version/theme', function () {
//    Route::get('', ':version.Theme/getSimpleList');
//    Route::get('/:id', ':version.Theme/getComplexOne');
//    Route::post(':t_id/product/:p_id', ':version.Theme/addThemeProduct');
//    Route::delete(':t_id/product/:p_id', ':version.Theme/deleteThemeProduct');
//});

Route::get(':version/theme', ':version.Theme/getSimpleList');
//http://tp6-mall.imooc.com/wechat/v1/theme?ids=1,2,3&XDEBUG_SESSION_START=16906
Route::get(':version/theme/:id', ':version.Theme/getComplexOne');
//http://tp6-mall.imooc.com/wechat/v1/theme/1?XDEBUG_SESSION_START=16906
//Route::get(':version/theme', ':version.Theme/getThemes');
//Route::post(':version/theme/:t_id/product/:p_id', ':version.Theme/addThemeProduct');
//Route::delete(':version/theme/:t_id/product/:p_id', ':version.Theme/deleteThemeProduct');

//Product
Route::post(':version/product', ':version.Product/createOne');
Route::delete(':version/product/:id', ':version.Product/deleteOne');
Route::get(':version/product/by_category/paginate', ':version.Product/getByCategory');
Route::get(':version/product/by_category', ':version.Product/getAllInCategory');
//http://tp6-mall.imooc.com/wechat/v1/product/by_category?id=3&XDEBUG_SESSION_START=16906
Route::get(':version/product/recent', ':version.Product/getRecent');
//http://tp6-mall.imooc.com/wechat/v1/product/recent?count=15&XDEBUG_SESSION_START=16906
Route::get(':version/product/:id', ':version.Product/getOne', [], ['id' => '\d+']);
//http://tp6-mall.imooc.com/wechat/v1/product/1?XDEBUG_SESSION_START=16906

//Category
Route::get(':version/category', ':version.Category/getCategories');
// 正则匹配区别id和all，注意d后面的+号，没有+号将只能匹配个位数
//Route::get(':version/category/:id', ':version.Category/getCategory',[], ['id'=>'\d+']);
//Route::get(':version/category/:id/products', ':version.Category/getCategory',[], ['id'=>'\d+']);
Route::get(':version/category/all', ':version.Category/getAllCategories');
//http://tp6-mall.imooc.com/wechat/v1/category/all?XDEBUG_SESSION_START=16906

//Token
Route::post(':version/token/user', ':version.Token/getToken');

Route::post(':version/token/app', ':version.Token/getAppToken');
Route::post(':version/token/verify', ':version.Token/verifyToken');

//Address
Route::post(':version/address', ':version.Address/createOrUpdateAddress');
Route::get(':version/address', ':version.Address/getUserAddress');

//Order
Route::post(':version/order', ':version.Order/placeOrder');
Route::get(':version/order/:id', ':version.Order/getDetail', [], ['id' => '\d+']);
Route::put(':version/order/delivery', ':version.Order/delivery');

//不想把所有查询都写在一起，所以增加by_user，很好的REST与RESTFul的区别
Route::get(':version/order/by_user', ':version.Order/getSummaryByUser');
Route::get(':version/order/paginate', ':version.Order/getSummary');

//Pay
Route::post(':version/pay/pre_order', ':version.Pay/getPreOrder');
Route::post(':version/pay/notify', ':version.Pay/receiveNotify');
Route::post(':version/pay/re_notify', ':version.Pay/redirectNotify');
Route::post(':version/pay/concurrency', ':version.Pay/notifyConcurrency');

//Message
Route::post(':version/message/delivery', ':version.Message/sendDeliveryMsg');



//return [
//        ':version/banner/[:location]' => ':version.Banner/getBanner'
//];

//Route::miss(function () {
//    return [
//        'msg' => 'your required resource are not found',
//        'error_code' => 10001
//    ];
//});
