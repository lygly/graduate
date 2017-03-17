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

/*Route::get('/', function () {
    return view('welcome');
'prefix'=>'Home','namespace'=>'Home'
});*/
//前台路由
Route::group([],function (){
    Route::get('/','Home\IndexController@index');//前台首页
    Route::get('/cate/{cate_id}','Home\IndexController@cate');//前台列表页
    Route::get('/a/{art_id}','Home\IndexController@article');//前台文章页
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
    //类型管理
    Route::post('dictionary/changeOrder','DictionaryController@changeOrder'); //异步修改排序路由
    Route::resource('dictionary', 'DictionaryController'); //分类管理资源路由

    Route::resource('repository', 'RepositoryController'); //分类管理资源路由

   /* Route::post('cate/changeOrder','CategoryController@changeOrder'); //异步修改排序路由
    Route::resource('category', 'CategoryController'); //分类管理资源路由

    Route::resource('article', 'ArticleController'); //文章分类管理资源路由

    Route::resource('links', 'LinksController'); //友情链接资源路由
    Route::post('links/changeOrder','LinksController@changeOrder'); //异步修改排序路由

    Route::resource('navs', 'NavsController'); //友情链接资源路由
    Route::post('navs/changeOrder','NavsController@changeOrder');//异步修改排序路由

    Route::get('config/putfile','ConfigController@putFile'); //写入配置文件
    Route::resource('config', 'ConfigController'); //网站配置资源路由
    Route::post('config/changeOrder','ConfigController@changeOrder');//异步修改排序路由
    Route::post('config/changeContent','ConfigController@changeContent');//修改配置内容*/


    Route::any('upload','CommonController@upload');  //图片上传路由


});


