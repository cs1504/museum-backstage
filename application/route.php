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

use \think\Route;

Route::get('think', function () {
    return 'hello,ThinkPHP5!';
});


Route::any('login', 'admin/Login/login');
Route::any('logout', 'admin/Login/logout');







Route::get('api/museum/:id','api/MuseumControlApi/museum');
Route::get('api/museum/search/','api/MuseumControlApi/search');
Route::get('api/museum/nearest/','api/MuseumControlApi/nearest');

Route::get('api/exhibition/:id','api/ExhibitionControlApi/exhibition');
Route::get('api/exhibition/search/','api/ExhibitionControlApi/search');

Route::any('api/admin/login/','api/AdminControlApi/login');
Route::any('api/admin/reg/','api/AdminControlApi/reg');
Route::any('api/admin/logout/','api/AdminControlApi/logout');
Route::any('api/admin/failed', 'api/AdminControlApi/failed');
Route::any('api/admin/getinfo/','api/AdminInfoControlApi/getAdminInfo');

Route::any('api/user/login/','api/UserControlApi/login');
Route::any('api/user/reg/','api/UserControlApi/reg');
Route::any('api/user/logout/','api/UserControlApi/logout');
Route::any('api/user/failed', 'api/UserControlApi/failed');
Route::any('api/user/getinfo/','api/UserInfoControlApi/getUserInfo');

//Route::get('api/news/:id','api/NewsControlApi/news');
Route::get('api/news/search','api/NewsControlApi/search');
Route::get('api/news/latest', 'api/NewsControlApi/latest');
Route::post('api/news/insert', 'api/NewsControlApi/insert');

Route::get('api/audio/:id', 'api/AudioControlApi/audio');
Route::get('api/audiobyuser/:userid', 'api/AudioControlApi/user');
Route::get('api/audio/search/', 'api/AudioControlApi/search');
Route::post('api/audio/add/', 'api/AudioControlApi/add');

Route::any('api/comment/:id', 'api/CommentControlApi/comment');
Route::post('api/comments/', 'api/CommentControlApi/comments');
Route::get('api/comments/museum/:id', 'api/CommentControlApi/museumcomments');
Route::get('api/comments/exhibition/:id', 'api/CommentControlApi/exhibitioncomments');
Route::get('api/comments/news/:id', 'api/CommentControlApi/newscomments');
Route::get('api/comments/audio/:id', 'api/CommentControlApi/audiocomments');

Route::any('api/getqiniutoken', 'api/QiniuToken/getToken');










return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],

];
