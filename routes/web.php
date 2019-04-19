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

Route::get('/', function () {
    return view('welcome');
});

Route::namespace('Auth')->prefix('auth')->group(function () {
    // 在 "App\Http\Controllers\Auth" 命名空间下的控制器
    //注册
    Route::post('register', 'RegisterController@register');

    //登录
    Route::post('login', 'LoginController@login');

    //注销登录
    Route::post('logout', 'LogoutController@logout');
});

//前台路由组
Route::group(['namespace' => 'Home', 'prefix' => 'home'], function(){
    // 控制器在 "App\Http\Controllers\Home" 命名空间下

    //前台index
    Route::get('/index', 'IndexController@index');

    //用户
    Route::post('user/edit', 'UserController@edit');

    Route::get('user/show', 'UserController@show');

    Route::get('user/topic', 'UserController@getUserTopic');

    //话题
    Route::get('topic/index', 'TopicController@index');

    Route::post('topic/store', 'TopicController@store');

    Route::post('topic/update', 'TopicController@update');

    Route::post('topic/delete', 'TopicController@delete');

    Route::get('topic/show', 'TopicController@show');

    //公告
    Route::get('notice/index', 'NoticeController@index');

    Route::get('notice/show', 'NoticeController@show');

    //报事报修
    Route::get('repair/index', 'RepairController@index');

    Route::get('repair/show', 'RepairController@show');

    Route::post('repair/store', 'RepairController@store');

    Route::post('repair/update', 'RepairController@update');

    //生活服务
    Route::get('service/index', 'ServiceController@index');

    Route::get('service/show', 'ServiceController@show');

    Route::post('service/store', 'ServiceController@store');

    Route::post('service/update', 'ServiceController@update');

    Route::post('service/delete', 'ServiceController@delete');

});

//后台路由组
Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function(){
    // 控制器在 "App\Http\Controllers\Admin" 命名空间下

    //后台index
    Route::get('/index', 'IndexController@index');

    //话题
    Route::get('topic/index', 'TopicController@index');

    Route::post('topic/store', 'TopicController@store');

    Route::put('topic/update/{id}', 'TopicController@update');

    Route::delete('topic/delete/{id}', 'TopicController@delete');

    Route::get('topic/show/{id}', 'TopicController@show');

    Route::put('topic/publish/{id}', 'TopicController@publish');

    Route::put('topic/offline/{id}', 'TopicController@offline');

    //公告
    Route::get('notice/index', 'NoticeController@index');

    Route::post('notice/store', 'NoticeController@store');

    Route::put('notice/update/{id}', 'NoticeController@update');

    Route::delete('notice/delete/{id}', 'NoticeController@delete');

    Route::put('notice/publish/{id}', 'NoticeController@publish');

    Route::put('notice/offline/{id}', 'NoticeController@offline');

    Route::get('notice/show/{id}', 'NoticeController@show');

    //报事报修
    Route::get('repair/index', 'RepairController@index');

    Route::get('repair/show/{id}', 'RepairController@show');

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
