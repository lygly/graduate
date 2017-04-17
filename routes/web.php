<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//微信路由
Route::group(['middleware'=>'csrf.ignore','prefix'=>'wechat','namespace'=>'WeChat'], function () {
    Route::any('wechat','WeChatController@serve');//连接微信和基础配置

    Route::any('/','IndexController@index'); //微信首页
    Route::any('/p/{productId}','IndexController@detail');//产品详情页
    Route::any('/profile','IndexController@profile');//个人中心页
    Route::any('/updateProfile/{openId}','IndexController@updateProfile');//更新个人资料
    Route::any('/about','IndexController@about');//关于我们页
    Route::any('/suggestion','IndexController@suggestion');//意见反馈
    Route::any('/suggestion/store','IndexController@store');//添加意见反馈
    Route::any('shopCart/addr/{customerId}','ShopCartController@addr');//确定订单页面
    Route::any('shopCart/order','ShopCartController@order');//确认订单
    Route::any('shopCart/pay','ShopCartController@pay');//支付
    Route::resource('shopCart', 'ShopCartController'); //购物车资源路由
    Route::resource('shopAddr', 'ShoppingAddrController'); //收货地址资源路由
});

//LoginController 里面的
Route::any('admin/login','Admin\LoginController@login');//后台登录路由
Route::get('admin/code','Admin\LoginController@code');//后台登录验证码引入路由
//IndexController
Route::group(['middleware'=>'admin.login','prefix'=>'admin','namespace'=>'Admin'],function (){
    Route::get('/','IndexController@index'); //后台欢迎界面
    Route::get('info','IndexController@info'); //后台欢迎界面
    Route::get('quit','LoginController@quit');
    Route::any('pass','IndexController@pass');
    //订单管理
    Route::any('order','OrderController@index');
    Route::any('order/detail','OrderController@detail'); //订单明细
    Route::delete('order/{orderId}','OrderController@delete');//删除订单
    //类型管理
    Route::post('dictionary/changeOrder','DictionaryController@changeOrder'); //异步修改排序路由
    Route::resource('dictionary', 'DictionaryController'); //分类管理资源路由

    Route::resource('repository', 'RepositoryController'); //题库资源路由
    //个人中心
    Route::resource('customer', 'CustomerController'); //客户信息资源路由
    Route::resource('about', 'AboutController'); //关于我们资源路由
    Route::resource('suggestion', 'SuggestionController'); //意见反馈资源路由

    //商品管理
    Route::resource('productSpec', 'ProductSpecController'); //规格定义资源路由
    Route::resource('product', 'ProductController'); //商品管理资源路由
    Route::resource('productProperty', 'ProductPropertyController'); //商品属性资源路由
    Route::resource('productDetail', 'ProductDetailController');//商品清单
    Route::resource('productPhoto', 'ProductPhotoController');//商品图片


    Route::any('upload','CommonController@upload');  //图片上传路由


});


